<?php

namespace App\Http\Controllers\Api;

use App\Enums\ElectionCategoryType;
use App\Enums\ElectionPeriodStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Election\VoteRequest;
use App\Models\Ballot;
use App\Models\Candidate;
use App\Models\ElectionCategory;
use App\Models\ElectionPeriod;
use App\Models\ElectionSchedule;
use App\Models\Student;
use App\Models\VoteTally;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ElectionController extends Controller
{
    public function activePeriod(Request $request): JsonResponse
    {
        $activePeriod = $this->getActivePeriod();

        return response()->json($activePeriod);
    }

    public function activePeriodCategories(Request $request): JsonResponse
    {
        $this->getActivePeriod();

        $claims = auth()->guard('api')->payload();

        if (! $claims) {
            throw new AuthenticationException;
        }

        $facultyId = '';
        if ($claims->get('role') === UserRole::Mahasiswa->value) {
            $student = Student::query()->find($claims->get('sub'));

            if (! $student) {
                throw new AuthenticationException;
            }

            $facultyId = $student->faculty_id;
        }

        $builder = ElectionCategory::query()
            ->select('election_categories.*')
            ->join('election_periods', 'election_periods.id', 'election_categories.period_id')
            ->where('election_periods.status', '=', ElectionPeriodStatus::Voting->value);

        if ($facultyId != '') {
            $builder->where(function ($query) use ($facultyId) {
                $query->whereIn('election_categories.type', [ElectionCategoryType::President, ElectionCategoryType::Dpm])
                    ->orWhere(function ($query) use ($facultyId) {
                        $query->where('election_categories.type', [ElectionCategoryType::FacultyGovernor])
                            ->where('election_categories.scope_faculty_id', $facultyId);
                    });
            });
        }

        if ($request->has('type')) {
            $builder->where('election_categories.type', $request->type);
        }

        $builder->orderByRaw("
        CASE election_categories.type
            WHEN 'PRESIDENT' THEN 1
            WHEN 'DPM' THEN 2
            WHEN 'FACULTY_GOVERNOR' THEN 3
            ELSE 99
        END ASC
        ");

        $electionCategories = $builder->get();

        return response()->json($electionCategories);
    }

    public function activePeriodCandidates(string $categoryId): JsonResponse
    {
        $activePeriod = $this->getActivePeriod();

        $this->getCategory($categoryId, $activePeriod->id);

        $candidates = Candidate::with('members')
            ->where('category_id', $categoryId)
            ->get();

        $nonEmptyBox = $candidates->where('is_empty_box', false);

        if ($nonEmptyBox->count() > 1) {
            $candidates = $nonEmptyBox->values();
        }

        return response()->json($candidates);
    }

    public function activePeriodCandidatesVotes(VoteRequest $request): JsonResponse
    {
        $user = auth()->guard('api')->user();

        $activePeriod = ElectionPeriod::query()->where('status', ElectionPeriodStatus::Voting)
            ->first();

        if (! $activePeriod) throw new ConflictHttpException('no active election period');

        $validatedData = $request->validated();

        $categoriesCount = ElectionCategory::query()->where(function (Builder $query) use ($user, $activePeriod) {
            $query->where('scope_faculty_id', $user->faculty_id)
                ->orWhere('scope_faculty_id', null)
                ->where('period_id', $activePeriod->id);
        })->count();

        if ($categoriesCount !== count($validatedData['votes']))
            throw new BadRequestHttpException('invalid votes count');

        foreach ($validatedData['votes'] as $vote) {
            $categoryId = $vote['category_id'] ?? null;
            $candidateId = $vote['candidate_id'] ?? null;
            $periodId = $activePeriod->id;

            if ($categoryId && $candidateId) {
                $category = ElectionCategory::query()->where(function (Builder $query) use ($categoryId, $periodId) {
                    $query->where('id', $categoryId)
                        ->Where('period_id', $periodId);
                })->first();

                if (! $category) throw new BadRequestHttpException('there is invalid category id');

                $isValidCandidate = Candidate::query()
                    ->where('id', $candidateId)
                    ->where('category_id', $categoryId)
                    ->exists();

                if (! $isValidCandidate) throw new BadRequestHttpException('there is invalid candidate id');
            }
        }

        $claims = auth()->guard('api')->payload();

        if (! $claims) throw new AuthenticationException;

        if ($claims->get('role') !== UserRole::Mahasiswa->value) throw new AuthenticationException;

        $studentId = $claims->get('sub');

        $student = Student::query()->find($studentId);

        if (! $student) throw new AuthenticationException;

        $schedule = ElectionSchedule::query()
            ->where('period_id', $activePeriod->id)
            ->where('scope_faculty_id', $student->faculty_id)
            ->where('vote_start_at', '<=', now())
            ->where('vote_end_at', '>=', now())
            ->first();

        if (! $schedule) throw new ConflictHttpException('voting is not open for your faculty');

        DB::transaction(function () use ($validatedData, $studentId, $request) {
            foreach ($validatedData['votes'] as $vote) {
                try {
                    Ballot::create([
                        'category_id' => $vote['category_id'],
                        'student_id' => $studentId,
                        'ip_address' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                    ]);
                } catch (QueryException $e) {
                    if ($e->getCode() === '23000') {
                        throw new ConflictHttpException('already voted in this category');
                    }

                    throw $e;
                }

                $tally = VoteTally::query()->firstOrCreate(
                    ['candidate_id' => $vote['candidate_id']],
                    ['vote_count' => 0, 'last_updated' => now()],
                );

                $tally->increment('vote_count', 1, ['last_updated' => now()]);
            }
        });

        return response()->json(['message' => 'success']);
    }

    public function getActivePeriod(): ?ElectionPeriod
    {
        $activePeriod = ElectionPeriod::query()->where('status', ElectionPeriodStatus::Voting)
            ->first();

        if (! $activePeriod) {
            throw new ConflictHttpException('no active election period');
        }

        return $activePeriod;
    }

    public function getCategory(string $categoryId, string $period_id): ?ElectionCategory
    {
        $electionCategory = ElectionCategory::query()->find($categoryId);

        if (! $electionCategory) {
            throw new NotFoundHttpException('election category not found');
        }

        if ($electionCategory->period_id != $period_id) {
            throw new NotFoundHttpException('election category not found');
        }

        return $electionCategory;
    }
}

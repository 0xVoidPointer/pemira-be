<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AuditHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CalonRequest;
use App\Enums\ElectionPeriodStatus;
use App\Models\Candidate;
use App\Models\CandidateMember;
use App\Models\ElectionCategory;
use App\Models\ElectionPeriod;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CalonController extends Controller
{
    public function index(): View
    {
        $activePeriod = ElectionPeriod::where('status', ElectionPeriodStatus::Voting)->first();

        $calons = collect();
        if ($activePeriod) {
            $categoryIds = $activePeriod->categories()->pluck('id');
            $calons = Candidate::with(['category.scopeFaculty', 'members'])
                ->whereIn('category_id', $categoryIds)
                ->orderBy('number')
                ->paginate(10);
        }

        return view('admin.calon.index', compact('calons', 'activePeriod'));
    }

    public function create(): View
    {
        $activePeriod = ElectionPeriod::where('status', ElectionPeriodStatus::Voting)->first();
        $categories = $activePeriod
            ? $activePeriod->categories()->with('scopeFaculty')->get()
            : collect();

        return view('admin.calon.create', compact('categories', 'activePeriod'));
    }

    public function store(CalonRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $data['photo_url'] = $request->file('photo')->store('candidates', 'public');
        }

        $candidate = Candidate::create([
            'category_id' => $data['category_id'],
            'number' => $data['number'],
            'vision' => $data['vision'],
            'mission' => $data['mission'],
            'photo_url' => $data['photo_url'] ?? null,
        ]);

        // Create candidate members (Ketua & Wakil)
        if (! empty($data['nama_ketua'])) {
            CandidateMember::create([
                'candidate_id' => $candidate->id,
                'student_id' => $data['student_ketua_id'] ?? null,
                'role' => 'KETUA',
            ]);
        }

        if (! empty($data['nama_wakil'])) {
            CandidateMember::create([
                'candidate_id' => $candidate->id,
                'student_id' => $data['student_wakil_id'] ?? null,
                'role' => 'WAKIL',
            ]);
        }

        AuditHelper::log('CREATE', 'Candidate', $candidate->id, [
            'number' => $candidate->number,
            'nama_ketua' => $data['nama_ketua'] ?? '-',
        ]);

        return redirect()->route('admin.calon.index')
            ->with('success', 'Calon/Paslon berhasil ditambahkan.');
    }

    public function edit(Candidate $calon): View
    {
        $calon->load(['category.scopeFaculty', 'members']);
        $activePeriod = ElectionPeriod::where('status', ElectionPeriodStatus::Voting)->first();
        $categories = $activePeriod
            ? $activePeriod->categories()->with('scopeFaculty')->get()
            : collect();

        return view('admin.calon.edit', compact('calon', 'categories', 'activePeriod'));
    }

    public function update(CalonRequest $request, Candidate $calon): RedirectResponse
    {
        $data = $request->validated();

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $data['photo_url'] = $request->file('photo')->store('candidates', 'public');
        }

        $calon->update([
            'category_id' => $data['category_id'],
            'number' => $data['number'],
            'vision' => $data['vision'],
            'mission' => $data['mission'],
            'photo_url' => $data['photo_url'] ?? $calon->photo_url,
        ]);

        AuditHelper::log('UPDATE', 'Candidate', $calon->id, ['number' => $calon->number]);

        return redirect()->route('admin.calon.index')
            ->with('success', 'Calon/Paslon berhasil diperbarui.');
    }

    public function destroy(Candidate $calon): RedirectResponse
    {
        AuditHelper::log('DELETE', 'Candidate', $calon->id, ['number' => $calon->number]);

        $calon->delete();

        return redirect()->route('admin.calon.index')
            ->with('success', 'Calon/Paslon berhasil dihapus.');
    }
}

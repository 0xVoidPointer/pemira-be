<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Enums\ElectionPeriodStatus;
use App\Models\Ballot;
use App\Models\Candidate;
use App\Models\ElectionPeriod;
use App\Models\Student;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard.
     */
    public function index(): View
    {
        // Get active period (VOTING status)
        $activePeriod = ElectionPeriod::where('status', ElectionPeriodStatus::Voting)->first();

        $stats = [
            'candidates' => 0,
            'dpt' => 0,
            'ballots' => 0,
        ];

        if ($activePeriod) {
            // Count candidates in active period (through categories)
            $categoryIds = $activePeriod->categories()->pluck('id');

            $stats['candidates'] = Candidate::whereIn('category_id', $categoryIds)->count();
            $stats['dpt'] = Student::where('is_eligible', true)->count();
            $stats['ballots'] = Ballot::whereIn('category_id', $categoryIds)->count();
        }

        return view('admin.dashboard', compact('activePeriod', 'stats'));
    }
}

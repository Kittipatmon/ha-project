<?php

namespace App\Http\Controllers\backend\manpower;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Department;
use App\Models\Division;
use App\Models\Section;
use App\Models\UserType;

class ManpowerController extends Controller
{
    public function dashboard()
    {
        // 1. Key Metrics
        $totalEmployees = User::active()->count();
        
        // Compare with last month for trend (Simplified)
        $lastMonthEmployees = User::where('created_at', '<', now()->startOfMonth())->where('status', User::STATUS_ACTIVE)->count(); 
        // Note: This is an approximation. Real historical data would require a history table.
        $growthRate = $lastMonthEmployees > 0 ? (($totalEmployees - $lastMonthEmployees) / $lastMonthEmployees) * 100 : 0;

        $newHiresCount = User::whereMonth('startwork_date', now()->month)
                             ->whereYear('startwork_date', now()->year)
                             ->count();

        $resignationsCount = User::where('status', User::STATUS_INACTIVE)
                                 ->whereMonth('endwork_date', now()->month)
                                 ->whereYear('endwork_date', now()->year)
                                 ->count();
        
        $turnoverRate = $totalEmployees > 0 ? ($resignationsCount / $totalEmployees) * 100 : 0;

        // Average Tenure (in years)
        $avgTenureDays = User::active()->get()->map(function ($user) {
            return $user->startwork_date ? \Carbon\Carbon::parse($user->startwork_date)->diffInDays(now()) : 0;
        })->avg();
        $avgTenureYears = $avgTenureDays / 365;

        // Gender Stats
        $genderStats = User::active()
            ->select('sex', \DB::raw('count(*) as count'))
            ->groupBy('sex')
            ->pluck('count', 'sex');
        
        $maleCount = $genderStats['ชาย'] ?? 0;
        $femaleCount = $genderStats['หญิง'] ?? 0;

        // 2. Charts Data
        
        // Division Distribution
        $divisionStats = User::active()
            ->join('divisions', 'userskml.division_id', '=', 'divisions.division_id')
            ->select('divisions.division_name', \DB::raw('count(*) as count'))
            ->groupBy('divisions.division_name')
            ->orderByDesc('count')
            ->take(5) // Top 5
            ->get();

        // Section Distribution (Line of Work)
        $sectionStats = User::active()
            ->join('sections', 'userskml.section_id', '=', 'sections.section_id')
            ->select('sections.section_code', \DB::raw('count(*) as count'))
            ->groupBy('sections.section_code')
            ->orderByDesc('count')
            ->take(5)
            ->get();

        // Workplace Distribution
        $workplaceStats = User::active()
            ->select('workplace', \DB::raw('count(*) as count'))
            ->whereNotNull('workplace')
            ->groupBy('workplace')
            ->get();

        // Level Hierarchy
        $levelStats = User::active()
            ->select('level_user', \DB::raw('count(*) as count'))
            ->groupBy('level_user')
            ->get()
            ->map(function($item) {
                $options = User::getLevelUserOptions();
                $item->label = $options[$item->level_user]['label'] ?? 'Unknown';
                $item->color = $options[$item->level_user]['color'] ?? 'gray';
                return $item;
            })
            ->sortBy('level_user'); // Sort by level hierarchy

        // 3. Tables
        $recentHires = User::active()
            ->with(['department', 'division'])
            ->orderBy('employee_code', 'desc')
            ->take(5)
            ->get();

        // Probation / Contract Expiry (Next 30 days)
        // Assuming probation is 119 days from startwork_date
        $probationUpcoming = User::active()
            ->get()
            ->filter(function($user) {
                if (!$user->startwork_date) return false;
                $probationDate = \Carbon\Carbon::parse($user->startwork_date)->addDays(119);
                return $probationDate->between(now(), now()->addDays(30));
            })
            ->take(5);

        return view('manpower.dashboard', compact(
            'totalEmployees', 'growthRate', 'maleCount', 'femaleCount',
            'newHiresCount', 'resignationsCount', 'turnoverRate',
            'avgTenureYears', 'divisionStats', 'sectionStats', 'workplaceStats',
            'levelStats', 'recentHires', 'probationUpcoming'
        ));
    }

    public function index()
    {
        return view('manpower.index');
    }
}

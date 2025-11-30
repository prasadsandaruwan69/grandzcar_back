<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\News;
use App\Models\reviews;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboadController extends Controller
{
    /**
     * GET /api/admin/dashboard
     * Returns all admin dashboard statistics
     */
    public function index()
    {
        $today = Carbon::today();

        // Vehicles Stats
        $totalVehicles = Vehicle::count();
        $todayVehicles = Vehicle::whereDate('created_at', $today)->count();

        // News Stats
        $totalNews = News::count();
        $todayNews = News::whereDate('created_at', $today)->count();

        // Reviews Stats
        $totalReviews = reviews::count();
        $todayReviews = reviews::whereDate('created_at', $today)->count();

        // Optional: Verified reviews count
        $verifiedReviews = reviews::where('verified', true)->count();

        return response()->json([
            'success' => true,
            'data' => [
                'vehicles' => [
                    'total' => $totalVehicles,
                    'today' => $todayVehicles,
                ],
                'news' => [
                    'total' => $totalNews,
                    'today' => $todayNews,
                ],
                'reviews' => [
                    'total' => $totalReviews,
                    'today' => $todayReviews,
                    'verified' => $verifiedReviews,
                ],
                'summary' => [
                    'total_content' => $totalVehicles + $totalNews + $totalReviews,
                    'today_added' => $todayVehicles + $todayNews + $todayReviews,
                    'last_updated' => now()->format('Y-m-d H:i:s'),
                ]
            ]
        ], 200);
    }
}
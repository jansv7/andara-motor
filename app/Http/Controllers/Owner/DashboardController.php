<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Motorcycle;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $availableCount = Motorcycle::query()->where('status', 'available')->count();
        $bookedCount = Motorcycle::query()->where('status', 'booked')->count();
        $soldCount = Motorcycle::query()->where('status', 'sold')->count();
        $brandCount = Brand::query()->count();

        $recentMotorcycles = Motorcycle::query()
            ->with(['brand:id,name', 'primaryPhoto'])
            ->latest('id')
            ->take(6)
            ->get();

        return view('owner.dashboard', [
            'availableCount' => $availableCount,
            'bookedCount' => $bookedCount,
            'soldCount' => $soldCount,
            'brandCount' => $brandCount,
            'recentMotorcycles' => $recentMotorcycles,
        ]);
    }
}

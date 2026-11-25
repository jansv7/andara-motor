<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Motorcycle;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function home(): View
    {
        $store = Setting::storeProfile();

        $featuredMotorcycles = Motorcycle::query()
            ->publicSelect()
            ->publicVisible()
            ->with(['brand:id,name,slug', 'primaryPhoto'])
            ->orderByDesc('is_featured')
            ->latest('id')
            ->take(5)
            ->get();

        $brands = Brand::query()
            ->withCount([
                'motorcycles as available_count' => fn ($query) => $query->whereIn('status', ['available', 'booked']),
            ])
            ->orderBy('name')
            ->get();

        $categoryCounts = Motorcycle::query()
            ->publicVisible()
            ->selectRaw('category, COUNT(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category');

        $totalReady = (int) $categoryCounts->sum();

        return view('public.home', [
            'store' => $store,
            'featuredMotorcycles' => $featuredMotorcycles,
            'brands' => $brands,
            'categoryCounts' => $categoryCounts,
            'totalReady' => $totalReady,
        ]);
    }

    public function index(Request $request): View
    {
        $store = Setting::storeProfile();
        $filters = $request->only([
            'q',
            'brand',
            'category',
            'transmission',
            'min_price',
            'max_price',
            'min_year',
            'max_year',
            'sort',
        ]);

        $query = Motorcycle::query()
            ->publicSelect()
            ->publicVisible()
            ->with(['brand:id,name,slug', 'primaryPhoto'])
            ->filter($filters);

        match ($filters['sort'] ?? 'newest') {
            'price_asc' => $query->orderBy('selling_price'),
            'price_desc' => $query->orderByDesc('selling_price'),
            'year_desc' => $query->orderByDesc('year'),
            'mileage_asc' => $query->orderBy('mileage'),
            default => $query->latest('id'),
        };

        $motorcycles = $query->paginate(12)->withQueryString();
        $brands = Brand::query()->orderBy('name')->get(['id', 'name', 'slug']);

        return view('public.catalog.index', [
            'store' => $store,
            'motorcycles' => $motorcycles,
            'brands' => $brands,
            'filters' => $filters,
        ]);
    }

    public function show(string $slug): View
    {
        $store = Setting::storeProfile();

        $motorcycle = Motorcycle::query()
            ->publicSelect()
            ->with(['brand:id,name,slug', 'photos'])
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedMotorcycles = Motorcycle::query()
            ->publicSelect()
            ->publicVisible()
            ->with(['brand:id,name,slug', 'primaryPhoto'])
            ->where('id', '!=', $motorcycle->id)
            ->where(function ($query) use ($motorcycle): void {
                $query->where('brand_id', $motorcycle->brand_id)
                    ->orWhere('category', $motorcycle->category);
            })
            ->latest('id')
            ->take(4)
            ->get();

        return view('public.catalog.show', [
            'store' => $store,
            'motorcycle' => $motorcycle,
            'relatedMotorcycles' => $relatedMotorcycles,
        ]);
    }
}

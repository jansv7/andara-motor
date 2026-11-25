<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\StoreBrandRequest;
use App\Http\Requests\Owner\UpdateBrandRequest;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BrandController extends Controller
{
    public function index(): View
    {
        $brands = Brand::query()
            ->withCount('motorcycles')
            ->orderBy('name')
            ->paginate(15);

        return view('owner.brands.index', [
            'brands' => $brands,
        ]);
    }

    public function create(): View
    {
        return view('owner.brands.create');
    }

    public function store(StoreBrandRequest $request): RedirectResponse
    {
        $name = trim((string) $request->validated('name'));

        Brand::query()->create([
            'name' => $name,
            'slug' => Str::slug($name),
        ]);

        return redirect()
            ->route('owner.brands.index')
            ->with('success', "Merek {$name} berhasil ditambahkan.");
    }

    public function edit(Brand $merek): View
    {
        return view('owner.brands.edit', [
            'brand' => $merek,
        ]);
    }

    public function update(UpdateBrandRequest $request, Brand $merek): RedirectResponse
    {
        $name = trim((string) $request->validated('name'));

        $merek->update([
            'name' => $name,
            'slug' => Str::slug($name),
        ]);

        return redirect()
            ->route('owner.brands.index')
            ->with('success', "Merek berhasil diperbarui menjadi {$name}.");
    }

    public function destroy(Brand $merek): RedirectResponse
    {
        if ($merek->motorcycles()->withTrashed()->exists()) {
            return redirect()
                ->route('owner.brands.index')
                ->with('error', "Merek {$merek->name} tidak bisa dihapus karena masih memiliki data unit motor.");
        }

        $brandName = $merek->name;
        $merek->delete();

        return redirect()
            ->route('owner.brands.index')
            ->with('success', "Merek {$brandName} berhasil dihapus.");
    }
}

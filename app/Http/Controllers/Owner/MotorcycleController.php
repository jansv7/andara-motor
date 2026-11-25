<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\StoreMotorcycleRequest;
use App\Http\Requests\Owner\UpdateMotorcycleRequest;
use App\Models\Brand;
use App\Models\Motorcycle;
use App\Models\MotorcyclePhoto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MotorcycleController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->only(['q', 'brand', 'status']);

        $motorcycles = Motorcycle::query()
            ->with(['brand:id,name', 'primaryPhoto'])
            ->filter($filters)
            ->latest('id')
            ->paginate(12)
            ->withQueryString();

        $brands = Brand::query()->orderBy('name')->get(['id', 'name']);

        return view('owner.motorcycles.index', [
            'motorcycles' => $motorcycles,
            'brands' => $brands,
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        $brands = Brand::query()->orderBy('name')->get(['id', 'name']);

        return view('owner.motorcycles.create', [
            'brands' => $brands,
        ]);
    }

    public function store(StoreMotorcycleRequest $request): RedirectResponse
    {
        $data = $this->prepareAttributes($request);

        $motorcycle = DB::transaction(function () use ($data, $request): Motorcycle {
            $motorcycle = Motorcycle::query()->create($data);

            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('motorcycles', 'public');

                MotorcyclePhoto::query()->create([
                    'motorcycle_id' => $motorcycle->id,
                    'path' => $path,
                    'is_primary' => true,
                    'sort_order' => 0,
                ]);
            }

            return $motorcycle;
        });

        return redirect()
            ->route('owner.motorcycles.index')
            ->with('success', "Unit {$motorcycle->fullName()} ({$motorcycle->code}) berhasil ditambahkan ke katalog.");
    }

    public function show(Motorcycle $motorcycle): View
    {
        $motorcycle->load(['brand', 'photos', 'reconditioningCosts', 'sale']);

        return view('owner.motorcycles.show', [
            'motorcycle' => $motorcycle,
        ]);
    }

    public function edit(Motorcycle $motorcycle): View
    {
        $motorcycle->load('primaryPhoto');
        $brands = Brand::query()->orderBy('name')->get(['id', 'name']);

        return view('owner.motorcycles.edit', [
            'motorcycle' => $motorcycle,
            'brands' => $brands,
        ]);
    }

    public function update(UpdateMotorcycleRequest $request, Motorcycle $motorcycle): RedirectResponse
    {
        $data = $this->prepareAttributes($request);

        DB::transaction(function () use ($motorcycle, $data, $request): void {
            $motorcycle->update($data);

            if ($request->hasFile('photo')) {
                $path = $request->file('photo')->store('motorcycles', 'public');

                $motorcycle->photos()->update(['is_primary' => false]);

                MotorcyclePhoto::query()->create([
                    'motorcycle_id' => $motorcycle->id,
                    'path' => $path,
                    'is_primary' => true,
                    'sort_order' => 0,
                ]);
            }
        });

        return redirect()
            ->route('owner.motorcycles.index')
            ->with('success', "Data unit {$motorcycle->fullName()} ({$motorcycle->code}) berhasil diperbarui.");
    }

    public function destroy(Motorcycle $motorcycle): RedirectResponse
    {
        if ($motorcycle->status === 'sold') {
            return redirect()
                ->route('owner.motorcycles.index')
                ->with('error', "Unit {$motorcycle->code} sudah terjual sehingga tidak dapat dihapus.");
        }

        $code = $motorcycle->code;
        $motorcycle->delete();

        return redirect()
            ->route('owner.motorcycles.index')
            ->with('success', "Unit {$code} berhasil dihapus dari daftar aktif.");
    }

    public function updateStatus(Request $request, Motorcycle $motorcycle): RedirectResponse
    {
        if ($motorcycle->status === 'sold') {
            return redirect()
                ->back()
                ->with('error', 'Status unit yang sudah terjual tidak dapat diubah secara manual.');
        }

        $validated = $request->validate([
            'status' => ['required', 'in:available,booked'],
        ], [
            'status.in' => 'Status hanya bisa diubah antara Tersedia dan Dipesan.',
        ]);

        $motorcycle->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->back()
            ->with('success', "Status unit {$motorcycle->code} diubah menjadi {$motorcycle->statusLabel()}.");
    }

    /**
     * @return array<string, mixed>
     */
    protected function prepareAttributes(StoreMotorcycleRequest $request): array
    {
        $validated = $request->validated();
        unset($validated['photo']);

        $validated['plate_region'] = filled($validated['plate_region'] ?? null)
            ? Str::upper(trim((string) $validated['plate_region']))
            : null;
        $validated['engine_ever_opened'] = $request->boolean('engine_ever_opened');
        $validated['has_bpkb'] = $request->boolean('has_bpkb');
        $validated['has_stnk'] = $request->boolean('has_stnk');
        $validated['has_faktur'] = $request->boolean('has_faktur');
        $validated['is_negotiable'] = $request->boolean('is_negotiable');
        $validated['is_featured'] = $request->boolean('is_featured');

        return $validated;
    }
}

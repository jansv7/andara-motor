<?php

namespace App\Http\Requests\Owner;

use Illuminate\Foundation\Http\FormRequest;

class StoreMotorcycleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, list<mixed>>
     */
    public function rules(): array
    {
        $maxYear = (int) date('Y');

        return [
            'brand_id' => ['required', 'integer', 'exists:brands,id'],
            'model' => ['required', 'string', 'max:100'],
            'category' => ['required', 'in:matic,bebek,sport,trail,lainnya'],
            'year' => ['required', 'integer', 'min:1990', "max:{$maxYear}"],
            'color' => ['required', 'string', 'max:30'],
            'engine_cc' => ['required', 'integer', 'min:50', 'max:2500'],
            'transmission' => ['required', 'in:matic,manual,kopling'],
            'mileage' => ['required', 'integer', 'min:0'],
            'plate_region' => ['nullable', 'string', 'max:5'],
            'setting_condition' => ['required', 'in:standar,modifikasi_ringan,modifikasi_berat'],
            'modification_notes' => ['nullable', 'string', 'max:1000'],
            'engine_ever_opened' => ['nullable', 'boolean'],
            'engine_notes' => ['nullable', 'string', 'max:1000'],
            'has_bpkb' => ['nullable', 'boolean'],
            'has_stnk' => ['nullable', 'boolean'],
            'has_faktur' => ['nullable', 'boolean'],
            'tax_expired_at' => ['nullable', 'date'],
            'warranty' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:3000'],
            'purchase_price' => ['required', 'integer', 'min:0'],
            'purchase_date' => ['required', 'date', 'before_or_equal:today'],
            'purchase_source' => ['nullable', 'string', 'max:100'],
            'selling_price' => ['required', 'integer', 'min:0'],
            'is_negotiable' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        $maxYear = (int) date('Y');

        return [
            'brand_id.required' => 'Merek wajib dipilih.',
            'brand_id.exists' => 'Merek yang dipilih tidak valid.',
            'model.required' => 'Model motor wajib diisi.',
            'category.required' => 'Kategori motor wajib dipilih.',
            'year.required' => 'Tahun motor wajib diisi.',
            'year.min' => 'Tahun motor minimal 1990.',
            'year.max' => "Tahun motor tidak boleh lebih dari {$maxYear}.",
            'color.required' => 'Warna motor wajib diisi.',
            'engine_cc.required' => 'Kapasitas mesin (cc) wajib diisi.',
            'transmission.required' => 'Transmisi wajib dipilih.',
            'mileage.required' => 'Jarak tempuh (km) wajib diisi.',
            'mileage.min' => 'Jarak tempuh tidak boleh negatif.',
            'purchase_price.required' => 'Harga beli wajib diisi.',
            'purchase_price.min' => 'Harga beli tidak boleh negatif.',
            'purchase_date.required' => 'Tanggal pembelian wajib diisi.',
            'purchase_date.before_or_equal' => 'Tanggal pembelian tidak boleh di masa depan.',
            'selling_price.required' => 'Harga jual wajib diisi.',
            'selling_price.min' => 'Harga jual tidak boleh negatif.',
            'photo.image' => 'File foto harus berupa gambar.',
            'photo.mimes' => 'Format foto harus JPG, PNG, atau WebP.',
            'photo.max' => 'Ukuran foto maksimal 2 MB.',
        ];
    }
}

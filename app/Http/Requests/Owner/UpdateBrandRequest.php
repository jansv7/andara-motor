<?php

namespace App\Http\Requests\Owner;

use App\Models\Brand;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBrandRequest extends FormRequest
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
        /** @var Brand|null $brand */
        $brand = $this->route('merek');

        return [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('brands', 'name')->ignore($brand?->id),
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama merek wajib diisi.',
            'name.max' => 'Nama merek maksimal 50 karakter.',
            'name.unique' => 'Nama merek tersebut sudah terdaftar.',
        ];
    }
}

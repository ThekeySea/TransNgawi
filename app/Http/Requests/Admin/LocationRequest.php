<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LocationRequest extends FormRequest
{
    /**
     * Otorisasi ditangani middleware `admin` di route.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        $location = $this->route('location');

        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('locations', 'name')->ignore($location?->id)],
            'is_capital' => ['sometimes', 'boolean'],
            'is_important' => ['sometimes', 'boolean'],
        ];
    }
}

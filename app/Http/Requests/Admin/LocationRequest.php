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
            'stop_points' => ['nullable', 'array'],
            'stop_points.*.id' => ['nullable', 'integer'],
            'stop_points.*.name' => ['required_with:stop_points', 'string', 'max:255'],
            'stop_points.*.address' => ['nullable', 'string', 'max:255'],
            'stop_points.*.is_important_point' => ['nullable', 'boolean'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator): void {
            $isLocationImportant = (bool) ($this->is_important ?? false);
            $stopPoints = $this->stop_points ?? [];

            if (! $isLocationImportant && is_array($stopPoints)) {
                foreach ($stopPoints as $index => $point) {
                    $isPointImportant = (bool) ($point['is_important_point'] ?? false);

                    if ($isPointImportant) {
                        $validator->errors()->add(
                            "stop_points.{$index}.is_important_point",
                            'Titik pemberhentian hanya bisa ditandai sebagai tempat penting jika lokasi induk bertanda "Tempat Penting".'
                        );
                    }
                }
            }
        });
    }
}

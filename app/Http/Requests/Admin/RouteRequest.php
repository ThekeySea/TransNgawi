<?php

namespace App\Http\Requests\Admin;

use App\Enums\ServiceCategory;
use App\Models\Location;
use App\Models\Route;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RouteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $route = $this->route('route');

        return [
            'origin_id' => ['required', 'exists:locations,id'],
            'destination_id' => ['required', 'exists:locations,id'],
            'service_category' => ['required', Rule::enum(ServiceCategory::class)],
        ];
    }

    public function withValidator(\Illuminate\Validation\Validator $validator): void
    {
        $validator->after(function (\Illuminate\Validation\Validator $validator): void {
            if ($validator->errors()->any()) {
                return;
            }

            if ($this->input('origin_id') === $this->input('destination_id')) {
                $validator->errors()->add('destination_id', 'Kota asal dan tujuan tidak boleh sama.');
                return;
            }

            $service = ServiceCategory::from($this->input('service_category'));
            $origin = Location::find($this->input('origin_id'));
            $destination = Location::find($this->input('destination_id'));

            if (! $origin || ! $destination) {
                return;
            }

            if ($service === ServiceCategory::ANTIBU) {
                if (! $origin->is_capital || ! $destination->is_capital) {
                    $validator->errors()->add('origin_id', 'ANTIBU hanya boleh memakai rute antar ibu kota (kedua kota harus ibu kota).');
                }
            }

            if ($service === ServiceCategory::SATSET) {
                if (! $origin->is_important || ! $destination->is_important) {
                    $validator->errors()->add('origin_id', 'SATSET hanya boleh memakai rute antar tempat penting (kedua titik harus penting).');
                }
            }

            $duplicate = Route::where('origin_id', $this->input('origin_id'))
                ->where('destination_id', $this->input('destination_id'))
                ->where('service_category', $service);

            if ($route = $this->route('route')) {
                $duplicate->where('id', '!=', $route->id);
            }

            if ($duplicate->exists()) {
                $validator->errors()->add('origin_id', 'Rute dengan kombinasi asal, tujuan, dan kategori layanan ini sudah ada.');
            }
        });
    }
}

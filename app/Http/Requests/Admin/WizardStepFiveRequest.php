<?php

namespace App\Http\Requests\Admin;

use App\Enums\ServiceCategory;
use App\Models\Route;
use App\Models\StopPoint;
use Illuminate\Foundation\Http\FormRequest;

class WizardStepFiveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        foreach (['exterior_photos', 'interior_photos', 'facility_photos'] as $field) {
            if ($this->has($field) && is_array($this->input($field))) {
                $this->merge([$field => array_values(array_filter($this->input($field), fn ($v) => filled($v)))]);
            }
        }
    }

    public function rules(): array
    {
        return [
            'amenities' => ['nullable', 'array'],
            'amenities.*' => ['string', 'in:WiFi,Toilet,USB,Selimut,Cemilan,Bantal,Makanan'],
            'exterior_photos' => ['nullable', 'array', 'max:5'],
            'exterior_photos.*' => ['url', 'max:500'],
            'interior_photos' => ['nullable', 'array', 'max:5'],
            'interior_photos.*' => ['url', 'max:500'],
            'facility_photos' => ['nullable', 'array', 'max:5'],
            'facility_photos.*' => ['url', 'max:500'],
            'origin_stop_point_id' => ['nullable', 'integer', 'exists:stop_points,id'],
            'destination_stop_point_id' => ['nullable', 'integer', 'exists:stop_points,id'],
            'origin_address' => ['nullable', 'string', 'max:255'],
            'destination_address' => ['nullable', 'string', 'max:255'],
            'rest_stop_name' => ['nullable', 'string', 'max:100'],
            'rest_stop_address' => ['nullable', 'string', 'max:255'],
            'policy' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function withValidator(\Illuminate\Validation\Validator $validator): void
    {
        $validator->after(function (\Illuminate\Validation\Validator $validator): void {
            $wizard = session('admin.trip_wizard', []);
            $service = ServiceCategory::tryFrom((string) ($wizard['service_category'] ?? ''));

            if (! $service) {
                return;
            }

            $route = Route::with(['origin', 'destination'])->find($wizard['route_id'] ?? null);

            if (! $route) {
                return;
            }

            // Validate origin stop point belongs to origin location
            if ($this->filled('origin_stop_point_id')) {
                $originStopPoint = StopPoint::find($this->input('origin_stop_point_id'));
                if ($originStopPoint && $originStopPoint->location_id !== $route->origin_id) {
                    $validator->errors()->add('origin_stop_point_id', 'Titik berangkat harus berada di kota asal yang dipilih.');
                }
            }

            // Validate destination stop point belongs to destination location
            if ($this->filled('destination_stop_point_id')) {
                $destStopPoint = StopPoint::find($this->input('destination_stop_point_id'));
                if ($destStopPoint && $destStopPoint->location_id !== $route->destination_id) {
                    $validator->errors()->add('destination_stop_point_id', 'Titik destinasi harus berada di kota tujuan yang dipilih.');
                }
            }

            // For SATSET, both stop points must be important points
            if ($service === ServiceCategory::SATSET) {
                if ($this->filled('origin_stop_point_id')) {
                    $originSp = StopPoint::find($this->input('origin_stop_point_id'));
                    if ($originSp && ! $originSp->is_important_point) {
                        $validator->errors()->add('origin_stop_point_id', 'SATSET hanya boleh menggunakan titik berangkat yang merupakan tempat penting.');
                    }
                }
                if ($this->filled('destination_stop_point_id')) {
                    $destSp = StopPoint::find($this->input('destination_stop_point_id'));
                    if ($destSp && ! $destSp->is_important_point) {
                        $validator->errors()->add('destination_stop_point_id', 'SATSET hanya boleh menggunakan titik destinasi yang merupakan tempat penting.');
                    }
                }
            }
        });
    }
}

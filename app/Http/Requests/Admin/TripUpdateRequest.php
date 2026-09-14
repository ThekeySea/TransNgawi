<?php

namespace App\Http\Requests\Admin;

use App\Enums\BusStatus;
use App\Models\Bus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TripUpdateRequest extends FormRequest
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
        $trip = $this->route('trip');

        return [
            'bus_id' => ['required', 'exists:buses,id'],
            'departs_at' => ['required', 'date', 'after:now'],
            'arrives_at' => ['required', 'date', 'after:departs_at'],
            'fares' => ['required', 'array', 'min:1'],
            'fares.*' => ['required', 'integer', 'min:1000', 'max:10000000'],
            'amenities' => ['nullable', 'array'],
            'amenities.*' => ['string', 'in:WiFi,Toilet,USB,Selimut,Cemilan,Bantal,Makanan'],
            'exterior_photos' => ['nullable', 'array', 'max:5'],
            'exterior_photos.*' => ['url', 'max:500'],
            'interior_photos' => ['nullable', 'array', 'max:5'],
            'interior_photos.*' => ['url', 'max:500'],
            'facility_photos' => ['nullable', 'array', 'max:5'],
            'facility_photos.*' => ['url', 'max:500'],
        ];
    }

    public function withValidator(\Illuminate\Validation\Validator $validator): void
    {
        $validator->after(function (\Illuminate\Validation\Validator $validator): void {
            if ($validator->errors()->any()) {
                return;
            }

            $trip = $this->route('trip');
            $bus = Bus::find($this->input('bus_id'));

            if (! $bus) {
                return;
            }

            // Bus must be IDLE, or already assigned to THIS trip
            if (! $bus->status->canBeAssigned() && $bus->id !== $trip->bus_id) {
                $validator->errors()->add('bus_id', 'Bus "'.$bus->plate_number.'" berstatus '.$bus->status->label().' dan tidak bisa ditugaskan.');
            }

            // Validate fare classes match bus template
            $error = app(\App\Services\TripCreationService::class)
                ->fareClassesError($bus, array_keys($this->input('fares', [])));

            if ($error) {
                $validator->errors()->add('fares', $error);
            }
        });
    }
}

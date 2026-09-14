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

    public function rules(): array
    {
        $trip = $this->route('trip');

        return [
            'bus_id' => ['required', 'exists:buses,id'],
            'departs_at' => ['required', 'date', 'after:now'],
            'arrives_at' => ['required', 'date', 'after:departs_at'],
            'fares' => ['required', 'array', 'min:1'],
            'fares.*' => ['required', 'integer', 'min:1000', 'max:10000000'],
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

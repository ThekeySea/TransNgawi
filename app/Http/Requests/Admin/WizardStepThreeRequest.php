<?php

namespace App\Http\Requests\Admin;

use App\Enums\BusStatus;
use App\Models\Bus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WizardStepThreeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($validator->errors()->any()) {
                return;
            }

            $bus = Bus::find($this->input('bus_id'));
            if ($bus && ! $bus->status->canBeAssigned()) {
                $validator->errors()->add('bus_id', 'Bus "'.$bus->plate_number.'" berstatus '.$bus->status->label().' dan tidak bisa ditugaskan ke trip baru.');
            }
        });
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'bus_id' => ['required', 'exists:buses,id'],
            'departs_at' => ['required', 'date', 'after:now'],
            'arrives_at' => ['required', 'date', 'after:departs_at'],
        ];
    }
}

<?php

namespace App\Http\Requests\Admin;

use App\Models\Bus;
use App\Services\TripCreationService;
use Illuminate\Foundation\Http\FormRequest;

class WizardStepFourRequest extends FormRequest
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
        return [
            'fares' => ['required', 'array', 'min:1'],
            'fares.*' => ['required', 'integer', 'min:1000', 'max:10000000'],
        ];
    }

    public function withValidator(\Illuminate\Validation\Validator $validator): void
    {
        $validator->after(function (\Illuminate\Validation\Validator $validator): void {
            $bus = Bus::find(session('admin.trip_wizard.bus_id'));

            if (! $bus) {
                $validator->errors()->add('fares', 'Pilih bus dulu pada Langkah 3.');

                return;
            }

            $error = app(TripCreationService::class)
                ->fareClassesError($bus, array_keys($this->input('fares', [])));

            if ($error) {
                $validator->errors()->add('fares', $error);
            }
        });
    }
}

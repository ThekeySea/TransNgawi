<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class WizardStepFiveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
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
            'origin_address' => ['nullable', 'string', 'max:255'],
            'destination_address' => ['nullable', 'string', 'max:255'],
            'rest_stop_name' => ['nullable', 'string', 'max:100'],
            'rest_stop_address' => ['nullable', 'string', 'max:255'],
            'policy' => ['nullable', 'string', 'max:2000'],
        ];
    }
}

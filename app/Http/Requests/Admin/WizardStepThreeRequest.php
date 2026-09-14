<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class WizardStepThreeRequest extends FormRequest
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
            'bus_id' => ['required', 'exists:buses,id'],
            'departs_at' => ['required', 'date', 'after:now'],
            'arrives_at' => ['required', 'date', 'after:departs_at'],
        ];
    }
}

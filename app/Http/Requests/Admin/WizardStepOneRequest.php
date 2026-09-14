<?php

namespace App\Http\Requests\Admin;

use App\Enums\ServiceCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WizardStepOneRequest extends FormRequest
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
            'service_category' => ['required', Rule::enum(ServiceCategory::class)],
        ];
    }
}

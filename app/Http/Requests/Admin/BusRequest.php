<?php

namespace App\Http\Requests\Admin;

use App\Enums\BusModelType;
use App\Enums\BusStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BusRequest extends FormRequest
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
        $bus = $this->route('bus');

        return [
            'plate_number' => ['required', 'string', 'max:50', Rule::unique('buses', 'plate_number')->ignore($bus?->id)],
            'model_type' => ['required', Rule::enum(BusModelType::class)],
            'status' => ['required', Rule::enum(BusStatus::class)],
        ];
    }
}

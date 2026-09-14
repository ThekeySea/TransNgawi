<?php

namespace App\Http\Requests\Admin;

use App\Enums\ServiceCategory;
use App\Models\Route;
use App\Services\TripCreationService;
use Illuminate\Foundation\Http\FormRequest;

class WizardStepTwoRequest extends FormRequest
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
            'route_id' => ['required', 'exists:routes,id'],
        ];
    }

    public function withValidator(\Illuminate\Validation\Validator $validator): void
    {
        $validator->after(function (\Illuminate\Validation\Validator $validator): void {
            $service = ServiceCategory::tryFrom((string) session('admin.trip_wizard.service_category'));

            if (! $service) {
                $validator->errors()->add('route_id', 'Pilih layanan dulu pada Langkah 1.');

                return;
            }

            $route = Route::with(['origin', 'destination'])->find($this->input('route_id'));

            if (! $route) {
                return;
            }

            $error = app(TripCreationService::class)->routeErrorForService($route, $service);

            if ($error) {
                $validator->errors()->add('route_id', $error);
            }
        });
    }
}

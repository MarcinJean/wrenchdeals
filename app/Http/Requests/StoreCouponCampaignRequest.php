<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCouponCampaignRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('service_manager');
    }

    public function rules(): array
    {
        return [
            'name'               => ['required','string','max:255'],
            'start_at'           => ['nullable','date'],
            'expires_at'         => ['required','date','after_or_equal:start_at'],
            'generation_limit'   => ['nullable','integer','min:1'],
            'service_categories' => ['array','min:1'],
            'service_categories.*' => ['integer','exists:service_categories,id'],
            'vehicle_makes'      => ['array','min:1'],
            'vehicle_makes.*'    => ['integer','exists:vehicle_makes,id'],
            'dealers'            => ['array','min:1'],
            'dealers.*'          => ['integer','exists:dealers,id'],
        ];
    }
}

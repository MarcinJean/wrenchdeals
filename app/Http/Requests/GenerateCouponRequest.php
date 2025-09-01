<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // guests allowed
    }

    public function rules(): array
    {
        return [
            'campaign_id' => ['required', 'exists:coupon_campaigns,id'],
            'contact' => ['required', 'string'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // guests and users both can email
    }

    public function rules(): array
    {
        return [
            'code'    => ['required','string','exists:coupon_instances,code'],
            'email'   => ['nullable','email'],  // if provided (guest), otherwise use user’s email
        ];
    }
}

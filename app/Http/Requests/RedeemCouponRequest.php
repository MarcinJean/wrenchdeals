<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RedeemCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        //return $this->user()->hasAnyRole(['advisor', 'service_manager']);
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string'],
            'repair_order_id' => ['required', 'string','max:10'],
        ];
    }
}

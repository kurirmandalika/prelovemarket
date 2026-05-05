<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SellerProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        $profile = $this->user()?->sellerProfile;

        return [
            'shop_name' => [
                'required',
                'string',
                'max:120',
                Rule::unique('seller_profiles', 'shop_name')->ignore($profile?->id),
            ],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'min:10', 'max:1000'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }
}

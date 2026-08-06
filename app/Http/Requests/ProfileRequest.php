<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        // 'user_id' => 'required|exists:users,id',
        'marital_status' => 'required|in:Single,Married,Divorced',
        'dob' => 'required|date',
        'anniversary_date' => 'nullable|required_if:marital_status,Married|date',
        'address' => 'required|string|max:500',
        'city' => 'required|string|max:100',
        'state' => 'required|string|max:100',
        'pincode' => 'required|digits:6',

        ];
    }
}

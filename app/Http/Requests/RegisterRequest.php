<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            // Mandatory user fields
            'name' => 'required|string|max:255',
            'mobile' => 'required|digits:10|unique:users,mobile',
            'password' => 'required|string|min:8|confirmed',

            // Optional user details
            'email' => 'nullable|email|max:255|unique:users,email',
            'gender' => 'nullable|in:Male,Female,Other,PNS',
            'marital_status' => 'nullable|in:Single,Married,Divorced',
            'dob' => 'nullable|date',
            'anniversary_date' => 'required_if:marital_status,Married|nullable|date',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'pincode' => 'nullable|string|max:10',
            'designation' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'source_type' => 'nullable|in:registration,community,gaushala_donation,bhojanshala_donation',
            'is_donor' => 'nullable|boolean',

            // Family members array
            'family_members' => 'nullable|array',
            'family_members.*.name' => 'required_with:family_members|string|max:255',
            'family_members.*.relation' => 'required_with:family_members|string|max:255',
            'family_members.*.dob' => 'required_with:family_members|date',
            'family_members.*.anniversary_date' => 'nullable|date',
        ];
    }
}

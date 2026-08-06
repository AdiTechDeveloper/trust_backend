<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CommunityRequest extends FormRequest
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
             'name' => 'required|string|max:100',

        'mobile' => 'required|digits:10|unique:community_members,mobile',

        'gender' => 'nullable|in:Male,Female',

        'dob' => 'nullable|date',

        'marital_status' => 'nullable|in:Single,Married,Divorced',

        'anniversary_date' => 'required_if:marital_status,Married|nullable|date',

        'designation' => 'nullable|string|max:100',

        'company_name' => 'nullable|string|max:100',

        'city' => 'nullable|string|max:100',

        'state' => 'nullable|string|max:100',

        'address' => 'nullable|string',

        'family_members' => 'nullable|array',

        'family_members.*.name' => 'required_with:family_members|string|max:100',

        'family_members.*.relation' => 'required_with:family_members|string|max:50',

        'family_members.*.dob' => 'required_with:family_members|date',

        'family_members.*.anniversary_date' => 'nullable|date',
        ];
    }
}

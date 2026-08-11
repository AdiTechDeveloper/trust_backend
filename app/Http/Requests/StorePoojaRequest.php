<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePoojaRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:poojas,name',
            'slug' => 'nullable|string|max:255|unique:poojas,slug',
            'short_description' => 'nullable|string|max:500',
            'description' => 'required|string',
            'price'  => 'required|string',
            'duration' => 'required|string|max:100',
            'timings' => 'nullable|string|max:255',
            'location' => 'nullable | string | max:255',
            'benefits' => 'nullable | array',
             'benefits.*' => 'nullable|string|max:255',
            'samagri' => 'nullable|array',
            'samagri.*' => 'nullable|string|max:255',
            'process' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery' => 'nullable | array',
            'gallery.*' => 'image|mines:jpg,jpeg,png,webp|max:2048',
            'is_featured' => 'nullable | boolean',
            'status' => 'nullable | boolean',
            'sort_order' => 'nullable|integer|min:0',
         ]; 
    }

    public funcion message(): array
    {
        return [
            'name.required' => 'Puja name is Required.',
            'name.unique' => 'This puja is already exists.'
        ];
    }
}

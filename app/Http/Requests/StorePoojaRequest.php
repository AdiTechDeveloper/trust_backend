<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;

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
           $poojaId = $this->route('id');
        return [
            //
              'name' => [
            'required',
            'string',
            'max:255',
            Rule::unique('poojas', 'name')->ignore($poojaId),
        ],

        'slug' => [
            'nullable',
            'string',
            'max:255',
            Rule::unique('poojas', 'slug')->ignore($poojaId),
        ],
            'short_description' => 'nullable|string|max:500',
            'description' => 'required|string',
            'price'  => 'required|string',
            'offer_price' => 'nullable|numeric|min:0|lte:price',
            'duration' => 'required|string|max:100',
            'timings' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'benefits' => 'nullable|array',
             'benefits.*' => 'nullable|string|max:255',
            'samagri' => 'nullable|array',
            'samagri.*' => 'nullable|string|max:255',
            'process' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_featured' => 'nullable|boolean',
            'status' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
         ]; 
    }

    public function message(): array
    {
        return [
            'name.required' => 'Puja name is Required.',
            'name.unique' => 'This puja is already exists.',

            'description.required' =>'Puja description is required',

            'price.required' => 'Puja price is required',
            'price.numeric' => 'Puja price must be a valid number',
            'offer_price_numeric' => 'Offer price must be a valid number',
            'offer_price.lte' =>  'Offer price cannot be greater than the original price.',
            'duration.required' => 'Puja duration is required.',
            'photo_image' => 'The puja photo must be a image',
            'photo_mimes' => 'The pojja photo must be a JPG , JPEG , PNG , WEBP.',
            'photo_max' => 'The puja photo must not be larger than 2MB.',
            'gallery.*.image' => 'Each gallery file must be an image',
            'gallery.*.mimes' => 'Gallery images must be JPG , JPEG , PNG , WEBP.',
            'gallery.max' => 'Each gallery images must not be larger than 2MB.',
            'is_featured.boolean' => 'Featured status must be true or false.',
            'status.boolean' => 'Status must be true or false.',
            'sort_order.integer' => 'Sort order must be a number.',
            
        ];
    }
}

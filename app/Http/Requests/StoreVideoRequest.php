<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Override;

class StoreVideoRequest extends FormRequest
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

            $videoId = $this->route('id');

        return [
            //
                'title' =>[
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('videos','title')->ignore($videoId),
                ],

                'slug' =>[
                    'nullable',
                    'string',
                    'max:255',
                    Rule::unique('videos','slug')->ignore($videoId),
                ],
                'category' => 'nullable|string|max:100',
                'language' => 'nullable|string|max:50',
                'description' => 'nullable|string',

                'video_url' =>[
                    'required',
                    'url',
                    'max:2048',
                ],

                'thumbnail' =>[
                    'nullable',
                    'image',
                    'mimes:png,jpg,jpeg.webp',
                    'max:2048',
                ],

                'duration' => 'nullable|string|max:20',

                'featured' => 'nullable|boolean',

                'status' => 'nullable|boolean',

                'sort_order' => 'nullable|integer|min:0',

                'published_at' => 'nullable|date',

        ];
    }


    public function messages(): array
    {
        return[
            'title.required' => 'Video title is required.',
            'title.unique'  => 'This video title is already exist.',

            'slug.unique' => 'This video slug already exists.',

            'video_url.required' => 'Video URL is required.',
            'video_url.url' => 'Please enter valid video URL.',

            'thumbnail.image' => 'Thumbnail must be an image.',
            'thumbnail.mimes' => 'Thumbnail must be a JPG , JPEG , PNG , WEBP.',
            'thumbnail.max' => 'Thumbmail size must not exceed 2 MB.',

            'duration.max' => 'Duration must not exceed 20 characters.',

            'sort_order.integer' => 'Sort order must be a valid number.',
            'sort_order.min' => 'Sort order cannot be negative.',

            'punlished_at.date' => 'Published date must be a valid date.',
        ];
    }
}

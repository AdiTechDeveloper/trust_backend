<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class PujaBookingRequest extends FormRequest
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
        // Require booking date to be at least 5 days from today
        $minDate = Carbon::now()->addDays(5)->format('Y-m-d');

        return [
            'puja_id' => 'required|exists:poojas,id',
            'name' => 'required|string|max:255',
            'mobile' => 'required|digits:10',
            'dob' => 'nullable|date',
            'booking_date' => [
                'required',
                'date',
                'after_or_equal:'.$minDate,
            ],
            'time_slot' => 'required|string',
        ];
    }

    #[Override]
    public function messages(): array
    {
        return [
            'booking_date.after_or_equal' => 'Puja bookings require at least 5 days advance notice.',
        ];
    }
}

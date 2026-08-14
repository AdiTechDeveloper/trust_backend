<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

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

        $rules = [
            'puja_id' => 'required|exists:poojas,id',
            'name' => 'required|string|max:255',
            'mobile' => 'required|digits:10',
            'dob' => 'required|date|before:today',
            'booking_date' => [
                'required',
                'date',
                'after_or_equal:'.$minDate,
            ],
            'time_slot' => 'required|string',
        ];

        // If this request is hitting the payment verification endpoint, enforce Razorpay parameters
        if ($this->routeIs('puja.verify-payment') || $this->has('razorpay_payment_id')) {
            $rules['razorpay_payment_id'] = 'required|string';
            $rules['razorpay_order_id'] = 'required|string';
            $rules['razorpay_signature'] = 'required|string';
        }

        return $rules;
    }

    /**
     * Custom validation error messages
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your full name.',
            'mobile.required' => 'Please enter your 10-digit mobile number.',
            'mobile.digits' => 'Mobile number must be exactly 10 digits.',
            'dob.required' => 'Please select your Date of Birth.',
            'dob.before' => 'Date of Birth must be a valid past date.',
            'booking_date.required' => 'Please select your preferred puja booking date.',
            'booking_date.after_or_equal' => 'Puja bookings require at least 5 days advance notice.',
            'time_slot.required' => 'Please select a time slot for the puja.',
            'razorpay_payment_id.required' => 'Payment reference ID is missing.',
            'razorpay_order_id.required' => 'Payment order ID is missing.',
            'razorpay_signature.required' => 'Payment signature verification token is missing.',
        ];
    }
}

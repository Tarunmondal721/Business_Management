<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SellingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'seller_id'              => 'required|exists:seller_users,id',
            'departure_date'         => 'required|date',
            'arrival_date'           => 'nullable|date',

            'bag_name'               => 'required|string',
            'total_quantity'         => 'required|numeric',
            'booking_cost_per_bag'   => 'required|numeric',
            'weight_per_bag'         => 'required|numeric',
            'unit'                   => 'required',

            // Departure
            'departure_fish_id'      => 'required|array|min:1',
            'departure_fish_id.*'    => 'required|exists:fishs,id',

            'departure_quantity'     => 'required|array',
            'departure_quantity.*'   => 'required|numeric|min:1',

            'departure_weight'       => 'required|array',
            'departure_weight.*'     => 'required|numeric|min:0.01',

            'departure_unit'         => 'required|array',
            'departure_unit.*'       => 'required',

            // Bill
            'attachment'             => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',

            'bill_fish_id'           => 'required_with:attachment|array',
            'bill_fish_id.*'         => 'required_with:attachment|exists:fishs,id',

            'bill_quantity'          => 'required_with:attachment|array',
            'bill_quantity.*'        => 'required_with:attachment|numeric|min:1',

            'bill_weight'            => 'required_with:attachment|array',
            'bill_weight.*'          => 'required_with:attachment|numeric|min:0.01',

            'bill_unit'              => 'required_with:attachment|array',
            'bill_unit.*'            => 'required_with:attachment',

            'bill_price'             => 'required_with:attachment|array',
            'bill_price.*'           => 'required_with:attachment|numeric|min:0',

        ];
    }

    public function messages(): array
    {
        return [

            'seller_id.required' => 'Please select a seller.',
            'seller_id.exists' => 'Selected seller is invalid.',

            'departure_date.required' => 'Departure date is required.',
            'departure_date.date' => 'Please enter a valid departure date.',

            'arrival_date.date' => 'Please enter a valid arrival date.',

            'bag_name.required' => 'Bag name is required.',

            'total_quantity.required' => 'Total quantity is required.',
            'total_quantity.numeric' => 'Total quantity must be numeric.',

            'booking_cost_per_bag.required' => 'Booking cost per bag is required.',
            'booking_cost_per_bag.numeric' => 'Booking cost must be numeric.',

            'weight_per_bag.required' => 'Weight per bag is required.',
            'weight_per_bag.numeric' => 'Weight per bag must be numeric.',

            'unit.required' => 'Please select a unit.',

            /*
        |--------------------------------------------------------------------------
        | Departure
        |--------------------------------------------------------------------------
        */

            'departure_fish_id.required' => 'Please add at least one fish.',
            'departure_fish_id.*.required' => 'Please select a fish.',
            'departure_fish_id.*.exists' => 'Selected fish is invalid.',

            'departure_quantity.*.required' => 'Please enter quantity.',
            'departure_quantity.*.numeric' => 'Quantity must be numeric.',
            'departure_quantity.*.min' => 'Quantity must be greater than 0.',

            'departure_weight.*.required' => 'Please enter weight.',
            'departure_weight.*.numeric' => 'Weight must be numeric.',
            'departure_weight.*.min' => 'Weight must be greater than 0.',

            'departure_unit.*.required' => 'Please select a unit.',

            /*
        |--------------------------------------------------------------------------
        | Bill
        |--------------------------------------------------------------------------
        */

            'attachment.mimes' => 'Only JPG, JPEG, PNG, PDF, DOC and DOCX files are allowed.',
            'attachment.max' => 'Attachment size must not exceed 2 MB.',

            'bill_fish_id.required_with' => 'Please add bill fish details.',
            'bill_fish_id.*.required_with' => 'Please select a fish.',
            'bill_fish_id.*.exists' => 'Selected fish is invalid.',

            'bill_quantity.*.required_with' => 'Please enter quantity.',
            'bill_quantity.*.numeric' => 'Quantity must be numeric.',
            'bill_quantity.*.min' => 'Quantity must be greater than 0.',

            'bill_weight.*.required_with' => 'Please enter weight.',
            'bill_weight.*.numeric' => 'Weight must be numeric.',
            'bill_weight.*.min' => 'Weight must be greater than 0.',

            'bill_unit.*.required_with' => 'Please select a unit.',

            'bill_price.*.required_with' => 'Please enter price.',
            'bill_price.*.numeric' => 'Price must be numeric.',
            'bill_price.*.min' => 'Price cannot be negative.',

        ];
    }



    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => 0,
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}

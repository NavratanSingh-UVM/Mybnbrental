<?php

namespace App\Http\Requests\PropertyListing;

use Illuminate\Foundation\Http\FormRequest;

class PropertyListingRequestStepOne extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'property_name'=>'required',
            // 'property_main_image'=>'required',
            'square_feet' => 'required',
            'property_type' => 'required',
            'bedrooms' => 'required',
            'sleeps' => 'required',
            'avg_night' => 'required',
            'baths' => 'required',
            'description' => 'required',
            'country' => 'required',
            'state' => 'required',
            'region' => 'required',
            // 'city' => 'required',
            // 'sub_city' => 'required',
            'address' => 'required',
            'address' => 'required',
            'town' => 'required',
            'zipcode' => 'required',
            // 'owner_information' => 'required',
            // 'owner_address' => 'required',
            // 'phone_country_code' => 'required',
            // 'phone' => 'required',
            // 'country_code_alternat_phone' => 'required',
            // 'alternate_phone' => 'required',
            // 'owner_fax'=>'required',
            // 'email' => 'required',
            // 'alternate_email' => 'required',
        ];
    }
}

<?php

namespace App\Http\Requests\PropertyListing;

use Illuminate\Foundation\Http\FormRequest;

class PropertyRatesRequest extends FormRequest
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
            "session_name"=>'required',
            "from_date"=>"required",
            "to_date"=>"required",
            "nightly_rate"=>"required",
            "minimum_stay"=>"required",
           
        ];
    }
}

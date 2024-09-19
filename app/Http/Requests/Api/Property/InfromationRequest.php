<?php

namespace App\Http\Requests\Api\Property;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class InfromationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'property_name'=>'required',
            'property_main_image'=>'required|mimes:png,jpg,jpeg,webp|image|max:2048',
            'square_feet' => 'required',
            'property_type' => 'required|numeric|exists:property_types,id',
            'bedrooms' => 'required|numeric',
            'sleeps' => 'required',
            'avg_night' => 'required',
            'avg_night_unit'=>'required',
            'baths' => 'required|integer',
            'description' => 'required',
            'country' => 'required|integer|exists:countries,id',
            'state' => 'required|integer|exists:states,id',
            'region' => 'required|integer|exists:regions,id',
            // 'city' => 'integer|exists:cities,id',
            // 'sub_city' => 'integer|exists:sub_cities,id',
            'address' => 'required|string|min:3',
            'town' => 'required|string|min:2',
            'zipcode' => 'required',
        ];
    }

    /**
        * Get the error messages for the defined validation rules.*
        * @return array
    */
    protected function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'status'=>false,
            'msg' => $validator->errors()->first(),
        ], 422));
    }


}

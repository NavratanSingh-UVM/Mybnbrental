<?php

namespace App\Http\Requests\Partner;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PropertyListingImageRequest extends FormRequest
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
            'title' =>'required',
            'business_category'=>'required',
            'address'=>'required',
            'description'=>'required',
            'email'=>'required',
            'website'=>'required',
            'phone'=>'required',
            'location'=>'required',
            'images'=>'required|array',
            'images.*'=>"mimes:png,jpeg,jpg|max:20000",
            'state'=>'required',
            'region'=>'required',
            'city'=>'required',
        ];
    }
    /**
        * Get the error messages for the defined validation rules.*
        * @return array
    */
    protected function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
            'status'=>422
        ], 422));
    }
}

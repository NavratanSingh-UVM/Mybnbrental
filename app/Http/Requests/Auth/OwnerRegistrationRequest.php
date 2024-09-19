<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class OwnerRegistrationRequest extends FormRequest
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
            'full_name'=>'required',
            'username'=>'required|unique:users,email,'.$this->id,
            'country_code'=>'required',
            'phone'=>'required',
            'password'=>['required',
                        'min:8',
                        'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'
                    ],
            'cnf_password'=>'required_with:password|same:password|min:8',
            'verify'=>'required',
            'type'=>'required',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return \Auth::check(); 
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile_phone' => 'required',
            'office_phone' => 'required',
            'email'=>'required|email|unique:clients,email|unique:contractors,email|unique:design_teams,email|unique:project_managers,email',
            'specialty' => 'required',
            "user_type"    => "required",
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]; 
    }
    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'first_name' => 'User Name',
            'last_name' => 'User SurName',
            'mobile_phone' => 'Mobile Phone',
            'office_phone' => 'Office Name',

        ];
    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array<string, string>
    */
    public function messages()
    {
        return [

        ];
    }
}

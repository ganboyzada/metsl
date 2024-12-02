<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'name' => 'required|unique:companies,name',
            'description' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif'
        ]; 
    }

    public function messages()
    {
        return [
            'name.required' => 'Company Name is required!',
            'description.required' => 'Company Description is required!'
        ];
    }
}

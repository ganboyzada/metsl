<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DocumentRequest extends FormRequest
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

            'project_id' => ['required', 'integer'],
          
            'title' => 'required',
            'number' => 'required',
            "reviewers"    => ['required','array'],
            'docs' => 'required',
            "docs.*"  => ["required","mimes:pdf"],

    
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
            'assignees' => 'Correspondence Assignees',
            'distribution' => 'Correspondence Distribution Members',
            'recieved_from' => 'Correspondence Received From',
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

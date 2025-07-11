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
        if(isset(request()->id)){
            return [

                'project_id' => ['required', 'integer'],
                'package_id' => ['required', 'integer'],
                 'subfolder_id' => ['nullable', 'integer'],
           
                'title' => 'nullable',
                'number' => 'required',
                "reviewers"    => ['required','array'],
                'docs' => 'nullable',
                "docs.*"  => ["nullable","mimes:pdf"],

        
            ]; 
        }else{
            return [

                'project_id' => ['required', 'integer'],
                'package_id' => ['required', 'integer'],
                  'subfolder_id' => ['nullable', 'integer'],
           
                'title' => 'nullable',
                'number' => 'required',
                "reviewers"    => ['required','array'],
                'docs' => 'required',
                "docs.*"  => ["required","mimes:pdf"],

        
            ]; 
        }

    }
    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
         
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

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReplyRequest extends FormRequest
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
            'status' => 'required|in:0,1,2',
            'description_reply' => ['required', 'max:255'],         
            'title' => 'required',
            'punch_list_id' => ['required', 'exists:punch_lists,id'],  
            'project_id' => ['required', 'exists:projects,id'], 
            'docs'=>["nullable", "mimes:jpeg,bmp,png,gif,svg,pdf"], 

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

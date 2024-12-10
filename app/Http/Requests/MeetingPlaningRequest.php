<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MeetingPlaningRequest extends FormRequest
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
            'number' => [
                'required',
                Rule::unique('meeting_plans' , 'number')->where(fn ($query) => $query->where('project_id', request()->project_id))
            ],                     
            'name' => 'required',
            'link' => ['required','regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'],
            'location'=>'required',
            'planned_date'=>'required',
            'start_time'=>'required',
            'duration'=>'required',
            'timezone'=>'required',
            'purpose'=>'required',
            "participates"    => ['required','array'],
            'docs' => 'required',
            "docs.*"  => ["required", "mimes:jpeg,bmp,png,gif,svg,pdf"],

    
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

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
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
        $project_id =  Session::get('projectID');
        if(isset(request()->id)){
            return [
                'subject' => [
                    'required',
                    Rule::unique('tasks' , 'subject')->where(fn ($query) => $query->where('project_id', $project_id)->where('id','!=', request()->id))
                ],                     
                'description' => 'required',
                'priority' => 'required',
                'start_date' => 'required|date_format:Y-m-d',
                'end_date' => 'required|date_format:Y-m-d|after:start_date',
                'file' => 'nullable',
                'group_id' => 'required',
                'id' => 'required',
            

        
            ]; 
        }else{
            return [
                'subject' => [
                    'required',
                    Rule::unique('tasks' , 'subject')->where(fn ($query) => $query->where('project_id', $project_id))
                ],                     
                'description' => 'required',
                'priority' => 'required',
                'start_date' => 'required|date_format:Y-m-d',
                'end_date' => 'required|date_format:Y-m-d|after:start_date',
                'file' => 'nullable',
                'group_id' => 'required',

        
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

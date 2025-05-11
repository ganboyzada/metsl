<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PunchListRequest extends FormRequest
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
                'id'=> 'required',
                'pin_x'=> 'required',
                'pin_y'=> 'required'
        
            ]; 
        }else{
            return [
                'number' => [
                    'required',
                    Rule::unique('punch_lists' , 'number')->where(fn ($query) => $query->where('project_id', request()->project_id))
                ],                     
                'title' => 'required',
                'location'=>'required',
                //'cost_impact'=>'required',
                'priority'=>'required',
                'responsible_id'=>'required',
               // 'date_notified_at' => 'required|date_format:Y-m-d',
               // 'date_resolved_at' => 'required|date_format:Y-m-d',
                'due_days' => 'required|integer',
                'project_id'=>'required',
                'description'=>'required',
                "participates"    => ['required','array'],
                "linked_documents"    => ['required','array'],
                "linked_documents.*"  => ["required"],
                'docs' => 'nullable',
                "docs.*"  => ["nullable", "mimes:jpeg,bmp,png,gif,svg,pdf"],
                'drawing_id'=> 'required',
                'pin_x'=> 'required',
                'pin_y'=> 'required'


        
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

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CorrespondenceRequest extends FormRequest
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
                'type' => ['required'],
                'number' => [
                    'required',
                    Rule::unique('correspondences' , 'number')->where(fn ($query) => $query->where('project_id', request()->project_id)->where('id','!=', request()->id))
                ],
                'subject' => [
                    'required',
                    Rule::unique('correspondences' , 'subject')->where(fn ($query) => $query->where('project_id', request()->project_id)->where('id','!=', request()->id))
                ],

                'description' => 'nullable',
                'status' => 'required',
                'program_impact' => 'required',
                'cost_impact' => 'required',
                "assignees"    => ['required','array'],
                "distribution"    => ['required','array'],
                'docs' => 'nullable',

            ]; 
        }else{
            return [

                'project_id' => ['required', 'integer'],
                'type' => ['required'],
                'number' => [
                    'required',
                    Rule::unique('correspondences' , 'number')->where(fn ($query) => $query->where('project_id', request()->project_id))
                ],
                'subject' => [
                    'required',
                    Rule::unique('correspondences' , 'subject')->where(fn ($query) => $query->where('project_id', request()->project_id))
                ],

                'description' => 'nullable',
                'status' => 'required',
                'program_impact' => 'required',
                'cost_impact' => 'required',
                "assignees"    => ['required','array'],
                "distribution"    => ['required','array'],
                'docs' => 'required',
        
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

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            $id = request()->id;
            return [
                'name' => 'required|unique:projects,name,'.$id,
                'description' => 'nullable',
                'start_date' => 'required',
                'end_date' => 'required|date_format:Y-m-d|after:start_date',
                'status'=>'required|integer',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                "contractor"    => "nullable|array",
                "contractor.*"  => "nullable|string|distinct",
                "client"    => "nullable|array",
                "client.*"  => "nullable|string|distinct",
                "designTeam"    => "nullable|array",
                "designTeam.*"  => "nullable|string|distinct",
                "projectManager"    => "nullable|array",
                "projectManager.*"  => "nullable|string|distinct",
            ]; 
        }else{
            return [
                'name' => 'required|unique:projects,name',
                'description' => 'nullable',
                'start_date' => 'required',
                'end_date' => 'required|date_format:Y-m-d|after:start_date',
                'status'=>'required|integer',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                "contractor"    => "nullable|array",
                "contractor.*"  => "nullable|string|distinct",
                "client"    => "nullable|array",
                "client.*"  => "nullable|string|distinct",
                "designTeam"    => "nullable|array",
                "designTeam.*"  => "nullable|string|distinct",
                "projectManager"    => "nullable|array",
                "projectManager.*"  => "nullable|string|distinct",
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
            'start_date' => 'Project Start Date',
            'end_date' => 'Project End Date',
            'contractor.*' => 'contractor',
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
            'name.required' => 'Company Name is required!',
            'description.required' => 'Company Description is required!'
        ];
    }
}

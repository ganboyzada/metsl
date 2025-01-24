<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    // Display a listing of the companies
    public function index()
    {
        $companies = Company::all();
        return view('metsl.pages.companies.index', compact('companies'));
    }

    // Show the form for creating a new company
    public function create()
    {
        return view('metsl.pages.companies.create');
    }

    // Store a newly created company in storage
    public function store(Request $request)
    {
        $data = $request->all();
        $data['active'] = ($request->active) ? true : false;      
        $err = $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            //'active' => 'required|boolean',
        ]);
        //dd($err);
        Company::create($data);
        return redirect()->route('companies')->with('success', 'Company created successfully.');
    }

    // Show the form for editing the specified company
    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('metsl.pages.companies.edit', compact('company'));
    }

    // Update the specified company in storage
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['active'] = ($request->active) ? true : false;
        $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            //'active' => 'boolean',
        ]);
        ///dd($request->all());
        $company = Company::findOrFail($id);
        $company->update($data);
        return redirect()->route('companies')->with('success', 'Company updated successfully.');
    }

    // Remove the specified company from storage
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return redirect()->route('companies')->with('success', 'Company deleted successfully.');
    }
}

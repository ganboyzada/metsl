<?php

namespace App\Http\Controllers;

use App\Models\WorkPackages;
use Illuminate\Http\Request;

class WorkPackagesController extends Controller
{

    public function index()
    {
        $packages = WorkPackages::all();
        return view('metsl.pages.work-packages.index', compact('packages'));
    }


    public function create()
    {
        return view('metsl.pages.work-packages.create');
    }


    public function store(Request $request)
    {
        $data = $request->all();
        $err = $request->validate([
            'name' => 'required|string|max:255|unique:work_packages,name',
            //'active' => 'required|boolean',
        ]);
        //dd($err);
        WorkPackages::create($data);
        return redirect()->route('work_packages')->with('success', 'Work Package created successfully.');
    }


    public function edit($id)
    {
        $package = WorkPackages::findOrFail($id);
        return view('metsl.pages.work-packages.edit', compact('package'));
    }


    public function update(Request $request, $id)
    {
        $data = $request->all();
        $request->validate([
            'name' => 'required|string|max:255|unique:work_packages,name,'.$id,
  
        ]);
        ///dd($request->all());
        $package = WorkPackages::findOrFail($id);
        $package->update($data);
        return redirect()->route('work_packages')->with('success', 'Work Package updated successfully.');
    }

    public function destroy($id)
    {
        $package = WorkPackages::findOrFail($id);
        $package->delete();
        return redirect()->route('work_packages')->with('success', 'Work Package deleted successfully.');
    }
}

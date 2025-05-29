@extends('metsl.layouts.master')

@section('header')
<div><h1 class="text-xl mb-0">Add a Work Package</h1></div>
@endsection

@section('content')
<form action="{{ route('work_packages.store') }}" class="py-10" method="POST">
    @csrf
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 pb-5">
        
        <div>
            <label for="name" class="block text-sm mb-4 font-medium dark:text-gray-200">Name</label>
            <input type="text" placeholder="X-Construction LLC" name="name" id="name" class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200" required>
        </div>
 
    </div>
    <button type="submit" class="flex px-4 gap-3 py-2 bg-blue-500 text-white hover:bg-blue-600 mt-4">
        <i data-feather="save"></i>
        Save Work Package
    </button>
</form>
@endsection

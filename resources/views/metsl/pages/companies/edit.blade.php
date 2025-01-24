@extends('metsl.layouts.master')

@section('header')
<div><h1 class="text-xl mb-0">Edit Company</h1></div>
@endsection

@section('content')
<form action="{{ route('companies.update', $company->id) }}" class="py-10" method="POST">
    @csrf
    @method('PUT')
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <div>
            <label for="name" class="block text-sm mb-4 font-medium dark:text-gray-200">Name</label>
            <input type="text" name="name" value="{{ $company->name }}" id="name" class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200" required>
        </div>
        <div>
            <label for="specialty" class="block text-sm mb-4 font-medium dark:text-gray-200">Specialty</label>
            <input type="text" name="specialty" value="{{ $company->specialty }}" id="specialty" class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200" required>
        </div>
        <div>
            <label for="phone" class="block text-sm mb-4 font-medium dark:text-gray-200">Phone</label>
            <input type="text" name="phone" value="{{ $company->phone }}" id="phone" class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200">
        </div>
        <div>
            <label for="email" class="block text-sm mb-4 font-medium dark:text-gray-200">Email</label>
            <input type="email" name="email" value="{{ $company->email }}" id="email" class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200">
        </div>
        <div>
            <label for="address" class="block text-sm mb-4 font-medium dark:text-gray-200">Address</label>
            <input type="text" name="address" value="{{ $company->address }}" id="address" class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200">
        </div>
        <div>
            <label class="block text-sm mb-4 font-medium dark:text-gray-200">Active</label>
            <div class="checkbox-wrapper-51">
                <input type="checkbox" name="active" id="cbx-51" {{ $company->active ? 'checked' : '' }}/>
                <label for="cbx-51" class="toggle">
                    <span>
                    <svg width="10px" height="10px" viewBox="0 0 10 10">
                        <path d="M5,1 L5,1 C2.790861,1 1,2.790861 1,5 L1,5 C1,7.209139 2.790861,9 5,9 L5,9 C7.209139,9 9,7.209139 9,5 L9,5 C9,2.790861 7.209139,1 5,1 L5,9 L5,1 Z"></path>
                    </svg>
                    </span>
                </label>
            </div>
        </div>
    </div>
    <button type="submit" class="flex px-4 gap-3 py-2 bg-blue-500 text-white hover:bg-blue-600 mt-4">
        <i data-feather="save"></i>
        Update Company
    </button>
</form>
@endsection

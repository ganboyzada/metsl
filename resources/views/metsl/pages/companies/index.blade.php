@extends('metsl.layouts.master')

@section('header')
    <div>
        <h1 class="text-xl mb-0">Companies</h1>
    </div>
@endsection

@section('content')
<div class="flex justify-between items-center mb-6">
    <div class="flex items-center">
        <a href="{{ route('companies.create') }}" class="inline-flex bg-blue-900 text-white px-3 py-2  hover:bg-blue-600">
            <i data-feather="plus" class="mr-1"></i> Add Company
        </a>
    </div>
</div>

<div class="overflow-x-auto">
    <table class="min-w-full border-collapse border dark:border-gray-800">
        <thead class="bg-gray-100 dark:bg-gray-800 text-sm text-left">
            <tr>
                <th class="px-6 py-3 font-light">ID</th>
                <th class="px-6 py-3 font-light">Name</th>
                <th class="px-6 py-3 font-light">Specialty</th>
                <th class="px-6 py-3 font-light">Phone</th>
                <th class="px-6 py-3 font-light">Email</th>
                <th class="px-6 py-3 font-light">Active</th>
                <th class="px-6 py-3 font-light">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($companies as $company)
            <tr>
                <td class="px-6 py-3">{{ $company->id }}</td>
                <td class="px-6 py-3">{{ $company->name }}</td>
                <td class="px-6 py-3">{{ $company->specialty }}</td>
                <td class="px-6 py-3">{{ $company->phone }}</td>
                <td class="px-6 py-3">{{ $company->email }}</td>
                <td class="px-6 py-3">{{ $company->active ? 'Yes' : 'No' }}</td>
                <td class="px-6 py-3">
                    <div class="flex items-center">
                        <a href="{{ route('companies.edit', $company->id) }}" class="text-gray-500 mr-2 dark:text-gray-400 hover:text-gray-300">
                            <i data-feather="edit" class="w-5 h-5"></i>
                        </a>
                        <form action="{{ route('companies.destroy', $company->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 dark:text-red-400 hover:text-blue-300">
                            <i data-feather="trash" class="w-5 h-5"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

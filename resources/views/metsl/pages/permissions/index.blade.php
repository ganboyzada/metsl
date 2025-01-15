@extends('metsl.layouts.master')
@section('header')
    <div><h1 class="text-xl mb-0">Role Editor</h1></div>
@endsection
@section('content')
<div class="flex justify-between items-center mb-6">
    <!-- Search Box -->
    <div class="relative flex items-center">
        <input type="text" id="searchBar" placeholder="Search..." 
            class=" p-2 pl-10 w-64 dark:bg-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600 focus:outline-none focus:ring focus:border-blue-300" />
        <i data-feather="search" class="absolute left-3"></i>
    </div>

    <!-- Create Company Button -->
    <a href="{{ route('roles.permissions.create') }}" class="inline-flex bg-blue-900 text-white px-3 py-2  hover:bg-blue-600">
        <i data-feather="plus" class="mr-1"></i> Create Permission
    </a>
</div>
<div class="container">   
    <table class="table mt-4">
        <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($permissions as $permission)
            <tr>
                <td>{{ $permission->name }}</td>
                <td>
                    <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

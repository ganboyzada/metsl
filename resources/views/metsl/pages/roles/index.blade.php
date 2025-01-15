@extends('metsl.layouts.master')
@section('header')
    <div><h1 class="text-xl mb-0">Role Management</h1></div>
@endsection
@section('content')
<div class="flex justify-between items-center mb-6">
    <!-- Search Box -->
    <div class="relative flex items-center">
        <input type="text" id="searchBar" placeholder="Search..." 
            class=" p-2 pl-10 w-64 dark:bg-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600 focus:outline-none focus:ring focus:border-blue-300" />
        <i data-feather="search" class="absolute left-3"></i>
    </div>

    <div class="flex items-center">
        <a href="{{ route('roles.permissions') }}" class="inline-flex bg-slate-500 text-white px-3 py-2 mr-2 hover:bg-blue-600">
            <i data-feather="lock" class="mr-1"></i> Permissions
        </a>
        <a href="{{ route('roles.create') }}" class="inline-flex bg-blue-900 text-white px-3 py-2  hover:bg-blue-600">
            <i data-feather="plus" class="mr-1"></i> Create Role
        </a>

    </div>
    
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
            @if(false)
            @foreach($roles as $role)
            <tr>
                <td>{{ $role->name }}</td>
                <td>
                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>
@endsection

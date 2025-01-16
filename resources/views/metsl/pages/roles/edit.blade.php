@extends('metsl.layouts.master')
@section('header')
    <div><h1 class="text-xl mb-0">Role Editor</h1></div>
@endsection
@section('content')
<div class="container">
    @if(session()->has('success'))
    <div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold">
        {{ session()->get('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
	@endif
    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-10">
            <label for="name" class="block text-lg mb-2 font-medium dark:text-gray-200">Role Title</label>
            <input
                type="text"
                name="name" id="name" value="{{ $role->name }}"
                class="w-96 w-max-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200" required
            />
        </div>

        <div>
            <label for="permissions" class="block text-lg mb-2 font-medium dark:text-gray-200">Permission Assignment</label>
            <div class="grid grid-cols-1 lg:grid-cols-4 md:grid-cols-2">
            @foreach($permissions as $permission)
            <div class="py-2">
                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                       {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                       <label class="ml-3"> {{ ucwords(str_replace("_"," ",$permission->name))   }}</label>
            </div>
            @endforeach
            </div>
        </div>

        <button type="submit" class="mt-5 px-4 py-2 bg-blue-500 text-white hover:bg-blue-600">Update Role</button>
    </form>
</div>
@endsection

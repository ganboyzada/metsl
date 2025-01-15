@extends('metsl.layouts.master')
@section('header')
    <div><h1 class="text-xl mb-0">Create a Role</h1></div>
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
    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Role Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="form-group mt-4">
            <h5>Assign Permissions</h5>
            @foreach($permissions as $permission)
            <div>
                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}">
                <label> {{ str_replace("_"," ",$permission->name)   }}</label>
            </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-success mt-4">Create Role</button>
    </form>
</div>
@endsection

@extends('metsl.layouts.master')
@section('header')
    <div><h1 class="text-xl mb-0">Role Editor</h1></div>
@endsection
@section('content')
<div class="container">
    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Role Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $role->name }}" required>
        </div>

        <div class="form-group mt-4">
            <h5>Assign Permissions</h5>
            @foreach($permissions as $permission)
            <div>
                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                       {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                <label>{{ $permission->name }}</label>
            </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-success mt-4">Update Role</button>
    </form>
</div>
@endsection

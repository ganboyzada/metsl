@extends('metsl.layouts.master')

@section('content')
<div class="container">
    <h1>Create Permission</h1>
    <form action="{{ route('permissions.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Permission Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter permission name" required>
        </div>

        <button type="submit" class="btn btn-success mt-3">Create Permission</button>
    </form>
</div>
@endsection

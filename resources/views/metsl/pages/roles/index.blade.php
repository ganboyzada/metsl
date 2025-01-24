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
        {{--
        <a href="{{ route('roles.permissions') }}" class="inline-flex bg-slate-500 text-white px-3 py-2 mr-2 hover:bg-blue-600">
            <i data-feather="lock" class="mr-1"></i> Permissions
        </a>
        --}}
        <a href="{{ route('roles.create') }}" class="inline-flex bg-blue-900 text-white px-3 py-2  hover:bg-blue-600">
            <i data-feather="plus" class="mr-1"></i> Create Role
        </a>

    </div>
</div>
<div class="overflow-x-auto">

    <table class="min-w-full border-collapse border dark:border-gray-800">
        <thead class="bg-gray-100 dark:bg-gray-800 text-sm text-left">
            <tr>
                <th class="px-6 py-3 font-light">Name</th>
                <th class="px-6 py-3 font-light">
                    <i data-feather="lock" class="inline mr-2 w-5 h-5"></i>
                    Permissions
                </th>
                <th class="px-6 py-3 font-light">Actions</th>
            </tr>
        </thead>
        <tbody>
            @if($roles->count() > 0)
            @foreach($roles as $role)
            <tr class="roles_tr">
                <td class="px-6 py-3">{{ $role->name }}</td>
                <td class="p-4 text-blue-800 dark:text-blue-200">
                    <div class="flex items-center flex-wrap gap-1">
                    @foreach($role->permissions as $k=>$permission)
                        @if($k < 7)
                        <span class="text-sm px-3 py-1 rounded-full bg-blue-200 dark:bg-blue-900">{{ ucwords(str_replace("_"," ",$permission->name)) }}</span>
                        @endif
                        @endforeach
                        @if(count($role->permissions)>7)
                        <span class="text-sm px-3 py-1 rounded-full bg-gray-200 text-gray-700 dark:bg-gray-800 dark:text-gray-400">more ...</span>
                    @endif
                    </div>
                </td>
                <td class="px-6 py-3">
                    <div class="flex items-center">
                        <a href="{{ route('roles.edit', $role->id) }}" class="text-gray-500 mr-2 dark:text-gray-400 hover:text-gray-300">
                            <i data-feather="edit" class="w-5 h-5"></i>
                        </a>
                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline;">
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
            @endif
        </tbody>
    </table>
</div>

<script>
    document.getElementById('searchBar').addEventListener('input', function () {
        const searchQuery = this.value.toLowerCase();
        const rows = document.querySelectorAll('.roles_tr');
        console.log(rows);
        
        rows.forEach(card => {
            const name = card.querySelector('td:first-child').textContent.toLowerCase();
            
            if (name.includes(searchQuery)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
</script>
@endsection

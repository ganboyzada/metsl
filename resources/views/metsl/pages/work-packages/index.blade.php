@extends('metsl.layouts.master')

@section('header')
    <div>
        <h1 class="text-xl mb-0">Work Package</h1>
    </div>
@endsection

@section('content')
<div class="flex justify-between items-center mb-6">
    <div class="flex items-center">
        <a href="{{ route('work_packages.create') }}" class="inline-flex bg-blue-900 text-white px-3 py-2  hover:bg-blue-600">
            <i data-feather="plus" class="mr-1"></i> Add Work Package
            
        </a>
    </div>
</div>

<div class="overflow-x-auto">
    <table class="min-w-full border-collapse border dark:border-gray-800">
        <thead class="bg-gray-100 dark:bg-gray-800 text-sm text-left">
            <tr>
                <th class="px-6 py-3 font-light">ID</th>
                <th class="px-6 py-3 font-light">Name</th>
                <th class="px-6 py-3 font-light"></th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($packages as $package)
            <tr>
                <td class="px-6 py-3">{{ $i }}</td>
                <td class="px-6 py-3">{{ $package->name }}</td>
                <td class="px-6 py-3">
                    <div class="flex items-center">
                        <a href="{{ route('work_packages.edit', $package->id) }}" class="text-gray-500 mr-2 dark:text-gray-400 hover:text-gray-300">
                            <i data-feather="edit" class="w-5 h-5"></i>
                        </a>
                        <form action="{{ route('work_packages.destroy', $package->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 dark:text-red-400 hover:text-blue-300">
                            <i data-feather="trash" class="w-5 h-5"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @php
                $i++;
            @endphp
            @endforeach
        </tbody>
    </table>
</div>
@endsection

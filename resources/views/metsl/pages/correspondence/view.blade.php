@extends('metsl.layouts.master')

@section('title', 'Correspondence - Create')

@section('content')
<div class="flex items-end mb-3">
    <h1 class="text-lg dark:text-gray-200"><a href="{{ route('projects.correspondence') }}">Correspondence</a> / <b>RFI-001</b></h1>
    <div class="ml-auto relative has-dropdown">
        <button type="button"
            class="dropdown-toggle flex items-center px-4 py-2 bg-blue-500 text-white  hover:bg-blue-600 focus:outline-none"
            >
            <i data-feather="loader" class="mr-2"></i>
            Action
        </button>
        <!-- Dropdown Menu -->
        <div
            class="dropdown absolute right-0 mt-2 w-48 bg-gray-800 text-gray-200  shadow-lg hidden"
        >
            <a href="{{ route('projects.correspondence.create') }}" class="flex px-4 py-2 hover:bg-gray-700"><i data-feather="corner-up-left" class="mr-2"></i>Reply</a>
            <a href="{{ route('projects.correspondence.create') }}" class="flex px-4 py-2 hover:bg-gray-700"><i data-feather="corner-up-right" class="mr-2"></i>RFI </a>
        </div>
    </div>
</div>


<!-- Correspondence Information -->
 <div class="p-6 bg-white dark:bg-gray-900 ">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <!-- Number -->
        <div>
            <h3 class="text-sm font-medium dark:text-gray-400">Number</h3>
            <p class="text-lg font-semibold dark:text-gray-200">RFI-001</p>
        </div>

        <!-- Subject -->
        <div>
            <h3 class="text-sm font-medium dark:text-gray-400">Subject</h3>
            <p class="text-lg font-semibold dark:text-gray-200">Floor 85 Revision</p>
        </div>

        <!-- Status -->
        <div>
            <h3 class="text-sm font-medium dark:text-gray-400 mb-2">Status</h3>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-500 text-white">Open</span>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-500 text-white">Closed</span>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-500 text-black">Issued</span>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-300 text-black">Draft</span>
        </div>

        <!-- Programme Impact -->
        <div>
            <h3 class="text-sm font-medium dark:text-gray-400">Programme Impact</h3>
            <p class="text-lg font-semibold dark:text-gray-200">Yes</p>
        </div>

        <!-- Cost Impact -->
        <div>
            <h3 class="text-sm font-medium dark:text-gray-400">Cost Impact</h3>
            <p class="text-lg font-semibold dark:text-gray-200">Yes</p>
        </div>

        <!-- Received From -->
        <div class="flex items-center">
            <img src="https://st3.depositphotos.com/9998432/13335/v/450/depositphotos_133351928-stock-illustration-default-placeholder-man-and-woman.jpg" alt="Profile" class="w-10 h-10 rounded-full mr-4">
            <div>
                <h3 class="text-sm font-medium dark:text-gray-400">Received From</h3>
                <p class=" dark:text-gray-200">John Doe</p>
            </div>
        </div>

        <!-- Assignees -->
        <div class="mb-6">
            <h3 class="text-sm font-medium dark:text-gray-400 mb-2">Assignees</h3>
            <div class="flex flex-wrap gap-4">
                <div class="flex items-center">
                    <img src="https://st3.depositphotos.com/9998432/13335/v/450/depositphotos_133351928-stock-illustration-default-placeholder-man-and-woman.jpg" alt="Profile" class="w-10 h-10 rounded-full mr-4">
                    <p class="  dark:text-gray-200">Jane Smith</p>
                </div>
                <div class="flex items-center">
                    <img src="https://st3.depositphotos.com/9998432/13335/v/450/depositphotos_133351928-stock-illustration-default-placeholder-man-and-woman.jpg" alt="Profile" class="w-10 h-10 rounded-full mr-4">
                    <p class="  dark:text-gray-200">Michael Brown</p>
                </div>
            </div>
        </div>

        <!-- Distribution Members -->
        <div class="mb-6">
            <h3 class="text-sm font-medium dark:text-gray-400 mb-2">Distribution Members</h3>
            <div class="flex flex-wrap gap-4">
                <div class="flex items-center">
                    <img src="https://st3.depositphotos.com/9998432/13335/v/450/depositphotos_133351928-stock-illustration-default-placeholder-man-and-woman.jpg" alt="Profile" class="w-10 h-10 rounded-full mr-4">
                    <p class="  dark:text-gray-200">Alice Johnson</p>
                </div>
                <div class="flex items-center">
                    <img src="https://st3.depositphotos.com/9998432/13335/v/450/depositphotos_133351928-stock-illustration-default-placeholder-man-and-woman.jpg" alt="Profile" class="w-10 h-10 rounded-full mr-4">
                    <p class="  dark:text-gray-200">Robert White</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Description -->
    <div class="mb-6">
        <h3 class="text-sm font-medium dark:text-gray-400 mb-1">Description</h3>
        <p class="text-lg dark:text-gray-200">This is a detailed description of the correspondence that explains the context and other relevant information.</p>
    </div>

    <!-- Attachments -->
    <div>
        <h3 class="text-sm font-medium dark:text-gray-400 mb-2">Attachments</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <div class="bg-gray-100 dark:bg-gray-800 p-4  flex items-center justify-between">
                <div class="flex items-center">
                    <i data-feather="file" class="w-6 h-6 mr-3 dark:text-gray-400"></i>
                    <p class="text-sm dark:text-gray-200">Attachment1.pdf</p>
                </div>
                <a href="/path/to/attachment1.pdf" class="text-blue-500 hover:underline"><i data-feather="arrow-down-circle"></i></a>
            </div>
            <div class="bg-gray-100 dark:bg-gray-800 p-4  flex items-center justify-between">
                <div class="flex items-center">
                    <i data-feather="file" class="w-6 h-6 mr-3 dark:text-gray-400"></i>
                    <p class="text-sm dark:text-gray-200">Attachment2.pdf</p>
                </div>
                <a href="/path/to/attachment2.pdf" class="text-blue-500 hover:underline"><i data-feather="arrow-down-circle"></i></a>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('metsl.layouts.master')

@section('title', 'Project Detail')

@section('header')
<a href="{{ route('projects') }}" class="flex items-center text-base text-orange-600 dark:text-orange-300 bg-orange-500/[10%] hover:bg-orange-500/[20%] px-4 py-2 rounded-lg font-medium">
    <i data-feather="briefcase" class="mr-2"></i> Projects
</a>
<span class="pl-4"><i class="fa-solid fa-briefcase mr-2"></i>Project Name</span>
@endsection

@section('content')
    <div class="flex space-x-6">
        @include('metsl.pages.projects.sidebar')

        <!-- Right Section with Project List and Search -->
        <div class="flex-1 ml-6 p-6 bg-white dark:bg-gray-900  shadow rounded-lg">

            <!-- Header with Tabs -->
            <div data-tabs="project-details" class="tab-links text-gray-600 dark:text-gray-200 flex border-b border-gray-200 dark:border-gray-600">
                <button data-tab="issues" id="tab-issues" class="active  px-4 py-2">Issues</button>
                <button data-tab="documents" id="tab-proj-documents" class="px-4 py-2">Documents</button>
                <button data-tab="meeting-minutes" id="tab-meeting-minutes" class="px-4 py-2">Meeting minutes</button>
                <button data-tab="reports" id="tab-reports" class="px-4 py-2">Reports</button>
            </div>

            <div class="main-view tab-view" data-tabs="project-details">
                <div id="issues" class="tab-content">
                    @include('metsl.pages.projects.issues')
                </div>
                <div id="proj-documents" class="tab-content hidden">
                    Documents
                </div>
                <div id="meeting-minutes" class="tab-content hidden">
                    @include('metsl.pages.projects.meeting_minutes')
                </div>
                <div id="reports" class="tab-content hidden">
                    Reports
                </div>
            </div>
        </div>
    </div>
@endsection
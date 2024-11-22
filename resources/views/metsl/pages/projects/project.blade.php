@extends('metsl.layouts.master')

@section('title', 'Project Detail')

@section('content')
    <div class="flex space-x-6">
        @include('metsl.pages.projects.sidebar')

        <!-- Right Section with Project List and Search -->
        <div data-tabs="project-tools" class="tab-view flex-1 ml-6 p-6 bg-white dark:bg-gray-900  shadow rounded-lg">
            <div class="tab-content" id="correspondence">
                @include('metsl.pages.correspondence.index')
            </div>
        </div>
    </div>
@endsection
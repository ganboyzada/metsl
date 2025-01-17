@extends('metsl.layouts.master')

@section('title', 'Project Detail')

@section('content')
    <div class="main">

        <!-- Right Section with Project List and Search -->
        <div data-tabs="project-tools" class="tab-view">
            <div class="tab-content hidden" id="correspondence">
                @include('metsl.pages.correspondence.index')
            </div>
            <div class="tab-content hidden" id="documents">
                @include('metsl.pages.documents.index')
            </div>
            <div class="tab-content hidden" id="punch-list">
                @include('metsl.pages.punch-list.index')
            </div>
            <div class="tab-content hidden" id="meetings">
                @include('metsl.pages.meeting-minutes.index')
            </div>
            <div class="tab-content hidden" id="stakeholders">
                @include('metsl.pages.stakeholders.index')
            </div>
            <div class="tab-content hidden" id="task-planner">
                @include('metsl.pages.task-planner.index')
            </div>
        </div>
    </div>
@endsection
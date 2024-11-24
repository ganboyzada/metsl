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
            <div class="tab-content" id="snag-list">
                @include('metsl.pages.snag-list.index')
            </div>
        </div>
    </div>
@endsection
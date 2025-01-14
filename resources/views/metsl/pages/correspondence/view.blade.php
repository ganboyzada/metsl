@extends('metsl.layouts.master')

@section('title', 'Correspondence - Create')

@section('content')
<div class="flex items-end mb-3">
    <h1 class="text-lg dark:text-gray-200"><a href="{{ route('projects.correspondence') }}">Correspondence</a> / <b>{{$correspondece->number}}</b></h1>
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
            <a href="{{ url('project/correspondence/create?type='.$correspondece->type->value.'&correspondece='.$correspondece->id) }}" class="flex px-4 py-2 hover:bg-gray-700"><i data-feather="corner-up-left" class="mr-2"></i>Reply</a>
        </div>
    </div>
</div>


<!-- Correspondence Information -->
 <div class="p-6 bg-white dark:bg-gray-900 ">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <!-- Number -->
        <div>
            <h3 class="text-sm font-medium dark:text-gray-400">Number</h3>
            <p class="text-lg font-semibold dark:text-gray-200">{{$correspondece->number}}</p>
        </div>

        <!-- Subject -->
        <div>
            <h3 class="text-sm font-medium dark:text-gray-400">Subject</h3>
            <p class="text-lg font-semibold dark:text-gray-200">{{$correspondece->subject}}</p>
        </div>

        <!-- Status -->
        <div>
            <h3 class="text-sm font-medium dark:text-gray-400 mb-2">Status</h3>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{\App\Enums\CorrespondenceStatusEnum::from($correspondece->status)->color()}}">{{\App\Enums\CorrespondenceStatusEnum::from($correspondece->status)}}</span>

        </div>

        <!-- Programme Impact -->
        <div>
            <h3 class="text-sm font-medium dark:text-gray-400">Programme Impact</h3>
            <p class="text-lg font-semibold dark:text-gray-200">{{$correspondece->program_impact}}</p>
        </div>

        <!-- Cost Impact -->
        <div>
            <h3 class="text-sm font-medium dark:text-gray-400">Cost Impact</h3>
            <p class="text-lg font-semibold dark:text-gray-200">{{$correspondece->cost_impact}}</p>
        </div>

        <!-- Received From -->
        <div class="flex items-center">
            <img src="{{$correspondece->ReceivedFrom->userable->image}}" alt="Profile" class="w-10 h-10 rounded-full mr-4">
            <div>
                <h3 class="text-sm font-medium dark:text-gray-400">Received From</h3>
                <p class=" dark:text-gray-200">{{$correspondece->ReceivedFrom->name}}</p>
            </div>
        </div>

        <!-- Assignees -->
        <div class="mb-6">
            <h3 class="text-sm font-medium dark:text-gray-400 mb-2">Assignees</h3>
			
			
            <div class="flex flex-wrap gap-4">
			
			@if($correspondece->assignees->count() > 0)
				@foreach($correspondece->assignees as $user)
					<div class="flex items-center">
						<img src="{{$user->userable->image}}" alt="Profile" class="w-10 h-10 rounded-full mr-4">
						<p class="  dark:text-gray-200">{{$user->name}}</p>
					</div>
					
				@endforeach
				
			@endif			
			
            </div>
        </div>

        <!-- Distribution Members -->
        <div class="mb-6">
            <h3 class="text-sm font-medium dark:text-gray-400 mb-2">Distribution Members</h3>
            <div class="flex flex-wrap gap-4">
			@if($correspondece->DistributionMembers->count() > 0)
				@foreach($correspondece->DistributionMembers as $user)
					<div class="flex items-center">
						<img src="{{$user->userable->image}}" alt="Profile" class="w-10 h-10 rounded-full mr-4">
						<p class="  dark:text-gray-200">{{$user->name}}</p>
					</div>
					
				@endforeach
				
			@endif	
            </div>
        </div>
    </div>

    <!-- Description -->
    <div class="mb-6">
        <h3 class="text-sm font-medium dark:text-gray-400 mb-1">Description</h3>
        <p class="text-lg dark:text-gray-200">{!! $correspondece->description   !!}.</p>
    </div>

    <!-- Attachments -->
    <div>
        <h3 class="text-sm font-medium dark:text-gray-400 mb-2">Attachments</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
		@if($correspondece->files->count() > 0)
			@foreach($correspondece->files as $file)
				<div class="bg-gray-100 dark:bg-gray-800 p-4  flex items-center justify-between">
					<div class="flex items-center">
						<i data-feather="file" class="w-6 h-6 mr-3 dark:text-gray-400"></i>
						<p class="text-sm dark:text-gray-200">{{$file->file}}</p>
					</div>
					<a target="_blank" href="{{Storage::url('project'.$correspondece->project_id.'/correspondence'.$correspondece->id.'/'.$file->file)}}" class="text-blue-500 hover:underline"><i data-feather="arrow-down-circle"></i></a>
				</div>
	
		
			@endforeach
			
		
		@endif
  
        </div>
    </div>
</div>
@endsection

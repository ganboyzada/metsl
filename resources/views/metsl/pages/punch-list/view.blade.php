@extends('metsl.layouts.master')

@section('title', 'Correspondence - Create')

@section('content')
<div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold hidden success"></div>
<div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>
<div class="flex items-end mb-3">
    <h1 class="text-lg dark:text-gray-200">{{  $punch_list->title }} / <b>{{$punch_list->number}}</b></h1>
    <div class="ml-auto relative has-dropdown">
        <button type="button"
            class="dropdown-toggle flex items-center px-4 py-2 bg-blue-500 text-white  hover:bg-blue-600 focus:outline-none"
            >
            <i data-feather="loader" class="mr-2"></i>
            Action 		

        </button>
        <!-- Dropdown Menu -->
        <div
            class="dropdown absolute right-0 mt-2 w-48 bg-gray-800 text-gray-200  shadow-lg"
        >
            @if(checkIfUserHasThisPermission(Session::get('projectID') ,'responsible_punch_list') ||
            checkIfUserHasThisPermission(Session::get('projectID') ,'distribution_members_punch_list') ||
            $punch_list->created_by == auth()->user()->id
            )
            <button  data-modal="uploader-modal" class="modal-toggler  flex px-4 py-2 hover:bg-gray-700">
                <i data-feather="corner-up-left" class="mr-2"></i> <span class="hidden md:inline">Add Reply</span>
            </button>
            @endif

            @if(checkIfUserHasThisPermission(Session::get('projectID') ,'update_punch_list_status') || $punch_list->created_by == auth()->user()->id)
            <button  data-modal="status-modal" class="modal-toggler  flex px-4 py-2 hover:bg-gray-700">
                <i data-feather="corner-up-left" class="mr-2"></i> <span class="hidden md:inline">Change Status</span>
            </button>
            @endif
        </div>
    </div>
</div>


<!-- Correspondence Information -->
 <div class="pt-4 bg-white dark:bg-gray-900 ">

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-6">
        <!-- Number -->
        <div>
            <h3 class="text-sm font-medium dark:text-gray-400">Number</h3>
            <p class="text-lg font-semibold dark:text-gray-200">{{$punch_list->number}}</p>
        </div>

        <!-- Subject -->
        <div>
            <h3 class="text-sm font-medium dark:text-gray-400">Subject</h3>
            <p class="text-lg font-semibold dark:text-gray-200">{{$punch_list->title}}</p>
        </div>

        <!-- Status -->
        <div>
            <h3 class="text-sm font-medium dark:text-gray-400 mb-2">Status</h3>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $punch_list->status->color()}}">{{$punch_list->status->name}}</span>

        </div>

        <!-- Programme Impact -->
        <div>
            <h3 class="text-sm font-medium dark:text-gray-400">priority</h3>
            {!! $punch_list->priority->color()   !!}
        </div>

        <!-- Cost Impact -->
        <div>
            <h3 class="text-sm font-medium dark:text-gray-400">Location</h3>
            <p class="text-lg font-semibold dark:text-gray-200">{{$punch_list->location}}</p>
        </div>


        <div>
            <h3 class="text-sm font-medium dark:text-gray-400">Due Date</h3>
            <p class="text-lg font-semibold dark:text-gray-200">{{$punch_list->due_date}}</p>
        </div>


        <!-- Assignees -->
        <div class="mb-6">
            <h3 class="text-sm font-medium dark:text-gray-400 mb-2">Responsible</h3>
			
			
            <div class="flex flex-wrap gap-4">
			
                <div class="flex items-center">
                    <img src="{{$punch_list->responsible->userable->image}}" alt="Profile" class="w-10 h-10 rounded-full mr-4">
                    <p class="  dark:text-gray-200">{{$punch_list->responsible->userable->first_name}} {{$punch_list->responsible->userable->last_name}}</p>
                </div>		
			
            </div>
        </div>

        <!-- Distribution Members -->
        <div class="mb-6">
            <h3 class="text-sm font-medium dark:text-gray-400 mb-2">Distribution Members</h3>
            <div class="flex flex-wrap gap-4">
			@if($punch_list->users->count() > 0)
				@foreach($punch_list->users as $user)
					<div class="flex items-center">
						<img src="{{$user->userable->image}}" alt="Profile" class="w-10 h-10 rounded-full mr-4">
                        <p class="  dark:text-gray-200">{{$punch_list->responsible->userable->first_name}} {{$punch_list->responsible->userable->last_name}}</p>
					</div>
					
				@endforeach
				
			@endif	
            </div>
        </div>
    </div>

    <!-- Description -->
    <div class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <h3 class="text-sm font-medium dark:text-gray-400 mb-1">Description</h3>
                <p class="text-lg dark:text-gray-200">{!! $punch_list->description   !!}.</p>
            </div>
            
            <div>
                <h3 class="text-sm font-medium dark:text-gray-400 mb-2">Attached Files</h3>
                <div class="grid grid-cols-2 gap-4">
                @if($punch_list->files->count() > 0)
                    @foreach($punch_list->files as $file)
                        <div class="bg-gray-100 dark:bg-gray-800 p-4  flex items-center justify-between">
                            <div class="flex items-center">
                                <i data-feather="file" class="w-6 h-6 mr-3 dark:text-gray-400"></i>
                                <p class="text-sm dark:text-gray-200">{{$file->file}}</p>
                            </div>
                            <a target="_blank" href="{{Storage::url('project'.$punch_list->project_id.'/punch_list'.$punch_list->id.'/'.$file->file)}}" class="text-blue-500 hover:underline"><i data-feather="arrow-down-circle"></i></a>
                        </div>            
                    @endforeach
                @endif
                </div>
            </div>

       
        </div>
    </div>

    <!-- Attachments -->
    <div class="mb-4">
        
    </div>

    <h3 class="font-medium dark:text-gray-400 mb-2">Replies</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse border dark:border-gray-800">
            <thead class="bg-gray-100 dark:bg-gray-800 text-sm text-left">
                <tr>
                    <th class="px-6 py-3 font-light">Subject</th><!-- WILL HAVE LINK TO REDIRECT (target="_blank") -->
                    <th class="px-6 py-3 font-light">description</th>
                    <th class="px-6 py-3 font-light">Created By</th>
                    <th class="px-6 py-3 font-light">Created Date</th>
                   
                    <th class="px-6 py-3 font-light">file</th>
                </tr>
            </thead>
            <tbody id="table-body">
                @if ($punch_list->replies->count() > 0)
                @foreach ($punch_list->replies as $reply)                
                    <tr class="border dark:border-gray-800">
                        <td class="px-6 py-4">{{$reply->title}}</td>
                        <td class="px-6 py-4">{!! $reply->description !!}</td>
                        <td class="px-6 py-4">{{$reply->user->name}}</td>
                        <td class="px-6 py-4">{{$reply->created_date}}</td>
                        <td class="px-6 py-4">

                            <div class="bg-gray-100 dark:bg-gray-800 p-4  flex items-center justify-between">
                                <div class="flex items-center">
                                    <i data-feather="file" class="w-6 h-6 mr-3 dark:text-gray-400"></i>
                                    <p class="text-sm dark:text-gray-200">{{$reply->file}}</p>
                                </div>
                                <a target="_blank" href="{{Storage::url('project'.$punch_list->project_id.'/punch_list'.$punch_list->id.'/replies/'.$reply->file)}}" class="text-blue-500 hover:underline"><i data-feather="arrow-down-circle"></i></a>
                            </div>  
                        </td>
                       
                    </tr>
                @endforeach
                
            @endif
               
                <!-- Rows will be dynamically loaded -->
            </tbody>
        </table>
    </div>
</div>


@include('metsl.pages.punch-list.ChageStatus')
@include('metsl.pages.punch-list.addReply')
<script>

</script>
@endsection

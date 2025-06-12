@extends('metsl.layouts.master')

@section('title', 'Correspondence - Create')

@section('content')
<div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold hidden success"></div>
<div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>
<div class="flex items-end mb-3">
    <h1 class="text-lg dark:text-gray-200"><a href="{{ route('projects.correspondence') }}">Correspondence</a> / <b>{{$correspondece->number}}</b></h1>
    @if(\App\Enums\CorrespondenceStatusEnum::CLOSED->value != $correspondece->status)
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
            @if($correspondece->created_by == \Auth::user()->id 
            || checkIfUserHasThisPermission(Session::get('projectID') ,'reply_'.$correspondece->type->value))
            <a href="{{ url('project/correspondence/create?type='.$correspondece->type->value.'&correspondece='.$correspondece->id) }}" class="flex px-4 py-2 hover:bg-gray-700"><i data-feather="corner-up-left" class="mr-2"></i>Reply</a>
            @endif

            @if($correspondece->created_by == \Auth::user()->id )
                @if ($correspondece->reply_correspondence_id == NULL)
                        <a onclick="close_correspondence({{ $correspondece->id }}  , '{{ $correspondece->number }}')"  href="#" class="flex px-4 py-2 hover:bg-gray-700"><i data-feather="corner-up-left" class="mr-2"></i>Closed</a>
            
                @endif

            @endif

            @if (checkIfUserHasThisPermission(Session::get('projectID') ,'reply_'.$correspondece->type->value) 
            && $correspondece->type->value == App\Enums\CorrespondenceTypeEnum::RFC->value && $correspondece->created_by != \Auth::user()->id) 
                @if ($correspondece->status == App\Enums\CorrespondenceStatusEnum::OPEN->value)
                    <a onclick="accept_correspondence({{ $correspondece->id }}  , '{{ $correspondece->number }}')"  href="#" class="flex px-4 py-2 hover:bg-gray-700"><i data-feather="corner-up-left" class="mr-2"></i>Accept</a>
                    <a onclick="reject_correspondence({{ $correspondece->id }}  , '{{ $correspondece->number }}')"  href="#" class="flex px-4 py-2 hover:bg-gray-700"><i data-feather="corner-up-left" class="mr-2"></i>Reject</a>
                   
                @endif
            
            @endif


            @if (checkIfUserHasThisPermission(Session::get('projectID') ,'reply_'.$correspondece->type->value) 
            && $correspondece->type->value == App\Enums\CorrespondenceTypeEnum::INS->value && $correspondece->created_by != \Auth::user()->id) 
                @if ($correspondece->status == App\Enums\CorrespondenceStatusEnum::OPEN->value)
                    <a onclick="accept_correspondence({{ $correspondece->id }}  , '{{ $correspondece->number }}')"  
                        href="#" class="flex px-4 py-2 hover:bg-gray-700"><i data-feather="corner-up-left" class="mr-2"></i>Accept</a>
                   
                @endif
            
            @endif


            @if($correspondece->created_by == \Auth::user()->id && $correspondece->reply_correspondence_id == NULL
            && $correspondece->status != App\Enums\CorrespondenceStatusEnum::CLOSED->value)
                <button type="button" class="modal-toggler  px-4 py-2 hover:bg-gray-700" data-modal="delay-modal">
                    <i data-feather="corner-up-left" class="mr-2"></i>delay
                </button>
            @endif

        </div>
    </div>
    @endif
</div>


<!-- Correspondence Information -->
 <div class="pt-4 bg-white dark:bg-gray-900 ">

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-6">
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

                <div>
            <h3 class="text-sm font-medium dark:text-gray-400">Due Date</h3>
            <p class="text-lg font-semibold dark:text-gray-200">{{$correspondece->due_date}}</p>
        </div>

        <!-- Assignees -->
        <div class="mb-6">
            <h3 class="text-sm font-medium dark:text-gray-400 mb-2">Assignees</h3>
			
			
            <div class="flex flex-wrap gap-4">
			
			@if($correspondece->assignees->count() > 0)
				@foreach($correspondece->assignees as $user)
					<div class="flex items-center">
						<img src="{{$user->profile_photo_path}}" alt="Profile" class="w-10 h-10 rounded-full mr-4">
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
						<img src="{{$user->profile_photo_path}}" alt="Profile" class="w-10 h-10 rounded-full mr-4">
						<p class="  dark:text-gray-200">{{$user->name}}</p>
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
                <h3 class="text-sm font-medium dark:text-gray-400 mb-2">Attached Files</h3>
                <div class="grid grid-cols-2 gap-4">
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



            <div>
                <h3 class="text-sm font-medium dark:text-gray-400 mb-2">Related Correspondences</h3>
                <div class="grid grid-cols-2 gap-4">
                @if($correspondece->relatedCorrespondences->count() > 0)
                    @foreach($correspondece->relatedCorrespondences as $row)
                        <div class="bg-gray-100 dark:bg-gray-800 p-4  flex items-center justify-between">
                            <div class="flex items-center">
                                <p class="text-sm dark:text-gray-200">
                                    
                                   <a target="_blank" href="{{ route('projects.correspondence.view',$row->id) }}"
                                     class="text-blue-500 hover:underline">{{ $row->number }} / {{ $row->subject }}</a>

                                </p>
                            </div>
                            
                        </div>
            
                
                    @endforeach
                    
                
                @endif
                </div>
            </div>


            <div>
                <h3 class="text-sm font-medium dark:text-gray-400 mb-1">Description</h3>
                <p class="text-lg dark:text-gray-200">{!! $correspondece->description   !!}.</p>
            </div>

            <div>
                <h3 class="text-sm font-medium dark:text-gray-400 mb-2">Linked Documents</h3>
                <div class="grid grid-cols-2 gap-4">
                @if($correspondece->documentFiles->count() > 0)
                    @foreach($correspondece->documentFiles as $file)
                        <div class="bg-gray-100 dark:bg-gray-800 p-4  flex items-center justify-between">
                            <div class="flex items-center">
                                <i data-feather="file" class="w-6 h-6 mr-3 dark:text-gray-400"></i>
                                <p class="text-sm dark:text-gray-200">{{$file->file}}</p>
                            </div>
                            @if($file->pivot->revision_id == NULL || $file->pivot->revision_id == 0)
                                <a target="_blank" href="{{Storage::url('project'.$correspondece->project_id.'/documents'.$file->project_document_id.'/'.$file->file)}}" class="text-blue-500 hover:underline"><i data-feather="arrow-down-circle"></i></a>
                           
                            @else
                            <a target="_blank" href="{{Storage::url('project'.$correspondece->project_id.'/documents'.$file->project_document_id.'/revisions/'.$file->file)}}" class="text-blue-500 hover:underline"><i data-feather="arrow-down-circle"></i></a>

                            @endif
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

    <h3 class="font-medium dark:text-gray-400 mb-2">RELATED ACTIVITY</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse border dark:border-gray-800">
            <thead class="bg-gray-100 dark:bg-gray-800 text-sm text-left">
                <tr>
                    <th class="px-6 py-3 font-light">Number</th>
                    <th class="px-6 py-3 font-light">Subject</th><!-- WILL HAVE LINK TO REDIRECT (target="_blank") -->
                    <th class="px-6 py-3 font-light">Description</th>
                    <th class="px-6 py-3 font-light">Assignees</th>
                    <th class="px-6 py-3 font-light">Created By</th>
                    <th class="px-6 py-3 font-light">Issued On</th>
                    <th class="px-6 py-3 font-light">Due Date</th>
                    <th class="px-6 py-3 font-light">Status</th>
                </tr>
            </thead>
            <tbody id="table-body">
                @if ($others_correspondeces_realated->count() > 0)
                    @foreach ($others_correspondeces_realated as $correspondece_row)                
                        <tr class="border dark:border-gray-800">
                            <td class="px-6 py-4">{{$correspondece_row->number}}</td>
                            <td class="px-6 py-4"><a class="underline" href="{{route('projects.correspondence.view', $correspondece_row->id)}}">{{$correspondece_row->subject}}</a></td>
                            <td class="px-6 py-4">{!! $correspondece_row->description   !!}</td>
                            <td class="px-6 py-4">{{$correspondece_row->assignees}}</td>
                            <td class="px-6 py-4">{{$correspondece_row->CreatedBy->name}}</td>
                            <td class="px-6 py-4">{{$correspondece_row->created_date}}</td>
                            <td class="px-6 py-4">{{$correspondece_row->recieved_date ?? ''}}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs  {{$correspondece_row->status_color[1]}}">{{$correspondece_row->status_color[0]}}


                                </span>
                            </br>
                                <small class="text-xs font-semibold">{{ ($correspondece_row->ChangedBy != NULL)?'by ':'' }} {{$correspondece_row->ChangedBy?->name??''}}</small>

                            </td>
                            {{-- <td class="px-4 py-2 inline-flex space-x-4 items-center"> --}}
                                {{-- <button onclick="deleteCorrespondence({{$correspondece->id}})" class="text-red-500 dark:text-red-400 hover:text-red-300">
                                    <i data-feather="trash" class="w-5 h-5"></i>
                                </button> --}}
                                {{-- <a target="_blank" href="{{route('projects.correspondence.edit', $correspondece->id)}}" class="text-gray-500 dark:text-gray-400 hover:text-gray-400">
                                    <i data-feather="edit" class="w-5 h-5"></i>
                                </a> --}}
                            {{-- </td> --}}
                        </tr>
                    @endforeach
                    
                @endif
                <!-- Rows will be dynamically loaded -->
            </tbody>
        </table>
    </div>
</div>


<div id="delay-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white dark:bg-gray-800  shadow-lg max-w-3xl w-full p-6">
        <!-- Modal Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold dark:text-gray-200"> delay</h2>
            <button data-modal="delay-modal" class="modal-toggler text-gray-500 hover:text-gray-800 dark:hover:text-gray-300 transition">
                <i data-feather="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Upload Form -->
        <form id="upload-form-delay"  method="POST" enctype="multipart/form-data">
			@csrf
			<input type="hidden" value="{{\Session::get('projectID')}}" name="project_id"/>
            <input type="hidden" value="{{$correspondece->id}}" name="id"/>

            <!-- Title -->
                 <div class="md:col-span-1">
                    <label for="due_days" class="block text-sm mb-2 font-medium dark:text-gray-200">Due Days</label>
                    <select id="due_days" required name="due_days" class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200">
 
                        <option value="5">5 day</option>
                        <option value="7">7 day</option>
                        <option value="10">10 day</option>
                        <option value="14">14 day</option>
                        <option value="17">17 day</option>
                        <option value="21">21 day</option>
                        <option value="24">24 day</option>
                        <option value="27">27 day</option>
                        <option value="30">30 day</option>

                    </select>
            
                </div>	

           

            <!-- Submit Button -->

            <button
                type="submit" id="submit_upload_form_delay"
                class="flex gap-x-2 bg-blue-500 text-white px-4 py-2  hover:bg-blue-600 transition"
            >   <i data-feather="upload"></i>
                Save
            </button>
        </form>
    </div>
</div>

<script>
     $("#upload-form-delay").on("submit", function(event) {
        const form = document.getElementById("upload-form-delay");
        const formData = new FormData(form); 
            $('.error').hide();
            $('.success').hide();
            $('.err-msg').hide();
            $(".error").html("");
            $(".success").html("");
            event.preventDefault();  
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('projects.correspondence.delay') }}" ,
                type: "POST",
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: function() {
                    $("#submit_upload_form_delay").prop('disabled', true);
                },
                success: function(data) {
                    if (data.success) {
                         
                        $("#submit_upload_form_delay").prop('disabled', false);
                        
                        //$("#upload-form-delay")[0].reset();
						
						window.scrollTo(0,0);
						document.getElementById("delay-modal").classList.add("hidden");

                        $('.success').show();
                        $('.success').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+data.success+'</div>');  
						

                        setInterval(function() {
							location.reload();
							}, 3000); 
						


                    }
                    else if(data.error){
                        $("#submit_upload_form_delay").prop('disabled', false);

                        $('.error').show();
                        $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+data.error+'</div>');
                    }
                },
                error: function (err) {
                    $.each(err.responseJSON.errors, function(key, value) {
                            $('.error').show();
                            $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+value[0]+'</div>');
                            var el = $(document).find(`[name="${key=='reviewers' ? 'reviewers[]' : key}"]`);
							el.after($('<div class= "err-msg text-red-500  px-2 py-1 text-sm font-semibold">' + value[0] + '</div>'));
                            if(el.length == 0){
                                el = $(document).find('#file-upload');
								el.after($('<div class= "err-msg text-red-500  px-2 py-1 text-sm font-semibold">the documents must be pdf </div>'));
								
                            }
                            
                        });

                        $("#submit_upload_form_delay").prop('disabled', false);


                }
            });
    
      });

    async function close_correspondence(id , name){
        const confirmed = confirm(`Are you sure you want to close "${name}"?`);
        if (confirmed) {
            $('.error').hide(); 
            $('.success').hide();
            let url =`/project/correspondence/close/${id}`;		
            let fetchRes = await fetch(url);
            if(fetchRes.status != 200){
                $('.error').show();
                $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+fetchRes.statusText+'</div>');

            }else{
                //console.log(fetchRes);

                $('.success').show();
                $('.success').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold"> Item Closed Successfully</div>');

                setInterval(function() {
                    location.reload();
                }, 3000);	
            }
        }



    }

    async function accept_correspondence(id , name){
        const confirmed = confirm(`Are you sure you want to accept "${name}"?`);
        if (confirmed) {
            $('.error').hide(); 
            $('.success').hide();
            let url =`/project/correspondence/accept/${id}`;		
            let fetchRes = await fetch(url);
            if(fetchRes.status != 200){
                $('.error').show();
                $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+fetchRes.statusText+'</div>');

            }else{
                //console.log(fetchRes);

                $('.success').show();
                $('.success').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold"> Item accepted Successfully</div>');

                setInterval(function() {
                    location.reload();
                }, 3000);	
            }
        }



    }


    async function reject_correspondence(id , name){
        const confirmed = confirm(`Are you sure you want to reject "${name}"?`);
        if (confirmed) {
            $('.error').hide(); 
            $('.success').hide();
            let url =`/project/correspondence/reject/${id}`;		
            let fetchRes = await fetch(url);
            if(fetchRes.status != 200){
                $('.error').show();
                $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+fetchRes.statusText+'</div>');

            }else{
                //console.log(fetchRes);

                $('.success').show();
                $('.success').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold"> Item rejected Successfully</div>');

                setInterval(function() {
                    location.reload();
                }, 3000);	
            }
        }



    }

</script>

@endsection

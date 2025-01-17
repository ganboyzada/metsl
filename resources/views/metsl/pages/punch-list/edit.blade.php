@extends('metsl.layouts.master')

@section('title', 'Punch List - Create')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-semibold mb-6 dark:text-gray-200">Add a Punch Item</h1>
	<div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold hidden success"></div>
	<div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>

    @if(session()->has('success'))
        <div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold">
            {{ session()->get('success') }}
        </div>
    @endif    
	<form id="snag-item-form" class="space-y-6"  method="POST" enctype="multipart/form-data">
		@csrf
		<input type="hidden" name="project_id" value="{{ \Session::get('projectID') }}"/>
        <input type="hidden" name="id" value="{{ $punch_list_id }}"/>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Title (Required) -->
            <div>
                <label for="title" class="block text-sm mb-2 font-medium dark:text-gray-200">Title <span class="text-red-500">*</span></label>
                <input
                    type="text"
                    id="title" name="title"
                    class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200"
                    placeholder="Enter title"
                    value="{{ $punch_list->title }}"
                    required
                />
            </div>

            <!-- Number (#) (Required) -->
            <div>
                <label for="number" class="block text-sm mb-2 font-medium dark:text-gray-200">Number (#) <span class="text-red-500">*</span></label>
                <input
                    type="text"
                    id="number" name="number"
                    class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200"
                    placeholder="Enter number"
                     value="{{ $punch_list->number }}"
                    required
                />
            </div>

            <!-- Responsible Member (Single Selector) (Required) -->
            <div>
                <label for="responsible-member" class="block text-sm mb-2 font-medium dark:text-gray-200">Responsible Member <span class="text-red-500">*</span></label>
                <select id="responsible-member" name="responsible_id" class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200" required>
                
                </select>
            </div>

            <!-- Distribution Members (Multiple Selector) -->
            <div>
                <label for="distribution-members" class="block text-sm mb-2 font-medium dark:text-gray-200">Distribution Members</label>
                <select id="distribution-members"  name="participates[]" multiple class="choices w-full border dark:bg-gray-800 dark:text-gray-200">
            
                </select>
            </div>

            <!-- Location -->
            <div>
                <label for="location" class="block text-sm mb-2 font-medium dark:text-gray-200">Location</label>
                <input
                    type="text"
                     value="{{ $punch_list->location }}"
                    id="location" name="location"
                    class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200"
                    placeholder="Enter location"
                />
            </div>

            <!-- Priority -->
            <div>
                <label for="priority" class="block text-sm mb-2 font-medium dark:text-gray-200">Priority</label>
                <select id="priority" name="priority" class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200">
					@php
					$status_list = \App\Enums\PunchListPriorityEnum::cases();
					@endphp
					@foreach ($status_list as $status)
						<option value="{{$status->value}}" {{  ($status->value == $punch_list->priority_val) ? 'selected':'' }} >{{$status->name}}</option>
					@endforeach
                </select>
            </div>

            <!-- Cost Impact -->
            <div>
                <label for="cost-impact" class="block text-sm mb-2 font-medium dark:text-gray-200">Cost Impact</label>
                <select id="cost-impact" name="cost_impact" class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200">

					@php
					$enums_list = \App\Enums\CorrespondenceCostImpactEnum::cases();
					@endphp
					@foreach ($enums_list as $enum)
						<option value="{{$enum->value}}"  {{  $enum->value == $punch_list->cost_impact ? 'selected':'' }} >{{$enum->name}}</option>
					@endforeach
					
                </select>
            </div>
			
			
            <div>
                <label for="status" class="block text-sm mb-2 font-medium dark:text-gray-200">status</label>
                <select id="status" name="status" class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200">

					@php
					$enums_list = \App\Enums\PunchListStatusEnum::cases();
					@endphp
					@foreach ($enums_list as $enum)
						<option value="{{$enum->value}}"  {{  $enum->value == $punch_list->status_val ? 'selected':'' }} >{{$enum->text()}}</option>
					@endforeach
					
                </select>
            </div>			
			
            <div>
                <label for="date_notified_at" class="block text-sm mb-2 font-medium dark:text-gray-200">Notified Date at</label>
                <input
                    type="date"
                    value="{{ $punch_list->date_notified_at }}"
                    name="date_notified_at"
                    id="date_notified_at"
                    class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200"
                    required
                />
            </div>			
			

            <div>
                <label for="date_resolved_at" class="block text-sm mb-2 font-medium dark:text-gray-200">Resolved Date</label>
                <input
                    type="date"
                    value="{{ $punch_list->date_resolved_at }}"
                    name="date_resolved_at"
                    id="date_resolved_at"
                    class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200"
                    required
                />
            </div>			

            
            <div>
                <label for="due_date" class="block text-sm mb-2 font-medium dark:text-gray-200">Due Date</label>
                <input
                    type="date"
                    value="{{ $punch_list->due_date }}"
                    name="due_date"
                    id="due_date"
                    class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200"
                    required
                />
            </div>		
			
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm mb-2 dark:text-gray-200">Description</label>
                <textarea
                    id="description" name="description"
                    class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200"
                    rows="4"
                    placeholder="Enter description"
                >{{ $punch_list->description }}</textarea>
            </div>

            <!-- Attachments (Dropzone) -->
            <div>
                <label class="block mb-2 text-sm">Attachments (PDF, JPG, JPEG, PNG)</label>
                <div id="drop-zone" class="flex flex-col items-center justify-center w-full h-full border-2 border-dashed  dark:bg-gray-800 dark:border-gray-700 border-gray-300">
                    <div class="flex flex-col items-center justify-center">
                        <i data-feather="upload" class="w-10 h-10 text-gray-500"></i>
                        <p class="text-sm text-gray-500">Click to upload or drag and drop</p>
                        <p class="text-xs text-gray-500">PDF, JPG, JPEG, PNG (max. 10MB)</p>
                    </div>
                <input id="file-upload" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps"  name="docs[]" type="file" class="hidden" multiple>
                </div>
                <ul id="file-list" class="mt-4 space-y-2">
                    @if ($punch_list->files->count()  > 0)
                    <ul id="file-list" class="mt-4 space-y-2">
                        @foreach ( $punch_list->files as $file )
                            <li class="flex justify-between"><a href="{{ asset('storage/project'.$punch_list->project_id.'/punch_list'.$punch_list->id.'/'.$file->file)  }}" target="_blank">{{ $file->file  }}   ( {{ $file->size != NULL ? round($file->size/1024 , 2) : 0  }} kb )</a>
                                <a href={{ route('projects.punch-list.destroy-file',[$file->id]) }} class="text-red-500 dark:text-red-400 hover:text-red-300">
									<i data-feather="delete" class="w-5 h-5"></i>
								</a>
                            </li>
                        @endforeach
                    </ul>   
                    @endif
                    <!-- Uploaded files will appear here -->
                </ul>
            </div>
        
        </div>

        <!-- Submit Button -->
        <button
            type="submit"
            class="submit_punch_list_form px-4 py-2 bg-blue-500 text-white hover:bg-blue-600"
        >
            Submit Punch Item
        </button>
    </form>
</div>
<script>
    $("#snag-item-form").on("submit", function(event) {
        const form = document.getElementById("snag-item-form");
        const formData = new FormData(form); 
            formData.append('description',tinyMCE.get('description').getContent());
    
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
                url: "{{ route('projects.punch-list.update') }}",
                type: "POST",
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: function() {
                    $(".submit_punch_list_form").prop('disabled', true);
                },
                success: function(data) {
                    if (data.success) {
                         
                        $(".submit_punch_list_form").prop('disabled', false);
                        
                        $("#snag-item-form")[0].reset();
						
						window.scrollTo(0,0);

                        $('.success').show();
                        $('.success').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+data.success+'</div>');  
						
                        $('#file-list').html('');
						setInterval(function() {
							location.reload();
						}, 3000);						


                    }
                    else if(data.error){
                        $(".submit_punch_list_form").prop('disabled', false);

                        $('.error').show();
                        $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+data.error+'</div>');
                    }
                },
                error: function (err) {
                    $.each(err.responseJSON.errors, function(key, value) {
                            var el = $(document).find('[name="'+key + '"]');
							el.after($('<div class= "err-msg text-red-500  px-2 py-1 text-sm font-semibold">' + value[0] + '</div>'));
                            if(el.length == 0){
                                el = $(document).find('#file-upload');
								el.after($('<div class= "err-msg text-red-500  px-2 py-1 text-sm font-semibold">the documents must be pdf </div>'));
								
                            }
                            
                        });

                        $(".submit_punch_list_form").prop('disabled', false);


                }
            });
    
    });
	  
    /*  
	$(".projectButton").on('click',function(event) {
		if(localStorage.getItem("project_tool") == 'punch_list'){
			get_participates2();
		}
		
	});
		
	async  function get_participates2(){
		let fetchRes = await fetch(`{{url('project/punch-list/participates')}}`);
		const all = await fetchRes.json();
		$('[name="number"]').val(all.next_number);

		let reviewers = all.distribution_members.map(function(item) {
		  return {'value' : item.id , 'label' : item.name};
		});
			distribution_obj.clearStore();
			distribution_obj.setChoices(reviewers);	

			reviewers = all.responsible.map(function(item) {
			  return {'value' : item.id , 'label' : item.name};
			});	
			reviewers_obj.clearStore();
			reviewers_obj.setChoices(reviewers);
		
	}
	*/

	get_participates();
	async  function get_participates(){
		if(localStorage.getItem("project_tool") == 'punch_list'){

			let fetchRes = await fetch(`{{url('project/punch-list/participates')}}`);
			const all = await fetchRes.json();
			let distrbution_members ={!! json_encode($punch_list->users) !!}  ;
            
            let selected_distrbution_members=distrbution_members.map(function(item) {
			  return item.id;
			})	;
			let reviewers = all.distribution_members.map(function(item) {
			  return {'value' : item.id , 'label' : item.name , 'selected' : selected_distrbution_members.includes(item.id) ? true : false };
			});

            distribution_obj.clearStore();
            distribution_obj.setChoices(reviewers);	
			
            let resposible_id = `{{ $punch_list->responsible_id }}`;
			reviewers = all.responsible.map(function(item) {
			  return {'value' : item.id , 'label' : item.name , 'selected' : resposible_id == item.id ? true : false};
			});	
            reviewers_obj.clearStore();
            reviewers_obj.setChoices(reviewers);	
			
		}	
	
    }
        
	

    document.addEventListener('DOMContentLoaded', () => {
		
		distribution_obj = populateChoices2('distribution-members', [], true);		
		reviewers_obj = populateChoices2('responsible-member', [] , false);	
		
    }); 

</script>
@endsection
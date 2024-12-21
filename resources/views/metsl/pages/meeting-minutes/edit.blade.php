@extends('metsl.layouts.master')

@section('title', 'Plan a Meeting')

@section('content')
<div>
    <h1 class="text-2xl font-semibold mb-6 dark:text-gray-200">Edit Meeting Planner</h1>
	<div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold hidden success"></div>
	<div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>
    @if(session()->has('success'))
    <div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold">
        {{ session()->get('success') }}
    </div>
    @endif  
    <!-- Meeting Planner Form -->
    <form id="meeting-planner-form" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"  method="POST" enctype="multipart/form-data">
		@csrf
		<input type="hidden" name="project_id" value="{{ \Session::get('projectID') }}"/>
        <input type="hidden" name="id" value="{{ $meeting_id }}"/> 

        <!-- Meeting # -->
        <div class="col-span-1">
            <label for="meeting-number" class="block text-sm mb-2 font-medium dark:text-gray-200">Meeting #</label>
            <input
                type="text" value="{{ $meeting->number }}"
				name="number"
                id="meeting-number"
                class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200"
                placeholder="Enter meeting number"
                required
            />
        </div>

        <!-- Meeting Name -->
        <div class="col-span-1">
            <label for="meeting-name" class="block text-sm mb-2 font-medium dark:text-gray-200">Meeting Name</label>
            <input
                type="text" value="{{ $meeting->name }}"
                id="name"
				name="name"
                class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200"
                placeholder="Enter meeting name"
                required
            />
        </div>

        <!-- Conference Link -->
        <div class="col-span-1">
            <label for="conference-link" class="block text-sm mb-2 font-medium dark:text-gray-200">Conference Link</label>
            <input
                type="url"
				name="link" value="{{ $meeting->link }}"
                id="conference-link"
                class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200"
                placeholder="Enter link (e.g., Zoom, Teams)"
            />
        </div>

        <!-- Meeting Location -->
        <div class="col-span-1">
            <label for="meeting-location" class="block text-sm mb-2 font-medium dark:text-gray-200">Meeting Location</label>
            <input
                type="text"
				name="location" value="{{ $meeting->location }}"
                id="meeting-location"
                class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200"
                placeholder="Enter location"
            />
        </div>

        <!-- Planned Date -->
        <div class="col-span-1">
            <label for="planned-date" class="block text-sm mb-2 font-medium dark:text-gray-200">Planned Date</label>
            <input
                type="date" value="{{ $meeting->planned_date }}"
				name="planned_date"
                id="planned-date"
                class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200"
                required
            />
        </div>

        <!-- Start Time -->
        <div class="col-span-1">
            <label for="start-time" class="block text-sm mb-2 font-medium dark:text-gray-200">Start Time</label>
            <input
                type="time" value="{{ $meeting->start_time }}"
				name="start_time"
                id="start-time"
                class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200"
                required
            />
        </div>

        <!-- Duration -->
        <div class="col-span-1">
            <label for="duration" class="block text-sm mb-2 font-medium dark:text-gray-200">Duration</label>
            <select id="duration" name="duration" class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200">
                <option value="5" {{ $meeting->duration == 5 ? 'selected' : '' }}>5 minutes</option>
                <option value="15" {{ $meeting->duration == 15 ? 'selected' : '' }}>15 minutes</option>
                <option value="30" {{ $meeting->duration == 30 ? 'selected' : '' }}>30 minutes</option>
                <option value="45" {{ $meeting->duration == 45 ? 'selected' : '' }}>45 minutes</option>
                <option value="60" {{ $meeting->duration == 60 ? 'selected' : '' }}>1 hour</option>
                <option value="90" {{ $meeting->duration == 90 ? 'selected' : '' }}>1.5 hours</option>
                <option value="120"> {{ $meeting->duration == 120 ? 'selected' : '' }}2 hours</option>
            </select>
        </div>

        <!-- Time Zone -->
        <div class="col-span-1">
            <label for="time-zone" class="block text-sm mb-2 font-medium dark:text-gray-200">Time Zone</label>
            <select id="time-zone" name="timezone" class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200">
                <option value="GMT-12" {{ $meeting->timezone == 'GMT-12' ? 'selected' : '' }}>GMT-12</option>
                <option value="GMT-11" {{ $meeting->timezone == 'GMT-11' ? 'selected' : '' }}>GMT-11</option>
                <option value="GMT-10"{{ $meeting->timezone == 'GMT-10' ? 'selected' : ''  }}>GMT-10</option>
                <option value="GMT-9" {{ $meeting->timezone == 'GMT-9' ? 'selected' : '' }}>GMT-9</option>
                <option value="GMT-8" {{ $meeting->timezone == 'GMT-8' ? 'selected' : ''  }}>GMT-8</option>
                <option value="GMT-7" {{ $meeting->timezone == 'GMT-7' ? 'selected' : '' }}>GMT-7</option>
                <option value="GMT-6" {{ $meeting->timezone == 'GMT-6' ? 'selected' : '' }}>GMT-6</option>
                <option value="GMT-5" {{ $meeting->timezone == 'GMT-5' ? 'selected' : '' }}>GMT-5</option>
                <option value="GMT-4" {{ $meeting->timezone == 'GMT-4' ? 'selected' : '' }}>GMT-4</option>
                <option value="GMT-3"{{ $meeting->timezone == 'GMT-3' ? 'selected' : '' }}>GMT-3</option>
                <option value="GMT-2"{{ $meeting->timezone == 'GMT-2' ? 'selected' : '' }}>GMT-2</option>
                <option value="GMT-1"{{ $meeting->timezone == 'GMT-1' ? 'selected' : '' }}>GMT-1</option>
                <option value="GMT"{{ $meeting->timezone == 'GMT' ? 'selected' : '' }}>GMT</option>
                <option value="GMT+1"{{ $meeting->timezone == 'GMT+1' ? 'selected' : '' }}>GMT+1</option>
                <option value="GMT+2"{{ $meeting->timezone == 'GMT+2' ? 'selected' : '' }}>GMT+2</option>
                <option value="GMT+3"{{ $meeting->timezone == 'GMT+3' ? 'selected' : ''  }}>GMT+3</option>
                <option value="GMT+4" {{ $meeting->timezone == 'GMT+4' ? 'selected' : ''  }}>GMT+4</option>
                <option value="GMT+5"{{ $meeting->timezone == 'GMT+5' ? 'selected' : '' }}>GMT+5</option>
                <option value="GMT+6"{{ $meeting->timezone == 'GMT+6' ? 'selected' : '' }}>GMT+6</option>
                <option value="GMT+7"{{ $meeting->timezone == 'GMT+7' ? 'selected' : '' }}>GMT+7</option>
                <option value="GMT+8"{{ $meeting->timezone == 'GMT+8' ? 'selected' : '' }}>GMT+8</option>
                <option value="GMT+9"{{ $meeting->timezone == 'GMT+9' ? 'selected' : '' }}>GMT+9</option>
                <option value="GMT+10"{{ $meeting->timezone == 'GMT+10' ? 'selected' : '' }}>GMT+10</option>
                <option value="GMT+11"{{ $meeting->timezone == 'GMT+11' ? 'selected' : ''  }}>GMT+11</option>
                <option value="GMT+12" {{ $meeting->timezone == 'GMT+12' ? 'selected' : '' }}>GMT+12</option>
            </select>
        </div>
		<div class="col-span-1">
			<label for="endDate" class="block font-medium text-gray-700 dark:text-gray-200">status</label>
				<select name="status" id="status"class="mt-1 block w-full   shadow-sm dark:bg-gray-800 dark:text-gray-200">
					@php
					$status_list = \App\Enums\MeetingPlanStatusEnum::cases();
					@endphp
					@foreach ($status_list as $status)
						<option value="{{$status->value}}"{{ $meeting->status->value == $status->value ? 'selected' : '' }}>{{$status->name}}</option> 
					@endforeach
				</select>
        </div>
        <!-- Participants -->
        <div>
            <label for="participants" class="block text-sm mb-2 font-medium dark:text-gray-200">Participants</label>
            <select id="participants" name="participates[]" multiple class="choices w-full border dark:bg-gray-800 dark:text-gray-200">
            </select>
        </div>

        <!-- Meeting Purpose -->
        <div class="col-span-3">
            <label for="meeting-purpose" class="block text-sm mb-2 font-medium dark:text-gray-200">Meeting Purpose</label>
            <textarea
                id="purpose"
				name="purpose"
                class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200"
                rows="3"
                placeholder="Enter the purpose of the meeting"
            >{{ $meeting->purpose }}</textarea>
        </div>

        <!-- Attachments -->
        <div class="col-span-3">
            <label for="attachments" class="block text-sm mb-2 font-medium dark:text-gray-200">Attachments</label>
            <div id="drop-zone" class="flex flex-col items-center justify-center w-full h-full border-2 border-dashed  dark:bg-gray-800 dark:border-gray-700 border-gray-300">
                <div class="flex flex-col items-center justify-center">
                    <i data-feather="upload" class="w-10 h-10 text-gray-500"></i>
                    <p class="text-sm text-gray-500">Click to upload or drag and drop</p>
                    <p class="text-xs text-gray-500">PDF, JPG, JPEG, PNG (max. 10MB)</p>
                </div>
                <input id="file-upload" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps"  name="docs[]" type="file" class="hidden" multiple>
            </div>
            <ul id="file-list" class="mt-4 space-y-2">
                @if ($meeting->files->count()  > 0)
                <ul id="file-list" class="mt-4 space-y-2">
                    @foreach ( $meeting->files as $file )
                        <li class="flex justify-between"><a href="{{ asset('storage/project'.$meeting->project_id.'/meeting_planing'.$meeting->id.'/'.$file->file)  }}" target="_blank">{{ $file->file  }}   ( {{ $file->size != NULL ? round($file->size/1024 , 2) : 0  }} kb )</a>
                            <a href={{ route('projects.meetings.destroy-file',[$file->id]) }} class="text-red-500 dark:text-red-400 hover:text-red-300">
                                <i data-feather="delete" class="w-5 h-5"></i>
                            </a>
                        </li>
                    @endforeach
                </ul>   
                @endif
                <!-- Uploaded files will appear here -->
            </ul>
        </div>

        <!-- Submit Button -->
        <div class="col-span-3 flex justify-end">
            <button
                type="submit"
                class="submit_planing_meeting_form px-6 py-2 bg-blue-500 text-white hover:bg-blue-600"
            >
                Plan Meeting
            </button>
        </div>
    </form>
</div>
@endsection

@push('js')
<script>
 $("#meeting-planner-form").on("submit", function(event) {
        const form = document.getElementById("meeting-planner-form");
        const formData = new FormData(form); 
            formData.append('purpose',tinyMCE.get('purpose').getContent());
    
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
                url: "{{ route('projects.meetings.update') }}",
                type: "POST",
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: function() {
                    $(".submit_planing_meeting_form").prop('disabled', true);
                },
                success: function(data) {
                    if (data.success) {
                         
                        $(".submit_planing_meeting_form").prop('disabled', false);
                        
                        $("#meeting-planner-form")[0].reset();
						
						window.scrollTo(0,0);

                        $('.success').show();
                        $('.success').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+data.success+'</div>');  
						
                        $('#file-list').html('');
						
                        setInterval(function() {
							location.reload();
							}, 3000);

                    }
                    else if(data.error){
                        $(".submit_planing_meeting_form").prop('disabled', false);

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

                        $(".submit_planing_meeting_form").prop('disabled', false);


                }
            });
    
      });
	  


			

	get_participates();
	async  function get_participates(){
		if(localStorage.getItem("project_tool") == 'meeting_planing'){

			let fetchRes = await fetch(`{{url('project/meetings/participates')}}`);
			const all = await fetchRes.json();

            let distrbution_members ={!! json_encode($meeting->users) !!}  ;
            
            let selected_distrbution_members=distrbution_members.map(function(item) {
			  return item.id;
			})	;

			const reviewers = all.users.map(function(item) {
			  return {'value' : item.id , 'label' : item.name ,  'selected': selected_distrbution_members.includes(item.id) ? true : false };
			});
			console.log(reviewers);

			
			reviewers_obj = populateChoices2('participants', reviewers, true);
		}	
	
    }
	


    // let participants = [
        // {'value': '1', 'label': 'John Doe'},
        // {'value': '2', 'label': 'Blake John'},
        // {'value': '3', 'label': 'Dwayne Hunstman'},
        // {'value': '4', 'label': 'Harvey Ramsay'},
        // {'value': '5', 'label': 'Brook Chesterville'}
    // ];

    // document.addEventListener('DOMContentLoaded', () => {
        // populateChoices('participants', participants, true);     
    // }); 
</script>
@endpush
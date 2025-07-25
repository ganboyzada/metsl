@extends('metsl.layouts.master')

@section('title', 'Plan a Meeting')

@section('content')
<div>
    <h1 class="text-2xl font-semibold mb-6 dark:text-gray-200">Meeting Planner</h1>
	<div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold hidden success"></div>
	<div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>
    <!-- Meeting Planner Form -->
    <form id="meeting-planner-form" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4"  method="POST" enctype="multipart/form-data">
		@csrf
		<input type="hidden" id="project_id" name="project_id" value="{{ \Session::get('projectID') }}"/>

        <div class="col-span-1">
            <label for="meeting_type" class="block text-sm mb-2 font-medium dark:text-gray-200">Meeting Type</label>
            <select id="name" onchange="check_type(this)" name="name" class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200" required>
                <option value="">Select type</option>
                @php
                $meeting_types = \App\Models\MeetingTypes::where('project_id', \Session::get('projectID'))->get();
                @endphp

                
                @foreach ($meeting_types as $meeting_type)
                    <option value="{{$meeting_type->name}}">{{$meeting_type->name}}</option>
                @endforeach
                
                <option value="0">Add New</option>

            </select>
            <div class="flex hidden" id="new-meeting-type">
                <input type="text" class=" w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200"  
                        name="new-meeting-type" placeholder="Enter new type">
                        
                <button type="button" id="submit-meeting-type"><i data-feather="save" class="bg-blue-500 text-white p-2"></i></button>
            </div>
            
        </div>

        <!-- Conference Link -->
        <div class="col-span-1">
            <label for="conference-link" class="block text-sm mb-2 font-medium dark:text-gray-200">Conference Link</label>
            <input
                type="url"
				name="link"
                id="conference-link"
                class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200"
                placeholder="Enter link (e.g., Zoom, Teams)"
            />
        </div>

        <!-- Meeting Location -->
        <div class="col-span-1">
            <label for="meeting-location" class="block text-sm mb-2 font-medium dark:text-gray-200">Meeting Location</label>
            <input required
                type="text"
				name="location"
                id="meeting-location"
                class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200"
                placeholder="Enter location"
            />
        </div>

        <!-- Planned Date -->
        <div class="col-span-1">
            <label for="planned-date" class="block text-sm mb-2 font-medium dark:text-gray-200">Planned Date</label>
            <input
                type="date"
				name="planned_date"
                id="planned-date"
                class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200"
                required
            />
        </div>

        <!-- Start Time -->
        <div class="col-span-1">
            <label for="start-time" class="block text-sm mb-2 font-medium dark:text-gray-200">Planned Start</label>
            <input
                type="time"
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
                <option value="5">5 minutes</option>
                <option value="15">15 minutes</option>
                <option value="30">30 minutes</option>
                <option value="45">45 minutes</option>
                <option value="60">1 hour</option>
                <option value="90">1.5 hours</option>
                <option value="120">2 hours</option>
            </select>
        </div>

        <!-- Time Zone -->
        <div class="col-span-1">
            <label for="time-zone" class="block text-sm mb-2 font-medium dark:text-gray-200">Time Zone</label>
            <select id="time-zone" name="timezone" class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200">
                <option value="GMT-12">GMT-12</option>
                <option value="GMT-11">GMT-11</option>
                <option value="GMT-10">GMT-10</option>
                <option value="GMT-9">GMT-9</option>
                <option value="GMT-8">GMT-8</option>
                <option value="GMT-7">GMT-7</option>
                <option value="GMT-6">GMT-6</option>
                <option value="GMT-5">GMT-5</option>
                <option value="GMT-4">GMT-4</option>
                <option value="GMT-3">GMT-3</option>
                <option value="GMT-2">GMT-2</option>
                <option value="GMT-1">GMT-1</option>
                <option value="GMT">GMT</option>
                <option value="GMT+1">GMT+1</option>
                <option value="GMT+2">GMT+2</option>
                <option value="GMT+3">GMT+3</option>
                <option value="GMT+4">GMT+4</option>
                <option value="GMT+5">GMT+5</option>
                <option value="GMT+6">GMT+6</option>
                <option value="GMT+7">GMT+7</option>
                <option value="GMT+8">GMT+8</option>
                <option value="GMT+9">GMT+9</option>
                <option value="GMT+10">GMT+10</option>
                <option value="GMT+11">GMT+11</option>
                <option value="GMT+12">GMT+12</option>
            </select>
        </div>
		<div class="col-span-1 hidden">
			<label for="endDate" class="block font-medium text-gray-700 dark:text-gray-200">Status</label>
				<select   name="status" id="status"class="mt-1 block w-full   shadow-sm dark:bg-gray-800 dark:text-gray-200">
					@php
					$status_list = \App\Enums\MeetingPlanStatusEnum::cases();
					@endphp
					@foreach ($status_list as $status)
						<option value="{{$status->value}}">{{$status->name}}</option>
					@endforeach
				</select>
        </div>
        <!-- Participants -->
        <div class="col-span-2">
            <label for="participants" class="block text-sm mb-2 font-medium dark:text-gray-200">Participants</label>
            <select id="participants"  name="participates[]" multiple class="participates choices w-full border dark:bg-gray-800 dark:text-gray-200">
            </select>
        </div>

        <!-- Meeting Purpose -->
        <div class="col-span-2">
            <label for="meeting-purpose" class="block text-sm mb-2 font-medium dark:text-gray-200">Meeting Agenda</label>
            <textarea
                id="purpose"
				name="purpose"
                class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200"
                rows="3"
                placeholder="Enter the purpose of the meeting"
            ></textarea>
        </div>

        <!-- Attachments -->
        <div class="col-span-1">
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
                <!-- Uploaded files will appear here -->
            </ul>
        </div>

        <!-- Submit Button -->
        <div class="col-span-full flex justify-end">
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
    function check_type(element){
        if(element.value == 0){
            $('#new-meeting-type').removeClass('hidden');
            $('[name="new-meeting-type"]').prop('required', true);
        }else{
            $('#new-meeting-type').addClass('hidden');
            $('[name="new-meeting-type"]').prop('required', false);
        }
        // element.value = '';
    }

    $("#submit-meeting-type").on("click", function(event) {
 
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
                url: "{{ route('projects.meetings.type.store') }}" ,
                type: "POST",
                data: {'name':$('[name="new-meeting-type"]').val() , 'project_id':$('#project_id').val() ,   "_token": "{{ csrf_token() }}",},
                dataType: 'json',
               
             
                success: function(data) {
                    if (data.success) {
                         
                        
                        $('[name="new-meeting-type"]').val('');
						
						window.scrollTo(0,0);
						$('#new-meeting-type').addClass('hidden');

                        $('.success').show();
                        $('.success').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+data.success+'</div>');  
						

                        const select = document.getElementById(`name`);
                        const opt = document.createElement('option');
                        opt.value = data.data.name;
                        opt.innerHTML = data.data.name;
                        select.appendChild(opt);
                        document.getElementById(`name`).value = data.data.name;                    
						


                    }
                    else if(data.error){

                        $('.error').show();
                        $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+data.error+'</div>');
                    }
                },
                error: function (err) {
                    $.each(err.responseJSON.errors, function(key, value) {
                        $('.error').show();
                        $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+value[0]+'</div>');
                            var el = $(document).find(`[name="new-meeting-type"]`);
							el.after($('<div class= "err-msg text-red-500  px-2 py-1 text-sm font-semibold">' + value[0] + '</div>'));
                       
                            
                        });



                }
            });
    
      });
	 

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
                    url: "{{ route('projects.meetings.store') }}",
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
                                window.location.href="{{ route('home') }}";
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
                                $('.error').show();
                                $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+value[0]+'</div>');


                                var el = $(document).find('[name="'+key + '"]');
                                el.after($('<div class= "err-msg text-red-500  px-2 py-1 text-sm font-semibold">' + value[0] + '</div>'));
                                
                                // if(el.length == 0){
                                //     el = $(document).find('#file-upload');
                                //     el.after($('<div class= "err-msg text-red-500  px-2 py-1 text-sm font-semibold">the documents are required </div>'));
                                    
                                // }
                                
                            });

                            $(".submit_planing_meeting_form").prop('disabled', false);


                    }
                });
        
        });
        
    async function set_projectID_participates(){
        var projectId = $('#selected_project_id').val();
        var projectName = $('#selected_project_name').val();
        // let url = `/project/storeIdSession?projectID=${projectId}&projectName=${projectName}`;

        // let fetchRes = await fetch(url);
        get_participates();
    }

	// $(".projectButton").on('click',function(event) {
    //     location.reload();
	// 	if(localStorage.getItem("project_tool") == 'meeting_planing'){
	// 		set_projectID_participates();
	// 	}
		
	// });
		
	// async  function get_participates2(){
		// let fetchRes = await fetch(`{{url('project/meetings/participates')}}`);
		// const all = await fetchRes.json();
		// $('[name="number"]').val(all.next_number);

		// const reviewers = all.users.map(function(item) {
		  // return {'value' : item.id , 'label' : item.name};
		// });
			// console.log(reviewers);

			// reviewers_obj.clearStore();
			// reviewers_obj.setChoices(reviewers);		
	// }
			

	

	async  function get_participates(){
        //alert('ok');
		//if(localStorage.getItem("project_tool") == 'meeting_planing'){

			let fetchRes = await fetch(`{{url('project/meetings/participates')}}`);
			const all = await fetchRes.json();
			$('[name="number"]').val(all.next_number);
			const reviewers = all.users.map(function(item) {
			  return {'value' : item.id , 'label' : item.name};
			});
			//console.log(reviewers);
			reviewers_obj.clearStore();
			reviewers_obj.setChoices(reviewers);
				
		//}	
    }
	
    // let participants = [
        // {'value': '1', 'label': 'John Doe'},
        // {'value': '2', 'label': 'Blake John'},
        // {'value': '3', 'label': 'Dwayne Hunstman'},
        // {'value': '4', 'label': 'Harvey Ramsay'},
        // {'value': '5', 'label': 'Brook Chesterville'}
    // ];

    document.addEventListener('DOMContentLoaded', () => {
       // populateChoices('participants', participants, true); 
		reviewers_obj = populateChoices2('participants', [], true);		
        get_participates();
    }); 
</script>
@endpush
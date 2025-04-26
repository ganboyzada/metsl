@extends('metsl.layouts.master')

@section('title', 'Punch List - Create')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-semibold mb-6 dark:text-gray-200">Add a Punch Item</h1>
	<div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold hidden success"></div>
	<div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>
	<form id="snag-item-form" class="space-y-6"  method="POST" enctype="multipart/form-data">
		@csrf
		<input type="hidden" name="project_id" value="{{ \Session::get('projectID') }}"/>

        

            <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4">
                <!-- Title (Required) -->
                <div class="sm:col-span-1">
                    <label for="title" class="block text-sm mb-2 font-medium dark:text-gray-200">Title <span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        id="title" name="title"
                        class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200"
                        placeholder="Enter title"
                        required
                    />
                </div>

                <!-- Number (#) (Required) -->
                <div class="sm:col-span-1">
                    <label for="number" class="block text-sm mb-2 font-medium dark:text-gray-200">Number (#) <span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        id="number" name="number"
                        class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200"
                        placeholder="Enter number"
                        required
                    />
                </div>

                <!-- Responsible Member (Single Selector) (Required) -->
                <div class="md:col-span-1">
                    <label for="responsible-member" class="block text-sm mb-2 font-medium dark:text-gray-200">Responsible Member <span class="text-red-500">*</span></label>
                    <select id="responsible-member" name="responsible_id" class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200" required>
                
                    </select>
                </div>

                <!-- Priority -->
                <div  class="sm:col-span-1">
                    <label for="priority" class="block text-sm mb-2 font-medium dark:text-gray-200">Priority</label>
                    <select id="priority" name="priority" class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200">
                        @php
                        $status_list = \App\Enums\PunchListPriorityEnum::cases();
                        @endphp
                        @foreach ($status_list as $status)
                            <option value="{{$status->value}}">{{$status->name}}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Distribution Members (Multiple Selector) -->
     

                <!-- Location -->
                <div class="md:col-span-1">
                    <label for="location" class="block text-sm mb-2 font-medium dark:text-gray-200">Location</label>
                    <input
                        type="text"
                        id="location" name="location"
                        class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200"
                        placeholder="Enter location"
                    />
                </div>

                <div class="md:col-span-1">
                    <label for="due_date" class="block text-sm mb-2 font-medium dark:text-gray-200">Due Date</label>
                    <input
                        type="date"
                        name="due_date"
                        id="due_date"
                        class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200"
                        required
                    />
                </div>	
            </div>
            <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">    
                
                <div class="sm:col-span-2">
                    <label for="distribution-members" class="block text-sm mb-2 font-medium dark:text-gray-200">Distribution Members</label>
                    <select id="distribution-members"  name="participates[]" multiple class="choices w-full border dark:bg-gray-800 dark:text-gray-200">
                
                    </select>
                </div>                
                <div class="sm:col-span-2">
                    <label for="linked_documents" class="block text-sm font-medium mb-1">Linked Documents</label>
                    <select id="linked_documents" name="linked_documents[]" multiple class="w-full"></select>
                </div>


                <!-- Submit Button -->
             
            </div>

            <div class="flex flex-wrap md:flex-nowrap items-start gap-6">

          
                <div class="w-full md:w-2/5 mb-4">
                    <label for="description" class="block text-sm mb-2 dark:text-gray-200">Description</label>
                    <textarea
                        id="description" name="description"
                        class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200"
                        rows="4"
                        placeholder="Enter description"
                    ></textarea>
                </div>




                <!-- Attachments (Dropzone) -->
                <div  class=" w-full md:w-2/5 mb-4">
                    <label class="block mb-2 text-sm">Attachments (PDF, JPG, JPEG, PNG)</label>
                    <div id="drop-zone" class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed  dark:bg-gray-800 dark:border-gray-700 border-gray-300">
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
            

        </div>
        <button
        type="submit"
        class="submit_punch_list_form px-4 py-2 mt-5 bg-blue-500 text-white hover:bg-blue-600"
    >
        Submit Item
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
                url: "{{ route('projects.punch-list.store') }}",
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
	  

	$(".projectButton").on('click',function(event) {
		if(localStorage.getItem("project_tool") == 'punch_list'){
			get_participates();
		}
		
	});
		
	async  function get_participates(){
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


            let files =  {!! json_encode($files) !!};
			const allfiles = files.map(function(item) {
			  return {'value' : item.file_id+'-'+item.revisionid  , 'label' : item.project_document.number};
			});	
			linked_documents.clearStore();
			linked_documents.setChoices(allfiles);	
		
	}
			

	get_participates();
	
	
	document.addEventListener('DOMContentLoaded', () => {
		distribution_obj = populateChoices2('distribution-members', [], true);	
		reviewers_obj = populateChoices2('responsible-member', []);		
        linked_documents = populateChoices2('linked_documents', [], false);		

		
    }); 

	



</script>
@endsection
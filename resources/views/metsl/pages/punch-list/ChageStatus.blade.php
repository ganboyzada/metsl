<!-- status Modal -->
<div id="status-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white dark:bg-gray-800  shadow-lg max-w-3xl w-full p-6">
        <!-- Modal Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold dark:text-gray-200">Upload Documents</h2>
            <button data-modal="status-modal" class="modal-toggler text-gray-500 hover:text-gray-800 dark:hover:text-gray-300 transition">
                <i data-feather="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Upload Form -->
        <form id="status-form"  method="POST" enctype="multipart/form-data">
			@csrf
			<input type="hidden" value="{{\Session::get('projectID')}}" name="project_id"/>
			<input type="hidden" value="{{ $punch_list->id }}" id="punchlistt_id" name="id"/>

            
            
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

            <!-- Submit Button -->
            <button
                type="submit" id="submit_edit_form"
                class="flex gap-x-2 bg-blue-500 text-white px-4 py-2  hover:bg-blue-600 transition"
            >   <i data-feather="upload"></i>
                Change
            </button>
        </form>
    </div>
</div>
<script>
 
    $("#status-form").on("submit", function(event) {
           const form = document.getElementById("status-form");
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
                   url:  "{{ route('projects.punch-list.change_status') }}" ,
                   type: "POST",
                   data: formData,
                   dataType: 'json',
                   contentType: false,
                   processData: false,
                   cache: false,
                   beforeSend: function() {
                       $("#submit_edit_form").prop('disabled', true);
                   },
                   success: function(data) {
                       if (data.success) {
                            
                           $("#submit_edit_form").prop('disabled', false);
                           
                           $("#status-form")[0].reset();
                           
                           window.scrollTo(0,0);
                           document.getElementById("uploader-modal").classList.add("hidden");
   
                           $('.success').show();
                           $('.success').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+data.success+'</div>');  
                           
                           $('#file-list').html('');
                           
                           setInterval(function() {
                               location.reload();
                           }, 3000);	
                       }
                       else if(data.error){
                           $("#submit_edit_form").prop('disabled', false);
   
                           $('.error').show();
                           $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+data.error+'</div>');
                       }
                   },
                   error: function (err) {
                       $.each(err.responseJSON.errors, function(key, value) {
                               var el = $(document).find(`[name="${key=='reviewers' ? 'reviewers[]' : key}"]`);
                               el.after($('<div class= "err-msg text-red-500  px-2 py-1 text-sm font-semibold">' + value[0] + '</div>'));
                               if(el.length == 0){
                                   el = $(document).find('#file-upload');
                                   el.after($('<div class= "err-msg text-red-500  px-2 py-1 text-sm font-semibold">the documents must be pdf </div>'));
                                   
                               }
                               
                           });
   
                           $("#submit_edit_form").prop('disabled', false);
   
   
                   }
               });
       
         });
         
   
   
   </script>
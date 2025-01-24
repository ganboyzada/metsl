<!-- Uploader Modal -->
<div id="uploader-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white dark:bg-gray-800  shadow-lg max-w-3xl w-full p-6">
        <!-- Modal Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold dark:text-gray-200">Upload Documents</h2>
            <button data-modal="uploader-modal" class="modal-toggler text-gray-500 hover:text-gray-800 dark:hover:text-gray-300 transition">
                <i data-feather="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Upload Form -->
        <form id="reply-form"  method="POST" enctype="multipart/form-data">
			@csrf
			<input type="hidden" value="{{\Session::get('projectID')}}" name="project_id"/>
			<input type="hidden" value="{{ $punch_list->id }}" id="punchlistt_id" name="punch_list_id"/>

            
            

            <!-- Drag and Drop Zone -->
            <div>
                <label class="block mb-1">Attachment</label>
                <div id="drop-zone" class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed  dark:bg-gray-800 dark:border-gray-700 border-gray-300">
                    <div class="flex flex-col items-center justify-center">
                        <i data-feather="upload" class="w-10 h-10 text-gray-500"></i>
                        <p class="text-sm text-gray-500">Click to upload or drag and drop</p>
                        <p class="text-xs text-gray-500">PDF only (max. 5MB)</p>
                    </div>
                    <input id="file-upload"  name="docs" type="file" class="" accept="image/*">
                </div>
				<ul class="file-list" class="mt-4 space-y-2">
				</ul>
                <ul id="file-list" class="mt-4 space-y-2">
                    <!-- Uploaded files will appear here -->
                </ul>
            </div>

            <!-- Title -->
            <div class="mb-4">
                <div class="flex gap-2">  
       
                    <div>
                        <label for="title" class="block text-sm font-medium dark:text-gray-200 mb-1">Title *</label>
                        <input required
                            type="text"
                            id="title"
                            name="title"
                            class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200"
                            placeholder="Enter title"
                        />
                    </div>
                </div>
                
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description_reply" class="block text-sm mb-2 dark:text-gray-200">Description *</label>
                <textarea 
                    id="description_reply" name="description_reply" 
                    class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200"
                    rows="4"
                    placeholder="Enter description"
                ></textarea>
            </div>

            <!-- Submit Button -->
            <button
                type="submit" id="submit_upload_form"
                class="flex gap-x-2 bg-blue-500 text-white px-4 py-2  hover:bg-blue-600 transition"
            >   <i data-feather="upload"></i>
                Upload
            </button>
        </form>
    </div>
</div>
<script>
 
 $("#reply-form").on("submit", function(event) {
        const form = document.getElementById("reply-form");
        const formData = new FormData(form); 
        formData.append('description_reply',tinyMCE.get('description_reply').getContent());
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
                url:  "{{ route('projects.punch-list.store_reply') }}" ,
                type: "POST",
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: function() {
                    $("#submit_upload_form").prop('disabled', true);
                },
                success: function(data) {
                    if (data.success) {
                         
                        $("#submit_upload_form").prop('disabled', false);
                        
                        $("#reply-form")[0].reset();
						
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
                        $("#submit_upload_form").prop('disabled', false);

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

                        $("#submit_upload_form").prop('disabled', false);


                }
            });
    
      });
	  


</script>
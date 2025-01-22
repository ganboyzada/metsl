<!-- Uploader Modal -->
<div id="package-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white dark:bg-gray-800  shadow-lg max-w-3xl w-full p-6">
        <!-- Modal Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold dark:text-gray-200">Create a Document Package</h2>
            <button data-modal="package-modal" class="modal-toggler text-gray-500 hover:text-gray-800 dark:hover:text-gray-300 transition">
                <i data-feather="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Upload Form -->
        <form id="upload-form2"  method="POST" enctype="multipart/form-data">
			@csrf
			<input type="hidden" value="{{\Session::get('projectID')}}" name="project_id"/>

            <!-- Title -->
            <div class="mb-4">
                    <label for="name" class="block text-sm font-medium dark:text-gray-200 mb-1">Title</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        required
                        class="w-full px-3 py-2 border  dark:bg-gray-800 dark:text-gray-200"
                        placeholder="Enter title"
                    />
            </div>

            <!-- Reviewers -->
            <div class="mb-4">
                <label for="accessibles" class="block text-sm font-medium dark:text-gray-200 mb-1">Accessible by</label>
                <select required id="accessibles" name="accessibles[]" multiple class="w-full px-3 py-2 border  dark:bg-gray-800 dark:text-gray-200">
                </select>
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
 $("#upload-form2").on("submit", function(event) {
        const form = document.getElementById("upload-form2");
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
                url: "{{ route('projects.documents.package.store') }}" ,
                type: "POST",
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: function() {
                    $("#submit_upload_form2").prop('disabled', true);
                },
                success: function(data) {
                    if (data.success) {
                         
                        $("#submit_upload_form2").prop('disabled', false);
                        
                        $("#upload-form2")[0].reset();
						
						window.scrollTo(0,0);
						document.getElementById("package-modal").classList.add("hidden");

                        $('.success').show();
                        $('.success').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+data.success+'</div>');  
						

                        setInterval(function() {
							location.reload();
							}, 3000); 
						


                    }
                    else if(data.error){
                        $("#submit_upload_form2").prop('disabled', false);

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

                        $("#submit_upload_form2").prop('disabled', false);


                }
            });
    
      });
	  

</script>




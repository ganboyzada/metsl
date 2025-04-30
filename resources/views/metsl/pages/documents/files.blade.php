<!-- Uploader Modal -->
<div id="files-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white dark:bg-gray-800  shadow-lg max-w-3xl w-full p-6">
        <!-- Modal Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold dark:text-gray-200">Upload Documents</h2>
            <button data-modal="files-modal" class="modal-toggler text-gray-500 hover:text-gray-800 dark:hover:text-gray-300 transition">
                <i data-feather="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Upload Form -->
        <form id="upload-form2"  method="POST" enctype="multipart/form-data">
			@csrf
			<input type="hidden" value="{{\Session::get('projectID')}}" name="project_id"/>
			<input type="hidden" id="document_id" name="id"/>

            <!-- Drag and Drop Zone -->
            <div>
                <label class="block mb-1">Attachments (PDF only)</label>
                <div id="drop-zone-edit" class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed  dark:bg-gray-800 dark:border-gray-700 border-gray-300">
                    <div class="flex flex-col items-center justify-center">
                        <i data-feather="upload" class="w-10 h-10 text-gray-500"></i>
                        <p class="text-sm text-gray-500">Click to upload or drag and drop</p>
                        <p class="text-xs text-gray-500">PDF only (max. 5MB)</p>
                    </div>
                    <input id="file-upload-edit" name="docs[]" type="file" class="hidden" accept=".pdf" multiple>
                </div>
                <ul id="file-list-edit" class="file-list mt-4 space-y-2">
                    <!-- Uploaded files will appear here -->
                </ul>
            </div>

            <!-- Document Number -->
            <div class="mb-4">
                <label for="document-number-edit" class="block text-sm font-medium dark:text-gray-200 mb-1">Document Number</label>
                <div class="flex items-center gap-4">
                    <input
                        type="text"
						name="number"
                        id="document-number-edit"
                        class="w-full px-3 py-2 border  dark:bg-gray-800 dark:text-gray-200"
                        placeholder="Extracted from file name"
                        readonly
                    />
                    <label class="flex items-center text-sm font-medium dark:text-gray-200">
                        <input
                            type="checkbox"
                            id="custom-number-toggle-edit"
                            class="mr-2 h-4 w-4 text-blue-500 border-gray-300 rounded"
                        />
                        Custom Input
                    </label>
                </div>
            </div>

            <!-- Title -->
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium dark:text-gray-200 mb-1">Title</label>
                <input
                    type="text"
                    id="title_edit"
					name="title"
                    class="w-full px-3 py-2 border  dark:bg-gray-800 dark:text-gray-200"
                    placeholder="Enter title"
                />
            </div>

            <!-- Reviewers -->
            <div class="mb-4">
                <label for="reviewers" class="block text-sm font-medium dark:text-gray-200 mb-1">Reviewers</label>
                <select id="reviewers_selected" name="reviewers[]" multiple class="w-full px-3 py-2 border  dark:bg-gray-800 dark:text-gray-200">
                </select>
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
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
                url: "{{ route('projects.documents.update') }}",
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
                        
						
						window.scrollTo(0,0);
						document.getElementById("uploader-modal").classList.add("hidden");

                        $('.success').show();
                        $('.success').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+data.success+'</div>');  
						
                        $('#file-list').html('');
						
						get_documents();


                    }
                    else if(data.error){
                        $("#submit_upload_form2").prop('disabled', false);

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
                            if(el.length == 0){
                                el = $(document).find('#file-upload-edit');
								el.after($('<div class= "err-msg text-red-500  px-2 py-1 text-sm font-semibold">the documents must be pdf </div>'));
								
                            }
                            
                        });

                        $("#submit_upload_form2").prop('disabled', false);


                }
            });
    
      });
	  


	
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('files-modal');
    const fileInput = document.getElementById('file-upload-edit');
    const documentNumberInput = document.getElementById('document-number-edit');
    const customNumberToggle = document.getElementById('custom-number-toggle-edit');
    const uploadForm = document.getElementById('upload-form2');

    // const reviewers = [
        // { value: '1', label: 'John Doe (ACT Orders)' },
        // { value: '2', label: 'Jane Smith (ACT Developments)' },
        // { value: '3', label: 'Michael Brown (MB Architects)' },
        // { value: '4', label: 'Alice Johnson (ACT Orders)' },
    // ];

   // populateChoices('reviewers', reviewers, true);

    // Enable Custom Document Number Input
    customNumberToggle.addEventListener('change', (e) => {
        documentNumberInput.readOnly = !e.target.checked;
        if (!e.target.checked) {
            // Reset value if toggling back
            if (fileInput.files.length > 0) {
                const fileName = fileInput.files[0].name.split('.')[0];
                documentNumberInput.value = fileName;
            } else {
                documentNumberInput.value = '';
            }
        }
    });

    // Submit Form
    /*
    uploadForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(uploadForm);
        console.log('Uploading files...', formData.getAll('file'));
        alert('Files uploaded successfully!');
    });
    */
});

</script>
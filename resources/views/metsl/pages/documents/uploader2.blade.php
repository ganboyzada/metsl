<!-- Uploader Modal -->
<div id="uploader-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg max-w-3xl w-full p-6">
        <!-- Modal Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold dark:text-gray-200">Upload Documents</h2>
            <button data-modal="uploader-modal" class="modal-toggler text-gray-500 hover:text-gray-800 dark:hover:text-gray-300 transition">
                <i data-feather="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Upload Form -->
        <form id="upload-form"  method="POST" enctype="multipart/form-data">
			@csrf
			<input type="hidden" value="{{\Session::get('projectID')}}" name="project_id"/>
			<input type="hidden" value="0" id="document_id" name="id"/>

            
            

            <!-- Drag and Drop Zone -->
            <div>
                <label class="block mb-1">Attachments (PDF only)</label>
                <div id="drop-zone" class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed dark:border-gray-700 border-gray-300">
                    <div class="flex flex-col items-center justify-center">
                        <i data-feather="upload" class="w-10 h-10 text-gray-500"></i>
                        <p class="text-sm text-gray-500">Click to upload or drag and drop</p>
                        <p class="text-xs text-gray-500">PDF only (max. 5MB)</p>
                    </div>
                    <input id="file-upload" name="docs[]" type="file" class="hidden" accept=".pdf" multiple  onchange="loadFiles(event)">
                </div>
				<ul class="file-list" class="mt-4 space-y-2">
				</ul>
                <ul id="file-list" class="mt-4 space-y-2">
                    <!-- Uploaded files will appear here -->
                </ul>
            </div>

            <!-- Document Number -->
            <div class="mb-4">
                <label for="document-number" class="block text-sm font-medium dark:text-gray-200 mb-1">Document Number</label>
                <div class="flex items-center gap-4">
                    <input
                        type="text"
						name="number"
                        id="document-number"
                        class="w-full px-3 py-2 dark:bg-gray-800 dark:text-gray-200"
                        placeholder="Extracted from file name"
                        readonly
                    />
                    <label class="flex items-center text-sm font-medium dark:text-gray-200">
                        <input
                            type="checkbox"
                            id="custom-number-toggle"
                            class="mr-2 h-4 w-4 text-blue-500 border-gray-300"
                        />
                        Custom Input
                    </label>
                </div>
            </div>

            <!-- Title -->
            <div class="mb-4">
                <div class="flex gap-2">  
                 <div class="w-1/3">
                        <label for="package" class="block text-sm font-medium dark:text-gray-200 mb-1">Package</label>
                        <select name="package_id" id="package_id" onchange="getSubfolders(this.value)" class="w-full px-3 py-2 dark:bg-gray-800 dark:text-gray-200">
                            <option value="">select Package</option>
                            @if ($packages2->count() > 0)
                                @foreach ($packages2 as $row)
                                    <option value="{{$row->id}}" 
                                        {{ (isset($package_detail->id) && $package_detail->id == $row->id) || (isset($package_subfolder->id) && $package_subfolder->id == $row->id) ? 'selected' : '' }}
                                        >{{$row->name}}
                                    
                                    </option>    
                                @endforeach            
                            @endif
                        </select>
                    </div>
                    <div class="w-2/3">
                        <label for="subfolder_id" class="block text-sm font-medium dark:text-gray-200 mb-1">subfolder</label>
                        <select name="subfolder_id" id="subfolder_id" class="w-full px-3 py-2 dark:bg-gray-800 dark:text-gray-200">
                            <option value="">select Subfolder</option>
                            @if (isset($package_detail->subFolders) && $package_detail->subFolders->count() > 0)
                                @foreach ($package_detail->subFolders as $sub)
                                    <option value="{{$sub->id}}" 
                                        {{ (isset($package_subfolder->subFolders[0]) && $package_subfolder->subFolders[0]->id == $sub->id)?'selected':'' }}
                                        >{{$sub->name}}</option>    
                                @endforeach  
                                
                                
                            @endif
                        </select>
                    </div>


                
                </div>

                     <div class="mb-6">
                        <label for="title" class="block text-sm font-medium dark:text-gray-200 mb-1">Title</label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            class="w-full px-3 py-2 dark:bg-gray-800 dark:text-gray-200"
                            placeholder="Enter title"
                        />
                    </div>
                
            </div>

            <!-- Reviewers -->
            <div class="mb-6">
                <label for="reviewers" class="block text-sm font-medium dark:text-gray-200 mb-1">Reviewers</label>
                <select id="reviewers" name="reviewers[]" multiple class="w-full px-3 py-2 border  dark:bg-gray-800 dark:text-gray-200">
                </select>
            </div>
            @if(checkIfUserHasThisPermission(Session::get('projectID') ,'add_documents'))

            <!-- Submit Button -->
            <button
                type="submit" id="submit_upload_form"
                class="flex gap-x-2 bg-blue-500 text-white px-4 py-2  hover:bg-blue-600 transition"
            >   <i data-feather="upload"></i>
                Upload
            </button>
            @endif
        </form>
    </div>
</div>
<script>
    function loadFiles(event) {
        if (!$('input#custom-number-toggle').is(':checked')) {
            let name_number = '';
            if(event.target.files.length > 0){
                for(var i =0; i < event.target.files.length; i++){
                    let name= event.target.files[i].name;
                    name_number+= name.split('.')[0]+',';

                }
            }
            $('#document-number').val(name_number);
        }


    }
 let isSubmitting = false;
   
 $("#upload-form").on("submit", function(event) {
    event.preventDefault(); // أول شي عشان نوقف الإرسال التقليدي
    if (isSubmitting) {
        return; // إذا كان الطلب شغال، ارفض الطلب الجديد
    }
    isSubmitting = true;
    $("#submit_upload_form").prop('disabled', true);
        //alert('ok');
        const form = document.getElementById("upload-form");
        const formData = new FormData(form); 
		const document_id = $('#document_id').val();
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
                url: (document_id == 0)? "{{ route('projects.documents.store') }}" : "{{ route('projects.documents.update') }}" ,
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
                        sSubmitting = false;
                         
                        $("#submit_upload_form").prop('disabled', false);
                        
                        $("#upload-form")[0].reset();
						
						window.scrollTo(0,0);
						document.getElementById("uploader-modal").classList.add("hidden");

                        $('.success').show();
                        $('.success').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+data.success+'</div>');  
						
                        $('#file-list').html('');
						
						//get_documents();

                        setInterval(function() {
                            location.reload();
                        }, 3000);	


                    }
                    else if(data.error){
                        isSubmitting = false; 
                        $("#submit_upload_form").prop('disabled', false);

                        $('.error').show();
                        $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+data.error+'</div>');
                    }
                },
                error: function (err) {
                    isSubmitting = false; 
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

                        $("#submit_upload_form").prop('disabled', false);


                }
            });
    
      });
	  

    async function set_projectID_reviewers(){
        var projectId = $('#selected_project_id').val();
        var projectName = $('#selected_project_name').val();
        // let url = `/project/storeIdSession?projectID=${projectId}&projectName=${projectName}`;

        // let fetchRes = await fetch(url);
        get_reviewers();
    }

	// $(".projectButton").on('click',function(event) {
	// 	if(localStorage.getItem("project_tool") == 'documents'){
	// 		set_projectID_reviewers();
	// 	}
		
	// });
		

			
	//let doc_reviewers = [];


	
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('uploader-modal');
    const fileInput = document.getElementById('file-upload');
    const documentNumberInput = document.getElementById('document-number');
    const customNumberToggle = document.getElementById('custom-number-toggle');
    const uploadForm = document.getElementById('upload-form');

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
                //const fileName = fileInput.files[0].name.split('.')[0];
                let fileName = '';
                    for(var i =0; i < fileInput.files.length; i++){
                        let name= fileInput.files[i].name;
                        fileName+= name.split('.')[0]+',';

                    }                

                documentNumberInput.value = fileName;
            } else {
                documentNumberInput.value = '';
            }
        }else{
            documentNumberInput.value = '';
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
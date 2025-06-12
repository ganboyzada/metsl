<!-- Revisions Modal -->
<div id="reject-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white dark:bg-gray-800  shadow-lg max-w-3xl w-full p-6">
        <!-- Modal Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="reject-title" class="text-xl font-semibold dark:text-gray-200">
               Reject
            </h2>
            <button data-modal="reject-modal" class="modal-toggler text-gray-500 hover:text-gray-800 dark:hover:text-gray-300 transition">
                <i data-feather="x" class="w-5 h-5"></i>
            </button>
        </div>
		<div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold hidden success"></div>
		<div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>
        <!-- comments Table -->
        <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">

            

            	<thead>
	                <tr id="reject-box" class="reject-box">
				    <form id="rejectWizard" method="POST" enctype="multipart/form-data">
					@csrf
                    <td colspan="6" class="py-2 px-4 bg-gray-50 dark:bg-gray-700">
					<input type="hidden" name="revision_id" class="revision_id"/>
                    <input type="hidden" name="file_id" class="file_id"/>
                    <input type="hidden" name="file_type" class="file_type"/>
                    <input type="hidden" name="project_document_id" class="project_document_id"/>
                    <input type="hidden" name="number" class="number"/>
                    <input type="file" id="fileInput2" class=" w-full border  p-2 dark:bg-gray-800 dark:text-gray-200" name="image" accept="image/*"/>

                        <textarea name="comment" id="comment2" class="comment w-full border  p-2 dark:bg-gray-800 dark:text-gray-200" placeholder="Write your comment..."></textarea>
                        <button type="button"  class="submit_reject_form bg-red-500 text-white px-4 py-2 mt-2  hover:bg-red-600">
                            Reject
                        </button>
                       				
					</form>	
                    </td>
                </tr>		
			</thead>
		
        </table>
    </div>
</div>
<script>
        $(".submit_reject_form").off("click").on("click", function(event) {
          //  alert('ok');
            const form = document.getElementById("rejectWizard");
            const formData = new FormData(form); 
            formData.append('comment',tinyMCE.get('comment2').getContent());

                $('#error_div').hide();
                $('#success_div').hide();
                $('.err-msg').hide();
                //$("#error_div").html("");
                $("#success_div").html("");
                event.preventDefault();  
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('projects.documents.revision.reject_with_comments.store') }}",
                    type: "POST",
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    cache: false,
                    beforeSend: function() {
                        $(".submit_revision_form").prop('disabled', true);
                    },
                    success: function(data) {
                        if (data.success) {
                            
                            $(".submit_revision_form").prop('disabled', false);
                            
                           // $("#commentWizard")[0].reset();
                            tinyMCE.get('comment2').setContent('');
                            document.getElementById('fileInput2').value = '';
                            document.getElementById('reject-modal').classList.toggle('hidden');
                            
                            window.scrollTo(0,0);
                            $('#success_div').show();
                            $('#success_div').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+data.success+'</div>');
                           get_revisions($('.project_document_id').val() , $('.number').val());
                        }
                        else if(data.error){
                            $(".submit_revision_form").prop('disabled', false);

                            $('#error_div').show();
                            $('#error_div').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+data.error+'</div>');
                        }
                    },
                    error: function (err) {
                        $.each(err.responseJSON.errors, function(key, value) {
                            $('.error').show();
                            $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+value[0]+'</div>');
                                var el = $(document).find('[name="'+key + '"]');
                                if(el.length == 0){
                                    el = $(document).find('[id="'+key + '"]');
                                }
                                el.after($('<div class= "err-msg text-red-500  px-2 py-1 text-sm font-semibold">' + value[0] + '</div>'));
                                
                            });

                            $(".submit_revision_form").prop('disabled', false);


                    }
                });
        
        });
        
   
</script>
<!-- Trigger Script -->



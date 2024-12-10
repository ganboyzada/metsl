<!-- Revisions Modal -->
<div id="revisions-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white dark:bg-gray-800  shadow-lg max-w-3xl w-full p-6">
        <!-- Modal Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="revisions-title" class="text-xl font-semibold dark:text-gray-200">
                Revisions for DD/BCC/LV2/ELC/053/R2
            </h2>
            <button data-modal="revisions-modal" class="modal-toggler text-gray-500 hover:text-gray-800 dark:hover:text-gray-300 transition">
                <i data-feather="x" class="w-5 h-5"></i>
            </button>
        </div>
		<div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold hidden success"></div>
		<div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>
        <!-- Revisions Table -->
        <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
            <thead>
                <tr class="border-b dark:border-gray-700">
                    <th class="py-2 px-4">#</th>
                    <th class="py-2 px-4">Title</th>
                    <th class="py-2 px-4">Uploaded By</th>
                    <th class="py-2 px-4">Upload Date</th>
                    <th class="py-2 px-4">Status</th>
                    <th class="py-2 px-4">Actions</th>
                </tr>
            </thead>
            <tbody id="revisions-list">
                <!-- Example Row -->

                <!-- Comment Box -->

            </tbody>
			<thead>
	                <tr id="comment-box" class="comment-box hidden">
				    <form id="commentWizard" method="POST" enctype="multipart/form-data">
					@csrf
                    <td colspan="6" class="py-2 px-4 bg-gray-50 dark:bg-gray-700">
					<input type="hidden" name="revision_id" id="revision_id"/>
                        <textarea name="comment" id="comment" class="comment w-full border  p-2 dark:bg-gray-800 dark:text-gray-200" placeholder="Write your comment..."></textarea>
                        <button type="submit"  class="submit_revision_form bg-blue-500 text-white px-4 py-2 mt-2  hover:bg-blue-600">
                            Send
                        </button>
                        <button type="button" onclick="get_comments()"  data-modal="comments-modal" class="modal-toggler bg-blue-500 text-white px-4 py-2  hover:bg-blue-600 transition duration-200">
                            View Comments
                        </button>					
					</form>	
                    </td>
                </tr>		
			</thead>
        </table>
    </div>
</div>

<!-- Trigger Script -->
<script>
    $("#commentWizard").on("submit", function(event) {
            const form = document.getElementById("commentWizard");
            const formData = new FormData(form); 
            formData.append('comment',tinyMCE.get('comment').getContent());

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
                    url: "{{ route('projects.documents.revision.comments.store') }}",
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
                            
                            $("#commentWizard")[0].reset();
                            document.getElementById('comment-box').classList.toggle('hidden');
                            
                            window.scrollTo(0,0);
                            $('.success').show();
                            $('.success').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+data.success+'</div>');
                        }
                        else if(data.error){
                            $(".submit_revision_form").prop('disabled', false);

                            $('.error').show();
                            $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+data.error+'</div>');
                        }
                    },
                    error: function (err) {
                        $.each(err.responseJSON.errors, function(key, value) {
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
        
    async function get_comments(){
        let revision_id = $('#revision_id').val();
        $('#comments-list').html('');
		$('.error').hide();
		$('.success').hide();
		$(".error").html("");
		$(".success").html("");
        let url = 	`{{url('project/documents/revisions/comments/${revision_id}')}}`	;
        let fetchRes = await fetch(url);
        let comments = await fetchRes.json();
        console.log(comments);
            let html = ``;
            if(comments.comments.length > 0){
                for(let i=0; i<comments.comments.length; i++){
                    html+=`<tr class="group hover:bg-gray-100 dark:hover:bg-gray-700">
                        <td class="py-2 px-4">${i + 1}</td>
                        <td class="py-2 px-4">${ comments.comments[i].comment}</td>
                        <td class="py-2 px-4">${ comments.comments[i].user.name}</td>
                    
                    </tr>`;
                }
            }
            $('#comments-list').html(html);
        }

    function show_comment(id){
        // if($('#revision_id').val() == id && !document.getElementById('comment-box').classList.contains('hidden')){

            // document.getElementById('comment-box').classList.add('hidden');
        // }else{
            // $('#revision_id').val(id);
            // document.getElementById('comment-box').classList.remove('hidden');
        // }
        $('#revision_id').val(id);
        document.getElementById('comment-box').classList.toggle('hidden');
        
    }
    const commentButtons = document.querySelectorAll('.comment-button');
    const commentBoxes = document.getElementsByClassName('.comment-box');

    // Handle comment button click
    commentButtons.forEach((button, index) => {
        button.addEventListener('click', () => {
            document.getElementById('comment-box').classList.toggle('hidden');
        });
    });
</script>


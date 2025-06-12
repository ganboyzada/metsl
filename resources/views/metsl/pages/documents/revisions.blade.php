<!-- Revisions Modal -->
<div id="revisions-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 max-h-[90vh] overflow-y-scroll  p-6 max-w-7xl">
        <!-- Modal Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="revisions-title" class="text-xl font-semibold dark:text-gray-200">
                Revisions for DD/BCC/LV2/ELC/053/R2
            </h2>
            <button data-modal="revisions-modal" class="modal-toggler text-gray-500 hover:text-gray-800 dark:hover:text-gray-300 transition">
                <i data-feather="x" class="w-5 h-5"></i>
            </button>
        </div>
		<div id="success_div" class="bg-green-500 text-white px-2 py-1 text-sm font-semibold hidden"></div>
		<div id="error_div" class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden">
			<div class= "px-2 py-1 text-sm font-semibold">error occurred</div>
		</div>
        <!-- Revisions Table -->
        <table class="w-full border text-sm text-left text-gray-600 dark:text-gray-300">
            <thead>
                <tr class="bg-gray-200 dark:bg-gray-800 dark:border-gray-700 font-light">
                    <th class="py-2 px-4">#</th>
                    <th class="py-2 px-4">Preview Image</th>
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

        </table>
    </div>
</div>

<!-- Trigger Script -->
<script>
	async function update_status(id , status , number , project_doc_id){
        if(status == 2){
            $('.revision_id').val(id);
            $('.file_id').val(null);
            $('.file_type').val('revision');
            $('.project_document_id').val(project_doc_id);
            $('.number').val(number);
            document.getElementById("reject-modal").classList.remove("hidden");
        }else{
            let url = 	`{{url('project/documents/revisions/update_status?id=${id}&status=${status}')}}`	;
            let newurl = url.replace('amp;','');
            let fetchRes = await fetch(newurl);
            if(fetchRes.status != 200){
                $('#error_div').show();
                //$('#error_div').css('display','block !important');
                    
                
            }
            if (localStorage.getItem("project_tool") == 'activities') {
                get_documents();
            }
            get_revisions(current_document_id , number);
        }

	}
    async function update_doc_status(project_doc_id , status , number , file_id){
        if(status == 2){
            $('.revision_id').val(null);
            $('.file_id').val(file_id);
            $('.file_type').val('file');
            $('.project_document_id').val(project_doc_id);
            $('.number').val(number);
            document.getElementById("reject-modal").classList.remove("hidden");
        }else{
            let url = 	`{{url('project/documents/files/update_status?id=${id}&status=${status}')}}`	;
            let newurl = url.replace('amp;','');
            let fetchRes = await fetch(newurl);
            if(fetchRes.status != 200){
                $('#error_div').show();
                //$('#error_div').css('display','block !important');
                    
                
            }
            if (localStorage.getItem("project_tool") == 'activities') {
                get_documents();
            }
            get_revisions(current_document_id , number);
        }
	}

 async function get_comments(){
        let revision_id = $('#revision_id').val();
        let file_id = $('#file_id').val();
        let file_type = $('#file_type').val();
        $('#comments-list').html('');
		$('.error').hide();
		$('.success').hide();
		$(".error").html("");
		$(".success").html("");
        if(file_type == 'revision'){
            let url=`{{url('project/documents/revisions/comments/${revision_id}/revision')}}`	;
            let fetchRes = await fetch(url);
            let comments = await fetchRes.json();
                            let html = ``;
                if(comments.comments.length > 0){
                    for(let i=0; i<comments.comments.length; i++){
                        html+=`<tr class="group hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="py-2 px-4">${i + 1}`;
                                if(comments.comments[i].type == 'reject'){
                                     html+=`<span class=" mx-2 text-xs font-semibold bg-red-500 text-white rounded-full px-2 py-1">
                                        reject Comment
                                        </span>`;

                                }
                                html+=`</td>
                            <td class="py-2 px-4">${ comments.comments[i].comment}</td>
                            <td class="py-2 px-4">`;

                            if(comments.comments[i].image != null){
							   html+=`<a target="_blank" href="${ comments.comments[i].image }" class="text-blue-500 hover:text-blue-700">
								<i data-feather="download" stroke-width="2" class="w-5 h-5"></i>
							</a>`;
					   
						}
                                
                                
                            html+=`</td>
                            <td class="py-2 px-4">${ comments.comments[i].user.name}</td>
                        
                        </tr>`;
                    }
                }
                $('#comments-list').html(html);
                feather.replace();	
        }else{
            let url=`{{url('project/documents/revisions/comments/${file_id}/file')}}`	;
            let fetchRes = await fetch(url);
            let comments = await fetchRes.json();
                            let html = ``;
                if(comments.comments.length > 0){
                    for(let i=0; i<comments.comments.length; i++){
                        html+=`<tr class="group hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="py-2 px-4">${i + 1}`;
                                if(comments.comments[i].type == 'reject'){
                                     html+=`<span class=" mx-2 text-xs font-semibold bg-red-500 text-white rounded-full px-2 py-1">
                                        reject Comment
                                        </span>`;

                                }
                                html+=`</td>
                            <td class="py-2 px-4">${ comments.comments[i].comment}</td>
                              <td class="py-2 px-4">`;

                            if(comments.comments[i].image != null){
							   html+=`<a target="_blank" href="${ comments.comments[i].image }" class="text-blue-500 hover:text-blue-700">
								<i data-feather="download" stroke-width="2" class="w-5 h-5"></i>
							</a>`;
					   
						}
                                
                                
                            html+=`</td>
                            <td class="py-2 px-4">${ comments.comments[i].user.name}</td>
                        
                        </tr>`;
                    }
                }
                $('#comments-list').html(html);
                feather.replace();	
        }
        

        //console.log(comments);

        }

    function show_comment(id , type="revision" , project_doc_id){
        // if($('#revision_id').val() == id && !document.getElementById('comment-box').classList.contains('hidden')){

            // document.getElementById('comment-box').classList.add('hidden');
        // }else{
            // $('#revision_id').val(id);
            // document.getElementById('comment-box').classList.remove('hidden');
        // }
        if(type =="revision"){
            $('#revision_id').val(id);
            $('#file_id').val(null);
            $('#file_type').val(type);
            $('#project_document_id').val(project_doc_id);
        }else{
            $('#revision_id').val(null);
            $('#file_id').val(id);
            $('#file_type').val(type);
             $('#project_document_id').val(project_doc_id);
        }
        
        get_comments();
        // $('#comments-modal').modal('show');
         document.getElementById("comments-modal").classList.remove("hidden");
        //document.getElementById('comment-box').classList.toggle('hidden');
        
    }
    var commentButtons = document.querySelectorAll('.comment-button');
    var  commentBoxes = document.getElementsByClassName('.comment-box');

    // Handle comment button click
    commentButtons.forEach((button, index) => {
        button.addEventListener('click', () => {
            document.getElementById('comment-box').classList.toggle('hidden');
        });
    });
</script>


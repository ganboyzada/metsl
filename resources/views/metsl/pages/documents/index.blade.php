<!-- Top Toolbar -->
<div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold hidden success"></div>
<div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>
<div class="flex flex-wrap items-center justify-between mb-6">
    <!-- Add Document Button -->
    <button data-modal="uploader-modal" class="modal-toggler bg-blue-500 text-white px-4 py-2  hover:bg-blue-600 flex items-center transition duration-200">
        <i data-feather="plus-circle" stroke-width="2" class="w-5 h-5 mr-2"></i> Add Document
    </button>

    <!-- Order By and Filter -->
    <div class="flex items-center gap-4">
        <div class="flex items-center">
            <label for="order-by" class="text-sm font-medium dark:text-gray-400 mr-2">Order by:</label>
            <select id="order-by" class="px-3 py-2 border  dark:bg-gray-800 dark:text-gray-200">
                <option value="number">Name</option>
                <option value="created_date">Initial Upload Date</option>
                <option value="size">Size</option>
                <option value="upload_date">Last Revision Date</option>
            </select>
            <select id="order-direction" class="ml-2 px-3 py-2 border  dark:bg-gray-800 dark:text-gray-200">
                <option value="desc">Descending</option>
                <option value="asc">Ascending</option>
            </select>
        </div>

        <!-- Filter By You -->
        <div class="flex items-center">
            <label for="filter-by" class="text-sm font-medium dark:text-gray-400 mr-2">Filter:</label>
            <select id="filter-by" class="px-3 py-2 border  dark:bg-gray-800 dark:text-gray-200">
                <option>All</option>
                <option>By You</option>
            </select>
        </div>
    </div>
</div>

<!-- File Manager Grid -->
<div id="documents_list" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">


</div>
@include('metsl.pages.documents.revisions')
@include('metsl.pages.documents.uploader')
@include('metsl.pages.documents.comments')

<script>



	
	$(".projectButton").on('click',function(event) {
		if(localStorage.getItem("project_tool") == 'documents'){

			get_documents();
		}
	});
	$("#order-by , #order-direction").on('change',function(event) {
		loadedRows = 0;
		if(localStorage.getItem("project_tool") == 'documents'){

			get_documents();
		}
	});	
	

	
	async function get_revisions(id){
		current_document_id = id;
		$('.error').hide();
		$('.success').hide();
		$(".error").html("");
		$(".success").html("");
	
		//$('#error_div').hide();
		$('#success_div').hide();
		//$("#error_div").html("");
		$("#success_div").html("");
		let url = 	`{{url('project/documents/revisions/${id}')}}`	;
		let fetchRes = await fetch(url);
		let revisions = await fetchRes.json();
		let html = ``;
		if(revisions.length > 0){
			for(let i=0; i<revisions.length; i++){
				html+=`<tr class="group hover:bg-gray-100 dark:hover:bg-gray-700">
                    <td class="py-2 px-4">${i + 1}</td>
                    <td class="py-2 px-4">${ revisions[i].title}</td>
                    <td class="py-2 px-4">${ revisions[i].user.name}</td>
                    <td class="py-2 px-4">${ revisions[i].upload_date}</td>
                    <td class="py-2 px-4">${ revisions[i].status_text}</td>
                    <td class="py-2 px-4 flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <a target="_blank" href="${ revisions[i].file }" class="text-blue-500 hover:text-blue-700">
                            <i data-feather="download" stroke-width="2" class="w-5 h-5"></i>
                        </a>
                        <button class="text-yellow-500 hover:text-yellow-700 comment-button" onclick="show_comment(${revisions[i].id})">
                            <i data-feather="message-circle" stroke-width="2" class="w-5 h-5"></i>
                        </button>`;
						if(revisions[i].status ==0 || revisions[i].status == 2){
							html+=`<button onclick="update_status(${revisions[i].id} , 1)" class="text-green-500 hover:text-green-700">
								<i data-feather="check" stroke-width="2" class="w-5 h-5"></i>
							</button>`;
							
						}
						if(revisions[i].status ==0 || revisions[i].status == 1){
						
							html+=`<button  onclick="update_status(${revisions[i].id} , 2)" class="text-red-500 hover:text-red-700">
								<i data-feather="x-circle" stroke-width="2" class="w-5 h-5"></i>
							</button>`;
						}	
                
                    html+=`</td>
                </tr>`;

			}
		}			
		
		$('#revisions-list').html(html);
		feather.replace();

		
	}
	let all_documents = {};
	let current_document_id = 0;
	async function get_documents(){
		$('#revisions-list').html('');
		const orderBy = $('#order-by').val();
		const orderDirection = $('#order-direction').val();
		let url = 	`{{url('project/documents/all?orderBy=${orderBy}&orderDirection=${orderDirection}')}}`	;
		let newurl = url.replace('amp;','');
		let fetchRes = await fetch(newurl);
		all_documents = await fetchRes.json();
		let html = ``;
		if(all_documents.length > 0){
			for(let i=0; i<all_documents.length; i++){
				html+=`<div class="relative p-4 bg-gray-100 dark:bg-gray-800  shadow-md group transition transform hover:scale-105">
					<h3 class="text-sm font-medium dark:text-gray-400 mb-2 truncate">${all_documents[i].title}</h3>
					<span class="absolute top-4 right-4 text-xs font-semibold text-blue-500 dark:text-blue-300">
						${all_documents[i].created_date}
					</span>
					<div class="flex justify-center items-center mb-4">
						<i data-feather="file-text" class="w-12 h-12 dark:text-gray-200"></i>
					</div>
					<span class="absolute bottom-2 right-2 flex items-center text-xs font-semibold bg-blue-900 text-white rounded-full px-2 py-1">
						<i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i>${all_documents[i].revisions_count}
					</span>
					<button onclick="get_revisions(${all_documents[i].id})" data-modal="revisions-modal"
						class="absolute modal-toggler bottom-2 left-2 bg-blue-500 text-white px-3 py-1 text-xs  hidden group-hover:block transition duration-200"
						aria-label="View Revisions"
					>
						View Revisions
					</button>
				</div>`;
			}
		}
		$('#documents_list').html(html);
		feather.replace();
	}
	
</script>
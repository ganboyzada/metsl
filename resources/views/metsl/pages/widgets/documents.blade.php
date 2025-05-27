<div class="widget" id="widget-docs">
    <h2 class="bg-yellow-500 text-md inline-flex uppercase text-white font-semibold px-4 py-2 rounded-t-lg w-fit">
        <i data-feather="file" class="me-2 text-yellow-700"></i>Documents
    </h2>
    <div class="overflow-x-auto border border-blue-500 rounded-tl-none rounded-xl">
        <table class="rounded-tl-none min-w-full">
            <thead class="bg-blue-200 dark:bg-blue-500/25 text-sm text-left">
                <tr>
                    <th class="px-4 py-2 font-light">Number</th>
                    <th class="px-4 py-2 font-light">Created Date</th>
                    <th class="px-4 py-2 font-light">revision Count</th>
                    <th class="px-4 py-2 font-light">status</th>
                </tr>
            </thead>
            <tbody id="widget-docs-table">
                <!-- Rows will be dynamically loaded -->
            </tbody>
        </table>
        <div id="pagination_docs_widget" class="flex gap-2 mt-4"></div>
    </div>
</div>

<script>

function loadWidgetDocs() {
				console.log(DocsData);

        
        let html =``;
        if(DocsData.length > 0){
            for(let i=0;i<DocsData.length;i++){
                if(DocsData[i].has_pending_revision > 0){
                    var status = `<span class=" flex items-center text-xs font-semibold bg-yellow-900 text-white rounded-full px-2 py-1">
                        revision Pending
                            </span>
                        `;
                }else{
                    var status = ``;
                }
                html+=`<tr class="border-b dark:border-gray-800">
                        <td class="px-4 py-2">${DocsData[i].title == null ? DocsData[i].number : DocsData[i].title}</td>
                        <td class="px-4 py-2">${DocsData[i].created_date}</td>
                        <td class="px-4 py-2">
                            <button onclick="get_revisions(${DocsData[i].id} , '${DocsData[i].number}')" data-modal="revisions-modal"
								class=" modal-toggler rounded-full bottom-2 left-2 bg-blue-500 text-white px-3 py-1 text-xs  block  group-hover:block transition duration-200"
								aria-label="View Revisions"
							>
								<i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i>${DocsData[i].revisions_count} Revisions
							</button>

                            
                        </td>
                        <td class="">${status}</td>              
                        </tr>`;
            }
            
        }
        $('#widget-docs-table').html(html);
        feather.replace();




}

async function get_revisions2(id , number){
		$('#revisions-title').html('Revisions for '+number);
		current_document_id = id;
		$('.error').hide();
		$('.success').hide();
		$(".error").html("");
		$(".success").html("");
	
		//$('#error_div').hide();
		$('#success_div').hide();
		//$("#error_div").html("");
		$("#success_div").html("");
		let html = ``;
		let url = 	`{{url('project/documents/edit/${id}')}}`	;
		let fetchRes = await fetch(url);
		let detail = await fetchRes.json();
		let url2 = 	`{{url('/project/documents/revisions/${id}')}}`	;
		let fetchRes2 = await fetch(url2);
		let revisions = await fetchRes2.json();
		if(detail.files.length > 0){
			html+=``;
			for(var i=0;i<detail.files.length;i++){
				var file_url = 	`{{asset('storage/project${detail.project_id}/documents${detail.id}/${detail.files[i].file}')}}`;	
			
				html+=`<tr class="group hover:bg-gray-100 dark:hover:bg-gray-700" ${i==0 ? 'style="background-color: #ffd70026;"' : ''}>
                    <td class="py-2 px-4">${i + 1}</td>
                    <td class="py-2 px-4">${ detail.title == null ? '-' : detail.title}</td>
                    <td class="py-2 px-4">${ detail.user.name}</td>
                    <td class="py-2 px-4">${ detail.created_date}</td>
					
                    <td class="py-2 px-4">`;
						if(detail.status == 0){
							html+=`Pending`;
						}else if(detail.status == 1){
							html+=`Accepted`;
						}else{
							html+=`Rejected`;
							
						}
						
				
				html+=`</td>
                    <td class="py-2 px-4 flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                       `;
						
						if($('#accept_reject_document').val() == 1){
							if(detail.status ==0 || detail.status == 2){
								html+=`<button onclick="update_doc_status(${detail.id} , 1)" class="text-green-500 hover:text-green-700">
									<i data-feather="check" stroke-width="2" class="w-5 h-5"></i>
								</button>`;
								
							}
							if(detail.status ==0 || detail.status == 1){
							
							html+=`<button  onclick="update_doc_status(${detail.id} , 2)" class="text-red-500 hover:text-red-700">
								<i data-feather="x-circle" stroke-width="2" class="w-5 h-5"></i>
							</button>`;
							}
						}

							   html+=`<a target="_blank" href="${ file_url }" class="text-blue-500 hover:text-blue-700">
								<i data-feather="download" stroke-width="2" class="w-5 h-5"></i>
							</a>`;
					   
						
                   
                
                    html+=`</td>
                </tr>`;

	
			}
			
		}		

		if(revisions.length > 0){
			var z = i+1;
			for(let i=0; i<revisions.length; i++){
				
				html+=`<tr class="group hover:bg-gray-100 dark:hover:bg-gray-700">

                    <td class="py-2 px-4">${z++}</td>
                    <td class="py-2 px-4">${ revisions[i].title}</td>
                    <td class="py-2 px-4">${ revisions[i].user.name}</td>
                    <td class="py-2 px-4">${ revisions[i].upload_date}</td>
                    <td class="py-2 px-4">${ revisions[i].status_text}</td>
                    <td class="py-2 px-4 flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                       `;
						if(revisions[i].file != null){
							   html+=`<a target="_blank" href="${ revisions[i].file }" class="text-blue-500 hover:text-blue-700">
								<i data-feather="download" stroke-width="2" class="w-5 h-5"></i>
							</a>`;
					   
						}
						if($('#comments_permission').val() == 1){
							html+=`<button class="text-yellow-500 hover:text-yellow-700 comment-button" onclick="show_comment(${revisions[i].id})">
								<i data-feather="message-circle" stroke-width="2" class="w-5 h-5"></i>
							</button>`;
						}

						if($('#accept_reject_document').val() == 1){
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
						}
							
                
                    html+=`</td>
                </tr>`;
			}
		}			
		
		$('#revisions-list').html(html);
		feather.replace();
		
	}
function renderPaginationDocsWidget(data) {
    let html = '';
    if (data.last_page > 1) {
        for (let i = 1; i <= data.last_page; i++) {
            html += `<button onclick="get_documents(${i})" class="px-2 py-1 border ${data.current_page === i ? 'bg-blue-500 text-white' : 'bg-white'}">
                        ${i}
                    </button>`;
        }
    }
    $('#pagination_docs_widget').html(html);
}

</script>
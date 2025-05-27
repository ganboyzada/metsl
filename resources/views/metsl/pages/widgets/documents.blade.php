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
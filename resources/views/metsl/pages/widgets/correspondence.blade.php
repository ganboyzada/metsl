<div class="widget" id="widget-correspondence">
    <h2 class="bg-blue-500 text-md inline-flex uppercase text-white font-semibold px-4 py-2 rounded-t-lg w-fit">
        <i data-feather="repeat" class="me-2 text-blue-700"></i>Correspondence
    </h2>
    <div class="overflow-x-auto border border-blue-500 rounded-tl-none rounded-xl">
        <table class="rounded-tl-none min-w-full">
            <thead class="bg-blue-200 dark:bg-blue-500/25 text-sm text-left">
                <tr>
                    <th class="px-2 py-2 lg:px-4 lg:py-2 font-light">Number</th>
                    <th class="px-2 py-2 lg:px-4 lg:py-2 font-light">Subject</th>
                    <th class="px-2 py-2 lg:px-4 lg:py-2 font-light">Created by</th>
                    <th class="px-2 py-2 lg:px-4 lg:py-2 font-light">Created at</th>
                    <th class="px-2 py-2 lg:px-4 lg:py-2 font-light">Status</th>
                </tr>
            </thead>
            <tbody id="widget-correspondence-table">
                <!-- Rows will be dynamically loaded -->
            </tbody>
        </table>
        <div id="pagination_correspondence_widget" class="flex gap-2 mt-4"></div>
    </div>
</div>

<script>

function loadWidgetCorrespondence() {
    let html =``;
		if(correspondenceData.length > 0){ 
   
			for(let i=0;i<correspondenceData.length;i++){
                const row = correspondenceData[i];
              
                let url = "{{ route('projects.correspondence.view', [':id']) }}".replace(':id', row.id);
                let url2 = "{{ route('projects.correspondence.edit', [':id']) }}".replace(':id', row.id);

                html+=`<tr>
                    <td class="px-6 py-3">${row.number}
					${row.label}
					</td>
                    <td class="px-6 py-3"><a class="underline" href="${url}">${row.subject}</a></td>

                    <td class="px-6 py-3">${(row.created_by != null) ? row.created_by.name : ''}</td>
                    <td class="px-6 py-3">${row.created_date}</td>
                    <td class="px-6 py-3">
                        <span class="px-3 py-1 rounded-full text-xs font-bold ${row.status_color[1]}">${row.status_color[0]}</span>
                    </td></tr>
                `;

			}
		}
        $('#widget-correspondence-table').html(html);

}


function renderPaginationCorrespondenceWidget(data) {
    let html = '';
    if (data.last_page > 1) {
        for (let i = 1; i <= data.last_page; i++) {
            html += `<button onclick="get_correspondences(${i})" class="px-2 py-1 border ${data.current_page === i ? 'bg-blue-500 text-white' : 'bg-white'}">
                        ${i}
                    </button>`;
        }
    }
    $('#pagination_correspondence_widget').html(html);
}

</script>
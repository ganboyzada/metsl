<div class="widget" id="widget-correspondence">
    <h2 class="bg-orange-500 text-md inline-flex uppercase text-white font-semibold px-4 py-2 rounded-t-lg w-fit">
        <i data-feather="list" class="mr-2 text-orange-700"></i>Punch List
    </h2>
    <div class="overflow-x-auto border border-orange-500 rounded-tl-none rounded-xl">
        <table class="rounded-tl-none min-w-full">
            <thead class="bg-orange-200 dark:bg-orange-500/25 text-sm text-left">
                <tr>
                    <th class="px-2 py-2 lg:px-4 lg:py-2 font-light">Issue</th>
                    <th class="px-2 py-2 lg:px-4 lg:py-2 font-light">Created by</th>
                    <th class="px-2 py-2 lg:px-4 lg:py-2 font-light">Due Date</th>
                    <th class="px-2 py-2 lg:px-4 lg:py-2 font-light">Priority</th>
                    <th class="px-2 py-2 lg:px-4 lg:py-2 font-light">Status</th>
                </tr>
            </thead>
            <tbody id="widget-punch-table">
                <!-- Rows will be dynamically loaded -->
            </tbody>
        </table>
        <div id="pagination_punch_widget" class="flex gap-2 mt-4"></div>
    </div>
</div>

<script>
    function loadPunchListWidget(list){
        //console.log(list);
        let html =``;
        if(list.length > 0){
            for(let i=0;i<list.length;i++){
                let url = "{{ route('projects.punch-list.edit', [':id']) }}".replace(':id', list[i].id);
                html+=`<tr class="border-b dark:border-gray-800">
                        
                        <td class="px-4 py-2"><a class="underline" href="${url}">${list[i].title}</a>
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-orange-500 text-white">${list[i].label}</span>
                            
                            </td>
                        <td class="px-4 py-2">${list[i].created_by_user.name}</td>
                        <td class="px-4 py-2">${list[i].due_date ?? '-'}</td>
                        <td class="px-4 py-2">${list[i].priority_text}</td>
                        <td class="px-4 py-2">${list[i].status_text}</td>
                    </tr>`;
            }	
        }
        $('#widget-punch-table').html(html);

        
    }

    function renderPaginationPunch(data) {
    let html = '';
    if (data.last_page > 1) {
        for (let i = 1; i <= data.last_page; i++) {
            html += `<button onclick="get_punch_list(${i})" class="px-2 py-1 border ${data.current_page === i ? 'bg-blue-500 text-white' : 'bg-white'}">
                        ${i}
                    </button>`;
        }
    }
    $('#pagination_punch_widget').html(html);
}
</script>
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
    </div>
</div>

<script>
    function loadPunchListWidget(list){
        console.log(list);
        let html =``;
        if(list.length > 0){
            for(let i=0;i<list.length;i++){
                let url = "{{ route('projects.punch-list.edit', [':id']) }}".replace(':id', list[i].id);
                html+=`<tr class="border-b dark:border-gray-800">
                        
                        <td class="px-4 py-2"><a class="underline" href="${url}">${list[i].title}</a></td>
                        <td class="px-4 py-2">${list[i].created_by_user.name}</td>
                        <td class="px-4 py-2">${list[i].due_date ?? '-'}</td>
                        <td class="px-4 py-2">${list[i].priority_text}</td>
                        <td class="px-4 py-2">${list[i].status_text}</td>
                    </tr>`;
            }	
        }
        $('#widget-punch-table').html(html);
    }
</script>
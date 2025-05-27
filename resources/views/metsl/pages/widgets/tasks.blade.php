<div class="widget" id="widget-tasks">
    <h2 class="bg-green-500 text-md inline-flex uppercase text-white font-semibold px-4 py-2 rounded-t-lg w-fit">
        <i data-feather="list" class="me-2 text-green-700"></i>Tasks
    </h2>
    <div class="overflow-x-auto border border-blue-500 rounded-tl-none rounded-xl">
        <table class="rounded-tl-none min-w-full">
            <thead class="bg-blue-200 dark:bg-blue-500/25 text-sm text-left">
                <tr>
                    <th class="px-4 py-2 font-light">title</th>
                    <th class="px-4 py-2 font-light">start date</th>
                    <th class="px-4 py-2 font-light">duration Date</th>                   
                    <th class="px-4 py-2 font-light">priortity</th>
                    <th class="px-4 py-2 font-light">File</th>
                    <th class="px-4 py-2 font-light">description</th>
                </tr>
            </thead>
            <tbody id="widget-tasks-table">
                <!-- Rows will be dynamically loaded -->
            </tbody>
        </table>
        <div id="pagination_tasks_widget" class="flex gap-2 mt-4"></div>
    </div>
</div>

<script>
    loadWidgetTasks();
    async function loadWidgetTasks(page = 1) {

        let url = `project/tasks/all_assigned?page=${page}`;

        let fetchRes = await fetch(url);
        const response = await fetchRes.json(); // full paginated response
        console.log(response);
       var  tasksData = response.data;
        console.log( response.data);

      
        
        let html =``;
        if(tasksData.length > 0){
            for(let i=0;i<tasksData.length;i++){
                //console.log(mettingsData[i].users);
                html+=`<tr class="border-b dark:border-gray-800">
                       
                        <td class="px-4 py-2">${tasksData[i].subject}</td>
                        <td class="px-4 py-2">${tasksData[i].start_date}
                        </td>
                        <td class="px-4 py-2">${tasksData[i].duration}</td>
                        <td class="px-4 py-2">${tasksData[i].priority}</td>
                         <td class="px-4 py-2">`;
                           if(tasksData[i].file_name != null){
                            html+=`<a  class="underline" target="_blank" href="${tasksData[i].file_url}">${tasksData[i].file_name}</a>`;

                           } 


                            
                            
                            html+=`</td>
                        <td class="px-4 py-2">${tasksData[i].description}</td>
                
                        </tr>`;
            }
            
        }
        $('#widget-tasks-table').html(html);
        feather.replace();
        renderPaginationTasksWidget(response);




}


function renderPaginationTasksWidget(data) {
    let html = '';
    if (data.last_page > 1) {
        for (let i = 1; i <= data.last_page; i++) {
          //  alert(data.last_page);
            html += `<button onclick="loadWidgetTasks(${i})" class="px-2 py-1 border ${data.current_page === i ? 'bg-blue-500 text-white' : 'bg-white'}">
                        ${i}
                    </button>`;
        }
    }
    $('#pagination_tasks_widget').html(html);
}

</script>
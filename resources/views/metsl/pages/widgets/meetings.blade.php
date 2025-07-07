<div class="widget" id="widget-meetings">
    <h2 class="bg-red-500 text-md inline-flex uppercase text-white font-semibold px-4 py-2 rounded-t-lg w-fit">
        <i data-feather="list" class="me-2 text-red-700"></i>Meetings Published
    </h2>
    <div class="overflow-x-auto border border-blue-500 rounded-tl-none rounded-xl">
        <table class="rounded-tl-none min-w-full">
            <thead class="bg-blue-200 dark:bg-blue-500/25 text-sm text-left">
                <tr>
                    <th class="px-4 py-2 font-light">Meeting Type</th>
                    <th class="px-4 py-2 font-light">Planned Date</th>
                    <th class="px-4 py-2 font-light">Planned Start</th>
                    <th class="px-4 py-2 font-light">notes</th>
                    <th class="px-4 py-2 font-light">Deadline</th>
                    <th class="px-4 py-2 font-light">action</th>
                </tr>
            </thead>
            <tbody id="widget-meetings-table">
                <!-- Rows will be dynamically loaded -->
            </tbody>
        </table>
        <div id="pagination_meetings_widget" class="flex gap-2 mt-4"></div>
    </div>
</div>

<script>

function loadWidgetMeetings() {


        let html =``;
        if(mettingsData.length > 0){
            for(let i=0;i<mettingsData.length;i++){
                //console.log(mettingsData[i].users);
                let url = "{{ route('projects.meetings.edit', [':id']) }}".replace(':id', mettingsData[i].id);
                html+=`<tr class="border-b dark:border-gray-800">
                        <td class="px-4 py-2"><a  class="underline" target="_blank" href="${url}">${mettingsData[i].name}</a></td>
                        <td class="px-4 py-2">${mettingsData[i].planned_date}</td>
               
                        <td class="px-4 py-2">${mettingsData[i].start_time}</td>
                        <td class="px-4 py-2">${mettingsData[i].note.substring(0, 50)}</td>
                        <td class="px-4 py-2">${mettingsData[i].deadline}</td>
                        <td><button type="button" onclick="close_action(${mettingsData[i].note_id})" 
                            class="px-3 py-1  text-xs font-bold bg-red-500 text-white">close Action</button></td>
                    
                
                        </tr>`;
            }
            
        }
        $('#widget-meetings-table').html(html);
        feather.replace();




}


function renderPaginationMeetingsWidget(data) {
    let html = '';
    if (data.last_page > 1) {
        for (let i = 1; i <= data.last_page; i++) {
            html += `<button onclick="get_meeting_planing(${i})" class="px-2 py-1 border ${data.current_page === i ? 'bg-blue-500 text-white' : 'bg-white'}">
                        ${i}
                    </button>`;
        }
    }
    $('#pagination_meetings_widget').html(html);
}


async function close_action(id){
    let url = "{{ route('projects.meetings.close', [':id']) }}".replace(':id', id);
    let response = await fetch(url);
    if(response.status == 200){
        $('.success').show();
        $('.success').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">Closed Successfully</div>');  
        get_meeting_planing();
    }

}
</script>
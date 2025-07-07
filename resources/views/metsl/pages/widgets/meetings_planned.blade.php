<div class="widget" id="widget-planned-meetings">
    <h2 class="bg-red-500 text-md inline-flex uppercase text-white font-semibold px-4 py-2 rounded-t-lg w-fit">
        <i data-feather="list" class="me-2 text-red-700"></i>Meetings Planned
    </h2>
    <div class="overflow-x-auto border border-blue-500 rounded-tl-none rounded-xl">
        <table class="rounded-tl-none min-w-full">
            <thead class="bg-blue-200 dark:bg-blue-500/25 text-sm text-left">
                <tr>
                    <th class="px-4 py-2 font-light">Meeting Type</th>
                    <th class="px-4 py-2 font-light">Planned Date</th>
                    <th class="px-4 py-2 font-light">Planned Start</th>
                    <th class="px-4 py-2 font-light">duration</th>
                    <th class="px-4 py-2 font-light">notes</th>
                    <th class="px-4 py-2 font-light">location</th>
                </tr>
            </thead>
            <tbody id="widget-planned-meetings-table">
                <!-- Rows will be dynamically loaded -->
            </tbody>
        </table>
        <div id="pagination_Planned_meetings_widget" class="flex gap-2 mt-4"></div>
    </div>
</div>

<script>
loadWidgetPlannedMeetings();
async function loadWidgetPlannedMeetings(page=1) {
        let url = `project/meetings/all_planned?page=${page}`;

        let fetchRes = await fetch(url);
        const response = await fetchRes.json(); // full paginated response
        const all_meetings = response.data;

        mettingsData = all_meetings.map(function(item) {
        let namesString = item.users.map((user) => `${user.name}`).join(", ");
        item.users = namesString;
        return item;
        });

        let html =``;
        if(mettingsData.length > 0){
            for(let i=0;i<mettingsData.length;i++){
                //console.log(mettingsData[i].users);
                let url = "{{ route('projects.meetings.edit', [':id']) }}".replace(':id', mettingsData[i].id);
                html+=`<tr class="border-b dark:border-gray-800">
                        <td class="px-4 py-2"><a  class="underline" target="_blank" href="${url}">${mettingsData[i].name}</a></td>
                        <td class="px-4 py-2">${mettingsData[i].planned_date}</td>
               
                        <td class="px-4 py-2">${mettingsData[i].start_time}</td>
                        <td class="px-4 py-2">${mettingsData[i].duration}</td>
                        <td class="px-4 py-2">${mettingsData[i].purpose}</td>
                        <td class="px-4 py-2">${mettingsData[i].location}</td>
                    
                
                        </tr>`;
            }
            
        }
        $('#widget-planned-meetings-table').html(html);
        feather.replace();
        renderPaginationPlannedMeetingsWidget(response);




}


function renderPaginationPlannedMeetingsWidget(data) {
    let html = '';
    if (data.last_page > 1) {
        for (let i = 1; i <= data.last_page; i++) {
            html += `<button onclick="get_meeting_planing(${i})" class="px-2 py-1 border ${data.current_page === i ? 'bg-blue-500 text-white' : 'bg-white'}">
                        ${i}
                    </button>`;
        }
    }
    $('#pagination_Planned_meetings_widget').html(html);
}

</script>
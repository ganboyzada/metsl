<div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold hidden success"></div>
<div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>

<div class="">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div class="flex gap-4 items-center">
            <!-- Date Interval Input -->
            <div class="relative">
                <label for="date-interval" class="sr-only">Date Interval</label>
                <input
                    type="date"
                    id="start-date" value="{{ date_format(\Carbon\Carbon::today(), 'd.m.Y') }}"
                    class="border-0 px-3 py-2 bg-gray-200 dark:bg-gray-800 dark:text-gray-200"
                />
                <span class="mx-2 text-gray-500 dark:text-gray-400">to</span>
                <input
                    type="date"
                    id="end-date" value="{{ date_format(\Carbon\Carbon::today(), 'd.m.Y') }}"
                    class="border-0 px-3 py-2 bg-gray-200 dark:bg-gray-800 dark:text-gray-200"
                />
            </div>

            <!-- Search Bar -->
            <div class="relative">
            <i data-feather="search" stroke-width=2 class="absolute left-2 top-2 text-gray-700 dark:text-gray-300"></i>
            <input
                type="text"
				id="search"
                placeholder="Search"
                class="pl-10 pr-4 py-2 border-0 bg-gray-200 dark:bg-gray-800 dark:text-gray-200"
            />
            </div>
        </div>

        @php
        $expression='add_meeting_planing';
        @endphp
        @if(checkIfUserHasThisPermission(Session::get('projectID') ,$expression))
        <!-- Plan Meeting Button -->
        <a href="{{ route('projects.meetings.create') }}"
            id="plan-meeting-button"
            class="inline-flex px-4 py-2 bg-blue-500 text-white hover:bg-blue-600"
        >
            <i data-feather="video" class="mr-2"></i>
            Plan a Meeting
        </a>
        @endif
    </div>


    <!-- Meetings Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse border dark:border-gray-800">
            <thead class="bg-gray-100 dark:bg-gray-800 text-sm text-left">
                <tr>
            
                    <th class="px-4 py-2 font-light">Meeting Type</th>
                    <th class="px-4 py-2 font-light">Planned Date</th>
                    <th class="px-4 py-2 font-light">Status</th>
                    <th class="px-4 py-2 font-light">Planned Start</th>
                    <th class="px-4 py-2 font-light">Participants</th>
                    <th class="px-4 py-2 font-light">Action</th>
                </tr>
            </thead>
            <tbody id="meetings-table">

            </tbody>
        </table>
        <div id="pagination_meetings" class="flex gap-2 mt-4"></div>

    </div>


</div>
<script>
	$(".projectButton").on('click',function(event) {
		
		if(localStorage.getItem("project_tool") == 'meeting_planing'){

			get_meeting_planing();
		}
	});
	$("#search , #start-date , #end-date").on('input',function(event) {
		get_meeting_planing();
	});
	async function get_meeting_planing(page = 1){
        if(localStorage.getItem("project_tool") == 'meeting_planing'){
		const search = $('#search').val();
		const startDate = $('#start-date').val();
		const endDate = $('#end-date').val();
		
		let url =`project/meetings/all?page=${page}&search=${search}&start_date=${startDate}&end_date=${endDate}`;


        let fetchRes = await fetch(url);
        const response = await fetchRes.json(); // full paginated response
        const all_meetings = response.data;
        renderPaginationMeeting(response); // handle pagination UI


		 correspondenceData = all_meetings.map(function(item) {
			let namesString = item.users.map((user) => `${user.name}`).join(", ");
			item.users = namesString;
			  return item;
			});
			let html =``;
			if(all_meetings.length > 0){
				for(let i=0;i<all_meetings.length;i++){
                    console.log(all_meetings[i].users);
					let url = "{{ route('projects.meetings.edit', [':id']) }}".replace(':id', all_meetings[i].id);
					html+=`<tr class="border-b dark:border-gray-800">
							<td class="px-4 py-2"><a target="_blank" href="${url}">${all_meetings[i].name}</a></td>
							<td class="px-4 py-2">${all_meetings[i].planned_date}</td>
							<td class="px-4 py-2">
								<span class="px-3 py-1 rounded-full text-xs ${all_meetings[i].color} text-white">${all_meetings[i].status_text}</span>
							</td>
							<td class="px-4 py-2">${all_meetings[i].start_time}</td>
							<td class="px-4 py-2">${all_meetings[i].users}</td>
                            <td class="px-4 py-2 flex items-center gap-3">
								<a target="_blank" href="${url}" class="text-blue-500 dark:text-blue-400 hover:text-blue-300">
									<i data-feather="eye" class="w-5 h-5"></i>
								</a>
							</td>
					
							</tr>`;
				}
				
			}
			$('#meetings-table').html(html);
            feather.replace();	
			
        }
	}
    function renderPaginationMeeting(data) {
       
    let html = '';
    if (data.last_page > 1) {
        for (let i = 1; i <= data.last_page; i++) {
            html += `<button onclick="get_meeting_planing(${i})" class="px-2 py-1 border ${data.current_page === i ? 'bg-blue-500 text-white' : 'bg-white'}">
                        ${i}
                    </button>`;
        }
    }
    $('#pagination_meetings').html(html);
}
    async function deleteMeetingPlaning(id){
        $('.error').hide(); 
        $('.success').hide();
		let url =`project/meetings/destroy/${id}`;		
		let fetchRes = await fetch(url);
        if(fetchRes.status != 200){
            $('.error').show();
            $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+fetchRes.statusText+'</div>');

        }else{
            get_meeting_planing();
            $('.success').show();
            $('.success').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold"> Item Deleted Successfully</div>');
        }
    }

	get_meeting_planing();
</script>

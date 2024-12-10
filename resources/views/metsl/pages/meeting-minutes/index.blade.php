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
                    class="border-0 px-3 py-2 bg-gray-200 dark:bg-gray-700 dark:text-gray-200"
                />
                <span class="mx-2 text-gray-500 dark:text-gray-400">to</span>
                <input
                    type="date"
                    id="end-date" value="{{ date_format(\Carbon\Carbon::today(), 'd.m.Y') }}"
                    class="border-0 px-3 py-2 bg-gray-200 dark:bg-gray-700 dark:text-gray-200"
                />
            </div>

            <!-- Search Bar -->
            <div class="relative">
            <i data-feather="search" stroke-width=2 class="absolute left-2 top-2 text-gray-700 dark:text-gray-300"></i>
            <input
                type="text"
				id="search"
                placeholder="Search"
                class="pl-10 pr-4 py-2 border-0 bg-gray-200 dark:bg-gray-700 dark:text-gray-200"
            />
            </div>
        </div>

        <!-- Plan Meeting Button -->
        <a href="{{ route('projects.meetings.create') }}"
            id="plan-meeting-button"
            class="inline-flex px-4 py-2 bg-blue-500 text-white hover:bg-blue-600"
        >
            <i data-feather="video" class="mr-2"></i>
            Plan a Meeting
        </a>
    </div>

    <!-- Meetings Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse border dark:border-gray-800">
            <thead class="bg-gray-100 dark:bg-gray-800 text-sm text-left">
                <tr>
                    <th class="px-4 py-2 font-light">Title</th>
                    <th class="px-4 py-2 font-light">Number</th>
                    <th class="px-4 py-2 font-light">Planned Date</th>
                    <th class="px-4 py-2 font-light">Status</th>
                    <th class="px-4 py-2 font-light">Start Time</th>
                    <th class="px-4 py-2 font-light">Participants</th>
                    <th class="px-4 py-2 font-light">Overview</th>
                </tr>
            </thead>
            <tbody id="meetings-table">

            </tbody>
        </table>
    </div>
</div>
<script>
	$("#search , #start-date , #end-date",).on('input',function(event) {
		get_meeting_planing();
	});
	async function get_meeting_planing(){
		const search = $('#search').val();
		const startDate = $('#start-date').val();
		const endDate = $('#end-date').val();
		
		let url =`project/meetings/all?search=${search}&start_date=${startDate}&end_date=${endDate}`;
		//alert(url);
		
		let fetchRes = await fetch(url);
		const all_meetings = await fetchRes.json();
		 correspondenceData = all_meetings.map(function(item) {
			let namesString = item.users.map((user) => `${user.name}`).join(", ");
			item.users = namesString;
			  return item;
			});
			let html =``;
			if(all_meetings.length > 0){
				for(let i=0;i<all_meetings.length;i++){
					let url = "{{ route('projects.meetings.view', [':id']) }}".replace(':id', all_meetings[i].id);
					html+=`<tr class="border-b dark:border-gray-800">
							<td class="px-4 py-2"><a target="_blank" href="${url}">${all_meetings[i].name}</a></td>
							<td class="px-4 py-2">${all_meetings[i].number}</td>
							<td class="px-4 py-2">${all_meetings[i].planned_date}</td>
							<td class="px-4 py-2">
								<span class="px-3 py-1 rounded-full text-xs ${all_meetings[i].color} text-white">${all_meetings[i].status_text}</span>
							</td>
							<td class="px-4 py-2">${all_meetings[i].start_time}</td>
							<td class="px-4 py-2">${all_meetings[i].users}</td>
							<td class="px-4 py-2">${all_meetings[i].purpose}</td>
					
							</tr>`;
				}
				
			}
			$('#meetings-table').html(html);
			
		console.log(all_meetings);	
	}
	get_meeting_planing();
</script>

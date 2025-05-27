<div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold hidden success"></div>
<div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>
<div class="flex flex-wrap gap-4 items-center mb-4">

    <!-- Search and Actions -->
    <div class="flex items-center mr-auto">
	<form id="filter-punch-list-form"  style = "display: flex;
    flex-wrap: wrap;" method="GET" >
        <div class="relative mr-4">
            <i data-feather="search" stroke-width=2 class="absolute left-2 top-2 text-gray-700 dark:text-gray-300"></i>
            <input
				id="search_punsh_list"
                type="text" name="search"
                placeholder="Search"
                class="pl-10 pr-4 py-2 border-0 bg-gray-200 dark:bg-gray-700 dark:text-gray-200"
            />
        </div>
        
        <div class="has-dropdown relative inline-block mr-2">
            <button type="button" class="dropdown-toggle p-2 bg-gray-200 dark:bg-gray-700 dark:text-gray-200 flex items-center">
                <i data-feather="filter" class="mr-2"></i>Filters
            </button>

            <!-- Dropdown -->
            <div id="filter-dropdown" class="dropdown absolute mt-2 z-10 bg-white dark:bg-gray-800 shadow-lg w-52">
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    <li>
                        <button  type="button"
                            class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"
                            data-filter="assignee" data-filter-type="multi-select"
                        >
                            Assignee
                        </button>
                    </li>
                    <li>
                        <button  type="button"
                            class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"
                            data-filter="closed_by" data-filter-type="multi-select"
                        >
                            Closed by
                        </button>
                    </li>
                    <li>
                        <button  type="button"
                            class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"
                            data-filter="creator" data-filter-type="multi-select"
                        >
                            Creator
                        </button>
                    </li>
      
                    <li>
                        <button  type="button"
                            class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"
                            data-filter="creation_date" data-filter-type="date"
                        >
                            Creation Date
                        </button>
                    </li>
                    <li>
                        <button  type="button"
                            class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"
                            data-filter="date_notified" data-filter-type="date"
                        >
                            Date Notified
                        </button>
                    </li>
                    <li>
                        <button  type="button"
                            class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"
                            data-filter="date_resolved" data-filter-type="date"
                        >
                            Date Resolved
                        </button>
                    </li>					
					
                    <li>
                        <button  type="button"
                            class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"
                            data-filter="due_date" data-filter-type="date"
                        >
                            Due Date
                        </button>
                    </li>
                    <li>
                        <button  type="button"
                            class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"
                            data-filter="priority" data-filter-type="select"
                        >
                            Priority
                        </button>
                    </li>
                    <li>
                        <button  type="button"
                            class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"
                            data-filter="status" data-filter-type="select"
                        >
                            Status
                        </button>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Placeholder for Filters -->
        <div id="filters-container" class="flex items-center space-x-2"></div>
    </form>
	</div>
    @php
        $expression='add_punch_list';
    @endphp
    @if(checkIfUserHasThisPermission(Session::get('projectID') ,$expression))
    <a href="{{ route('projects.punch-list.drawings') }}" class="inline-flex px-4 py-2 bg-blue-500 text-white hover:bg-blue-600"><i data-feather="plus" class="mr-2"></i> Drawings</a>


    <a href="{{ route('projects.punch-list.create') }}" class="inline-flex px-4 py-2 bg-blue-500 text-white hover:bg-blue-600"><i data-feather="plus" class="mr-2"></i> Create New</a>
    @endif
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6 text-gray-600 dark:text-gray-300">
    <!-- Pie Chart -->
    <div class="p-4 bg-gray-100 dark:bg-gray-800 relative">
        <h3 class="mb-2 text-md font-medium absolute left-5 bg-gray-200 dark:bg-gray-700 rounded-full px-3 py-1 bottom-2">Overall Status</h3>
        <div>
            <canvas id="status-pie-chart" class="h-40"></canvas>
        </div>
    </div>

    <!-- Bar Chart -->
    <div class="p-4 bg-gray-100 dark:bg-gray-800 relative">
    <h3 class="mb-2 text-md font-medium absolute left-5 bg-gray-200 dark:bg-gray-700 rounded-full px-3 py-1 bottom-2">Issues Per Assignee</h3>
        <div class="pb-12">
            <canvas id="assignee-bar-chart" class="h-40"></canvas>
        </div>
    </div>
    {{--
    <!-- Average Response Time -->
    <div class="p-4 bg-white dark:bg-gray-800">
        <h3 class="mb-2 text-sm font-medium">Average Response Time</h3>
        <p class="text-2xl font-bold text-gray-800">26.4 days</p>
    </div>
    --}}
    <!-- Total Overdue Items -->
    <div class="p-4 bg-gray-100 dark:bg-gray-800">
        <h3 class="mb-2 text-lg font-medium">Total Overdue Snag List Items</h3>
        <p class="text-4xl font-bold punlists_overdue_count">0</p>
    </div>
</div>


<div class="overflow-x-auto">
    <table class="w-full text-left border-collapse border dark:border-gray-800">
        <thead class="bg-gray-100 dark:bg-gray-800 text-sm text-left">
            <tr>
                <th class="px-4 py-2 font-light">#</th>
                <th class="px-4 py-2 font-light">Title</th>
                <th class="px-4 py-2 font-light">Status</th>
                <th class="px-4 py-2 font-light">Assignee Company</th>
                <th class="px-4 py-2 font-light">Priority</th>
                <th class="px-4 py-2 font-light">Date Notified</th>
                <th class="px-4 py-2 font-light">Date Resolved</th>
                <th class="px-4 py-2 font-light">Due Date</th>
                <th class="px-4 py-2 font-light">Created By</th>
                <th class="px-4 py-2 font-light">Drawing Title</th>
                <th class="px-4 py-2 font-light">Actions</th>
            </tr>
        </thead>
        <tbody id="punch-lists-table">
           
        </tbody>
    </table>

    <div id="pagination" class="flex gap-2 mt-4"></div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let reviewers_obj = [];
    
    async  function getChangedParticipates(){
		let fetchRes = await fetch(`{{url('project/punch-list/allParticipates')}}`);
		const all = await fetchRes.json();

		const reviewers = all.users.map(function(item) {
		  return {'value' : item.id , 'label' : item.name};
		});
        for(let i = 0; i < reviewers_obj.length;i++){
            reviewers_obj[i].clearStore();
            reviewers_obj[i].setChoices(reviewers);
        }		
	}			

	getAllParticipates();
    getAllStatusPeriority();
    let reviewers = {};
	let priority = {};
	let status = {};
	let status_list_labels = {};
	let status_list_colors = {};
    let statusPieChart = {};

    let assigness =  {};
    let overdue  =  {};
    let next_7_days =  {};
    let more_7_days =  {};
 
	async  function getAllParticipates(){

		if(localStorage.getItem("project_tool") == 'punch_list'){

			let fetchRes = await fetch(`{{url('project/punch-list/allParticipates')}}`);
			const all = await fetchRes.json();
			reviewers = all.users.map(function(item) {
			  return {'value' : item.id , 'label' : item.name};
			}); 	
            //convertToLowerCase();	
	
		}	
	
    }

    async  function getAllStatusPeriority(){
		if(localStorage.getItem("project_tool") == 'punch_list'){

			let fetchRes = await fetch(`{{url('project/punch-list/allStatusPeriorityOption')}}`);
			const all = await fetchRes.json();
			priority = all.priority;
			status = all.status;
			status_list_labels = all.status_list_labels;
			status_list_colors = all.status_list_colors;
            statusPieChart = all.statusPieChart;
            assigness = all.assignees;
            overdue  = all.overdue;
            next_7_days = all.next_7_days;
            more_7_days = all.more_7_days;       
            $('.punlists_overdue_count').html(all.punlists_overdue_count);
            await runPieChart(status_list_labels , status_list_colors , statusPieChart);




            await runParChart(assigness , overdue , next_7_days , more_7_days);
			
		}	
	
    }
    async function set_projectID_punch_list(){
        var projectId = $('#selected_project_id').val();
        var projectName = $('#selected_project_name').val();
        // let url = `/project/storeIdSession?projectID=${projectId}&projectName=${projectName}`;

        // let fetchRes = await fetch(url);
        get_punch_list();		
        getChangedParticipates();
        getAllStatusPeriority();
    } 	
	// $(".projectButton").on('click',function(event) {
		
	// 	if(localStorage.getItem("project_tool") == 'punch_list'){
    //         set_projectID_punch_list();

	// 	}
	// });

	$("#search_punsh_list , .dates").on('input',function(event) {
        get_punch_list();
	});
	
    let chart;
    function runPieChart(labels , colors , data){
        if(chart){
            chart.data.datasets[0].data = data;
            chart.update();
        }else{
            const pieCtx = document.getElementById('status-pie-chart').getContext('2d');
            chart = new Chart(pieCtx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            data: data,
                            backgroundColor: colors,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    borderWidth: 0,
                    radius: '80%',
                    plugins: {
                        legend: {
                            labels: {
                                color: getLabelColor(), // Dynamically set legend label color
                            },
                        },
                    },
                    
                }
            });            
        }
                    // Pie Chart

    }	

    
    let par_chart;
    function runParChart(assigness , overdue , next_7_days , more_7_days){
        if(par_chart){
            let data_set = [
                {
                    label: 'Overdue',
                    data: overdue,
                    backgroundColor: '#ff5a5a', // Red
                },
                {
                    label: 'Next 7 days',
                    data: next_7_days,
                    backgroundColor: '#3b82f6', // blue
                },
                {
                    label: 'Nore than 7 Days',
                    data: more_7_days,
                    backgroundColor: '#374151', // gray
                },
            ];
            //console.log(data_set);
            par_chart.data.labels = assigness;
            par_chart.data.datasets = data_set;
            par_chart.update();
        }else{
            // Bar Chart
            //console.log(assigness);
            const barCtx = document.getElementById('assignee-bar-chart').getContext('2d');
            par_chart = new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: assigness,
                    datasets: [
                        {
                            label: 'Overdue',
                            data: overdue,
                            backgroundColor: '#ff5a5a', // Red
                        },
                        {
                            label: 'Next 7 Days',
                            data: next_7_days,
                            backgroundColor: '#3b82f6', // blue
                        },
                        {
                            label: 'More than 7 days',
                            data: more_7_days,
                            backgroundColor: '#374151', // gray
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Disable aspect ratio for height control
                    borderRadius: 9999,
                    barThickness: 20,
                    barPercentage: 0.6,
                    plugins: {
                        legend: {
                            labels: {
                                color: getLabelColor(), // Dynamically set legend label color
                            },
                        },
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: getLabelColor(), // Dynamically set x-axis label color
                            },
                        },
                        y: {
                            ticks: {
                                color: getLabelColor(), // Dynamically set y-axis label color
                            },
                        },
                    },
                },
            });

                
        
        
        }
                    // Pie Chart

    }	
	
    async function get_punch_list(page = 1) {


    if (localStorage.getItem("project_tool") == 'activities') {
        let url = `project/punch-list/all_open?page=${page}`;

        let fetchRes = await fetch(url);
        const response = await fetchRes.json(); // full paginated response
        const all_punch_lists = response.data;

        await loadPunchListWidget(all_punch_lists);
        renderPaginationPunch(response);
    } else {

        const queryString = $("#filter-punch-list-form").serialize();
        const search = $('#search_punsh_list').val();

        let url = `project/punch-list/all?page=${page}&${queryString}`;

        let fetchRes = await fetch(url);
        const response = await fetchRes.json(); // full paginated response
        const all_punch_lists = response.data;        
        await loadPunchList(all_punch_lists);
        renderPagination(response);
    }

     // handle pagination UI
    feather.replace();
}
function renderPagination(data) {
    let html = '';
    if (data.last_page > 1) {
        for (let i = 1; i <= data.last_page; i++) {
            html += `<button onclick="get_punch_list(${i})" class="px-2 py-1 border ${data.current_page === i ? 'bg-blue-500 text-white' : 'bg-white'}">
                        ${i}
                    </button>`;
        }
    }
    $('#pagination').html(html);
}
  

    function loadPunchList(list){
        let html =``;
        if(list.length > 0){
            for(let i=0;i<list.length;i++){
                let url = "{{ route('projects.punch-list.edit', [':id']) }}".replace(':id', list[i].id);
                html+=`<tr class="border-b dark:border-gray-800">
                        <td class="px-4 py-2">${list[i].number}</td>
                        <td class="px-4 py-2">${list[i].title}</td>
                        <td class="px-4 py-2">${list[i].status_text}</td>
                        <td class="px-4 py-2">${list[i].responsible.name}</td>
                    
                        <td class="px-4 py-2">${list[i].priority_text}</td>
                        <td class="px-4 py-2">${list[i].date_notified_at ?? '-'}</td>
                        <td class="px-4 py-2">${list[i].date_resolved_at ?? '-'}</td>
                        <td class="px-4 py-2">${list[i].due_date ?? '-'}</td>
                        <td class="px-4 py-2">${list[i].created_by_user.name ?? '-'}</td>
                        <td class="px-4 py-2">${list[i].drawing.title ?? '-'}</td>
                        <td class="px-4 py-2">
                            <a target="_blank" href="${url}" class="text-gray-500 dark:text-gray-400 hover:text-gray-300">
                                <i data-feather="eye" class="w-5 h-5"></i>
                            </a>
                        </td>
                
                        </tr>`;
            }	
        } $('#punch-lists-table').html(html);
    }

    async function deletePunchList(id){
        $('.error').hide(); 
        $('.success').hide();
		let url =`project/punch-list/destroy/${id}`;		
		let fetchRes = await fetch(url);
        if(fetchRes.status != 200){
            $('.error').show();
            $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+fetchRes.statusText+'</div>');

        }else{
            //console.log(fetchRes);
            get_punch_list();
            $('.success').show();
            $('.success').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold"> Item Deleted Successfully</div>');
        }


    }
    function getLabelColor() {
        let isDarkMode = localStorage.getItem('theme') == 'dark' ? true : false;
        
        return isDarkMode ? '#ffffff' : '#000000'; // White for dark mode, Black for light mode
    }



    document.addEventListener('DOMContentLoaded', () => {
        const filterDropdown = document.getElementById('filter-dropdown');
        const filtersContainer = document.getElementById('filters-container');

        // Add Choices.js Component Dynamically
        filterDropdown.addEventListener('click', (event) => {
            const target = event.target.closest('button[data-filter]');
            if (target) {
                $(target).closest('.dropdown').toggleClass('active');

                const filterName = target.getAttribute('data-filter');
                const filterType = target.getAttribute('data-filter-type');

                // Create a new filter block
                const filterBlock = document.createElement('div');
                filterBlock.className = 'w-52';

                let input = null
                let options = null;
               // alert(filterType);
                switch (filterType) {
                    case 'multi-select':
                        input = document.createElement('select');
                        input.className = 'choices dark:bg-gray-700 dark:text-gray-200';
                        input.setAttribute('multiple', true);
                        input.setAttribute('id', `filterby_${filterName}`);
                        input.setAttribute('name', filterName+'[]');
						input.setAttribute('onchange',get_punch_list());
 						input.onchange = function(e) {get_punch_list(e);}; 
                  

                        filterBlock.appendChild(input);
                        filtersContainer.appendChild(filterBlock);
                        reviewers_obj.push(populateChoices2(`filterby_${filterName}`, reviewers, true, `Select ${filterName}s`));
                       // populateChoices(`filterby_${filterName}`, options, true, `Select ${filterName}s`);
                        break;
                    
                    case 'select':
                        input = document.createElement('select');
                        input.className = 'choices dark:bg-gray-700 dark:text-gray-200';
                        input.setAttribute('id', `filterby_${filterName}`);
                        input.setAttribute('name', filterName);
						input.setAttribute('onchange',get_punch_list());
						if(filterName == 'priority'){
							options = priority;
						}else if(filterName == 'status'){
							options = status;	
						}
						input.onchange = function(e) {get_punch_list(e);}; 
              

                        filterBlock.appendChild(input);
                        filtersContainer.appendChild(filterBlock);
                        populateChoices(`filterby_${filterName}`, options, false, `Select a ${filterName}`);
                        break;

                    case 'date':
                        input = document.createElement('input');
                        input.className = 'dates w-full border-0 dark:bg-gray-700 dark:text-gray-200';
                        input.setAttribute('id', `filterby_${filterName}`);
                        input.setAttribute('name', filterName);
                        input.setAttribute('type', 'date');
						input.oninput = function(e) {get_punch_list(e);}; 

                        filterBlock.appendChild(input);
                        filtersContainer.appendChild(filterBlock);
                        break;
                
                    default:
                        break;
                }
                
                
            }
        });
});
</script>
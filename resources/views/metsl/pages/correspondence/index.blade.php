<div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold hidden success"></div>
<div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>
<div>
    <!-- Page Header -->
    <div class="flex items-center gap-4 mb-4">
        <div class="flex items-center gap-4 mr-auto">
            <div class="relative">
                <i data-feather="search" stroke-width=2 class="absolute left-2 top-2"></i>
                <input
                    type="text"
                    placeholder="Search"
					name="search"
                    class="pl-10 pr-4 py-2 border-0 bg-gray-200 dark:bg-gray-700 dark:text-gray-200"
                />
            </div>
            <button  onclick="search()" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 dark:text-gray-200" >Add Filter</button>
        </div>
        <!-- Create Button with Dropdown -->
        <div class="has-dropdown relative">
            <button
                class="dropdown-toggle flex items-center px-4 py-2 bg-blue-500 text-white  hover:bg-blue-600 focus:outline-none"
            >
                <i data-feather="plus" class="w-5 h-5 mr-2"></i>
                Create
            </button>
            <!-- Dropdown Menu -->
            <div
                class="dropdown absolute right-0 mt-2 w-32 bg-gray-800 text-gray-200  shadow-lg"
            >
                @php
                $enums_list = \App\Enums\CorrespondenceTypeEnum::cases();
               // dd($enums_list);
                @endphp
                @foreach ($enums_list as $enum)
                @php
                    $expression = 'create_'.$enum->name;

                @endphp
                    @if(checkIfUserHasThisPermission(Session::get('projectID') ,$expression))
                    <a href="{{ url('project/correspondence/create?type='.$enum->value) }}"
                         class="flex px-4 py-2 hover:bg-gray-700"><i class="mr-2" data-feather="{{$enum->dataFeather()}}"></i>{{$enum->name}}</a>
                    @endif
                @endforeach

          
            </div>
        </div>
    </div>

    <!-- Correspondence Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse border dark:border-gray-800">
            <thead class="bg-gray-100 dark:bg-gray-800 text-sm text-left">
                <tr>
                    <th  onclick="sortTable('number')"  data-column="number"  class="sortable cursor-pointer px-6 py-3 font-light">Number <svg class="sort-icon w-3 h-3 transition-all text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24" stroke="currentcolor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="" />
                    </svg></th>
                    <th onclick="sortTable('subject')"   data-column="subject" class="sortable cursor-pointer px-6 py-3 font-light">Subject <svg class="sort-icon w-3 h-3 transition-all text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24" stroke="currentcolor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="" />
                    </svg></th>
                    <th onclick="sortTable('last_upload_date')" data-column="last_upload_date"  class="sortable cursor-pointer px-6 py-3 font-light">Last Activity <svg class="sort-icon w-3 h-3 transition-all text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24" stroke="currentcolor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="" />
                    </svg></th>
                    <th onclick="sortTable('assignees')" data-column="assignees"  class="sortable cursor-pointer px-6 py-3 font-light">Assignees <svg class="sort-icon w-3 h-3 transition-all text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24" stroke="currentcolor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="" />
                    </svg></th>
                    <th onclick="sortTable('created_by')" data-column="created_by"  class="sortable cursor-pointer px-6 py-3 font-light">Created by <svg class="sort-icon w-3 h-3 transition-all text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24" stroke="currentcolor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="" />
                    </svg></th>
                    <th onclick="sortTable('created_date')" data-column="created_date"  class="sortable cursor-pointer px-6 py-3 font-light">Created at <svg class="sort-icon w-3 h-3 transition-all text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24" stroke="currentcolor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="" />
                    </svg></th>
                    <th onclick="sortTable('due_date')" data-column="due_date"  class="sortable cursor-pointer px-6 py-3 font-light">due date <svg class="sort-icon w-3 h-3 transition-all text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24" stroke="currentcolor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="" />
                    </svg></th>
                    <th onclick="sortTable('status')" data-column="status"  class="sortable cursor-pointer px-6 py-3 font-light">Status <svg class="sort-icon w-3 h-3 transition-all text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24" stroke="currentcolor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="" />
                    </svg></th>
                </tr>
            </thead>
            <tbody id="table-body-correspondence">
                <!-- Rows will be dynamically loaded -->
            </tbody>
        </table>
        <div id="pagination_correspondence" class="flex gap-2 mt-4"></div>
    </div>
</div>

<script>
    async function set_projectID_correspondence(){
        var projectId = $('#selected_project_id').val();
        var projectName = $('#selected_project_name').val();
        // let url = `/project/storeIdSession?projectID=${projectId}&projectName=${projectName}`;

        // let fetchRes = await fetch(url);
        get_correspondences();
    }
	// $(".projectButton").on('click',function(event) {
        
    //     set_projectID_correspondence();
        
	// 	// loadedRows = 0;
       
	// 	// if(localStorage.getItem("project_tool") == 'correspondence'){
	// 	// 	get_correspondences();
	// 	// }
	// });

    let allDataLength = 0;

	async function search(e, page = 1){
		loadedRows = 0;
		const search = $('[name="search"]').val();

        let url = `project/correspondence/all?page=${page}&search=${search}`;

        let fetchRes = await fetch(url);
        const response = await fetchRes.json(); // full paginated response
        const all_correspondes = response.data;

		 correspondenceData = all_correspondes.map(function(item) {
			let namesString = item.assignees.map((user) => `${user.name}`).join(", ");
			item.assignees = namesString;
			  return item;
			});
        allDataLength = correspondenceData.length;	
		await loadRows();
        renderPaginationCorrespondence(response);
        feather.replace();	

	}
    	let correspondenceData = [];

    let currentSortColumn = 'id';
    let currentSortDirection = 'desc';

    function sortTable(column) {
        if (currentSortColumn === column) {
            // عكس الاتجاه لو تم الضغط مرتين على نفس العمود
            currentSortDirection = currentSortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            currentSortColumn = column;
            currentSortDirection = 'asc';
        }


        
        get_correspondences(1, currentSortColumn, currentSortDirection);
        updateTableHeaders();
    }


    function updateTableHeaders() {
    const headers = document.querySelectorAll("th.sortable");
    headers.forEach((th) => {
        const column = th.getAttribute("data-column");
        const svg = th.querySelector(".sort-icon");
        const path = svg.querySelector("path");

        if (column === currentSortColumn) {
            svg.classList.add("text-blue-500");
            if (currentSortDirection === "asc") {
                path.setAttribute("d", "M5 15l7-7 7 7"); // سهم للأعلى
            } else {
                path.setAttribute("d", "M19 9l-7 7-7-7"); // سهم للأسفل
            }
        } else {
            path.setAttribute("d", "");
            svg.classList.remove("text-blue-500");
        }
    });
    }



    function renderPaginationCorrespondence(data) {
    let html = '';
    if (data.last_page > 1) {
        for (let i = 1; i <= data.last_page; i++) {
            html += `<button onclick="get_correspondences(${i})" class="px-2 py-1 border ${data.current_page === i ? 'bg-blue-500 text-white' : 'bg-white'}">
                        ${i}
                    </button>`;
        }
    }
    $('#pagination_correspondence').html(html);
}
    // Populate Assignees, Distribution Members, and Received From

	async function get_correspondences(page = 1, orderBy = 'id', sortDirection = 'desc'){
        let tool_temp = localStorage.getItem("project_tool");
		if(tool_temp == 'correspondence' || tool_temp == 'activities'){

            if(tool_temp == 'correspondence'){
                const type = $('[name="type"]').val();
                let url = `project/correspondence/all?page=${page}&orderBy=${orderBy}&sortDirection=${sortDirection}`;


                let fetchRes = await fetch(url);
                const response = await fetchRes.json(); // full paginated response
                const all_correspondes = response.data;

                correspondenceData = all_correspondes.map(function(item) {
                    let namesString = item.assignees.map((user) => `${user.name}`).join(", ");
                    item.assignees = namesString;
                    return item;
                });
                await loadRows();
                renderPaginationCorrespondence(response);
            } else{

                let url = `project/correspondence/all_open?page=${page}`;

                let fetchRes = await fetch(url);
                const response = await fetchRes.json(); // full paginated response
                const all_correspondes = response.data;

                correspondenceData = all_correspondes.map(function(item) {
                    let namesString = item.assignees.map((user) => `${user.name}`).join(", ");
                    item.assignees = namesString;
                    return item;
                });
                await loadWidgetCorrespondence();
                renderPaginationCorrespondenceWidget(response);
            }
            
            
            feather.replace();
		}		
    }

    
    // Lazy load rows
    function loadRows() {
        let html =``;
		if(correspondenceData.length > 0){ 
   
			for(let i=0;i<correspondenceData.length;i++){
                const row = correspondenceData[i];
              
                let url = "{{ route('projects.correspondence.view', [':id']) }}".replace(':id', row.id);
                let url2 = "{{ route('projects.correspondence.edit', [':id']) }}".replace(':id', row.id);

                html+=`<tr>
                    <td class="px-6 py-3">${row.number}</td>
                    <td class="px-6 py-3"><a class="underline" href="${url}">${row.subject}</a></td>
                    <td class="px-6 py-3">${(row.last_upload_date != null) ? row.last_upload_date : ''}</td>
                    <td class="px-6 py-3">${row.assignees}</td>
                    <td class="px-6 py-3">${(row.created_by != null) ? row.created_by.name : ''}</td>
                    <td class="px-6 py-3">${row.created_date}</td>
                    <td class="px-6 py-3">${row.due_date}</td>
                    <td class="px-6 py-3">
                        ${row.label2}  
                    </td></tr>
                `;

			}
		}
        $('#table-body-correspondence').html(html);
    }

    async function deleteCorrespondence(id , i){
        $('.error').hide(); 
        $('.success').hide();
		let url =`/project/correspondence/destroy/${id}`;		
		let fetchRes = await fetch(url);
        if(fetchRes.status != 200){
            $('.error').show();
            $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+fetchRes.statusText+'</div>');

        }else{
           // console.log(fetchRes);
            $('.corespondence_row'+i).remove();
            correspondenceData.splice(i,1);
            loadedRows = loadedRows - 1;
            rowsToLoad = rowsToLoad - loadedRows;

            loadRows();
            feather.replace();	
            $('#table-body').children('tr').each(function(i){
                $(this).attr('class', 'border-b dark:border-gray-800 hover:shadow-lg hover:bg-gray-100 hover:dark:bg-gray-700 corespondence_row'+$(this).index());
            });
            $('.success').show();
            $('.success').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold"> Item Deleted Successfully</div>');
            rowsToLoad = 4;
        }


    }

    // Detect scroll for lazy loading
    window.addEventListener('scroll', () => {
        const { scrollTop, scrollHeight, clientHeight } = document.documentElement;
        
        if (scrollTop + clientHeight >= scrollHeight - 50) {
            loadRows();
        }
    });

    // Initial load
    //loadRows();
</script>
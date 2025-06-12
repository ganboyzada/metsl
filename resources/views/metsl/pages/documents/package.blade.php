@extends('metsl.layouts.master')

@section('title', 'Correspondence - Create')

@section('content')
<!-- Top Toolbar -->
<div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold hidden success"></div>
<div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>
<div class="flex flex-wrap items-end justify-between gap-4 mb-6 relative z-10">

	<div class="flex flex-wrap lg:flex-nowrap gap-2 w-full md:w-auto">
	
		@php

			$packages = \App\Models\Package::where('project_id',Session::get('projectID'))->get();
			if(checkIfUserHasThisPermission(Session::get('projectID') ,'modify_package')){
				$packages2 = $packages;
			}
			else if(!auth()->user()->is_admin){
				$packages2 = \App\Models\Package::join('package_assignees', 'packages.id', '=', 'package_assignees.package_id')
				->where('project_id',Session::get('projectID'))->where('user_id',auth()->user()->id)->select('packages.*')->get();

			}else{
				$packages2 = $packages;
			}
		@endphp
		<div class="has-dropdown w-full sm:w-1/2 md:w-full relative inline-block text-left">
			<!-- Dropdown Toggle Button -->
			<button class="dropdown-toggle w-full flex gap-2 items-center px-3 py-2 bg-gray-200 dark:bg-gray-800">
				<i data-feather="folder" class="text-gray-500 dark:text-gray-400"></i>
				<span class="text-sm font-semibold me-auto" id="current-doc-package">Choose a Package</span>
				<i data-feather="chevron-down" class="text-gray-400 dark:text-gray-500"></i>
			</button>

			<!-- Dropdown Menu -->
			<div class="dropdown absolute left-0 min-w-full w-max bg-gray-800 text-gray-200 shadow-lg">
				<div  class="text-sm grid grid-cols-1 tab-links bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 shadow-lg text-left">
		
					
					@if ($packages->count() > 0)
						@foreach ($packages as $package)
							<button class="p-3 hover:bg-gray/75" onclick="set_package_id('{{ $package->id }}', '{{ $package->name }}'); ">
								<i class="mr-1 text-gray-500 dark:text-gray-400" data-feather="folder"></i>
								{{ $package->name }}
							</button>
						@endforeach
					@endif

					
					
				</div>
			</div>
		</div>
		@php
			$expression = 'modify_package';

		@endphp
		@if(checkIfUserHasThisPermission(Session::get('projectID') ,$expression))
		<button type="button" class="w-full modal-toggler px-2 bg-gray-200 dark:bg-gray-800 text-orange-400" data-modal="subfolder-modal">
			<i data-feather="plus"></i> Create SubFolders in {{ $package_detail->name }} 
		</button>
		@endif
	</div>
    
	<input type="hidden" id="comments_permission" value="{{ checkIfUserHasThisPermission(Session::get('projectID') , 'review_documents') }}"/>

	<input type="hidden" id="accept_reject_document" value="{{ checkIfUserHasThisPermission(Session::get('projectID') , 'accept_reject_document') }}"/>
	
    <!-- Order By and Filter -->
    <div class="flex items-end gap-4">

        
		@if(checkIfUserHasThisPermission(Session::get('projectID') ,'add_documents'))
		<button onclick="reset_model();" data-modal="uploader-modal" class="modal-toggler bg-blue-500 h-full text-white px-3 py-2 hover:bg-blue-600 flex gap-1 items-center transition duration-200">
			<i data-feather="file-plus" class="w-5 h-5"></i> <span class="hidden md:inline">Add Document</span>
		</button>
		@endif
    </div>
</div>
<h1 class=" text-lg ps-5 font-medium text-gray-700 dark:text-gray-200">
    subFolders in  {{ $package_detail->name??'' }} 
    </h1>
<!-- File Manager Grid -->
<div id="packages_list" class="my-4 grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">

    @if ($package_detail->subFolders->count() > 0)
        @foreach ($package_detail->subFolders as $subFolder)
        <a href="{{ url('project/documents/package/subfolder/'.$subFolder->id) }}">
            <div class="relative h-36 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md group transition transform hover:scale-105">
					<h3 class="text-sm font-medium dark:text-gray-400 mb-2 truncate">{{ $package_detail->name }} / {{ $subFolder->name }}</h3>

					<span class="flex absolute bottom-10 right-4 text-xs font-semibold text-blue-500 dark:text-blue-300">
						{{ $subFolder->created_at->diffForHumans() }}
					
					</span>
					
						<i data-feather="file-text" class="w-12 h-12   text-blue-500  dark:text-blue-300"></i>
					
					
				
					<span class="absolute bottom-2 right-2 flex items-center text-xs font-semibold bg-blue-900 text-white rounded-full px-2 py-1">
						<i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i>{{ $subFolder->documents_count??0 }}
					</span>
					
				</div></a>

        @endforeach
        
    @endif


</div>

<div class="  hidden" id="doc_list">
    <hr>


<div class="flex flex-wrap items-end justify-between gap-4 mb-6 relative z-10">

	<div class="flex flex-wrap lg:flex-nowrap gap-2 w-full md:w-auto">
		<div class="relative flex items-center w-full sm:w-1/2 md:w-full">
            <input type="text" id="searchDocuments" placeholder="Search by Doc.No" oninput="get_documents()"
                class="w-full pl-10 pr-4 py-2 border-0 bg-gray-200 dark:bg-gray-800 dark:text-gray-200" />
            <i data-feather="search" class="absolute left-2 top-2"></i>
        </div>


	
	</div>
    
	
    <!-- Order By and Filter -->
    <div class="flex items-end gap-4">
        <div>
            <label for="order-by" class="text-sm font-medium dark:text-gray-400">Order by:</label>
			<div class="flex items-center">
				<select id="order-by" class="w-24 md:w-auto px-3 py-2 border-none bg-gray-200 dark:bg-gray-800 dark:text-gray-200">
					<option value="number">Name</option>
					<option value="created_date">Initial Upload Date</option>
					<option value="size">Size</option>
					<option value="upload_date">Last Revision Date</option>
				</select>
				<select id="order-direction" class="ml-2 border-none bg-gray-200 ps-3 pe-7 py-2 dark:bg-gray-800 dark:text-gray-200">
					<option value="desc">Desc.</option>
					<option value="asc">Asc.</option>
				</select>
			</div>
            
        </div>

        <!-- Filter By You -->
		<div>
			<label for="filter-by" class="text-sm font-medium dark:text-gray-400 mr-2">Filter:</label>
			<div class="flex items-center">
				<select id="filter-by" class="px-3 py-2 border-none bg-gray-200 dark:bg-gray-800 dark:text-gray-200">
					<option>All</option>
					<option>By You</option>
				</select>
			</div>
		</div>
        
		
    </div>
</div>


    <h1 class=" text-lg ps-5 font-medium text-gray-700 dark:text-gray-200">
    Documents in  {{ $package_detail->name }}
    </h1>
</div>
<div id="documents_list" class="my-4 grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 hidden">


</div>
@include('metsl.pages.documents.create_subfolder')
@include('metsl.pages.documents.uploader2')

<script>


    async function getSubfolders(package_id){
        let url = `/project/documents/package/subfolders/${package_id}`;
        let fetchRes = await fetch(url);
        let response = await fetchRes.json();
        let html = `<option value="">select subfolder</option>`;
		if(response.length > 0){
			for(var i=0;i<response.length;i++){
				html+=`<option value="${response[i].id}">${response[i].name}</option>`;
			}

		}

		$('#subfolder_id').html(html);
		
    }
	
	async function set_projectID_docs(){
        var projectId = $('#selected_project_id').val();
        var projectName = $('#selected_project_name').val();
        // let url = `/project/storeIdSession?projectID=${projectId}&projectName=${projectName}`;

        // let fetchRes = await fetch(url);
        //get_documents();
		get_packages();
    }

	// $(".projectButton").on('click',function(event) {
	// 	if(localStorage.getItem("project_tool") == 'documents'){			
	// 		set_projectID_docs();
	// 	}
	// });
	$("#order-by , #order-direction").on('change',function(event) {
		loadedRows = 0;
		if(localStorage.getItem("project_tool") == 'documents'){
			get_documents();
		}
	});	
	function reset_model(){
		$('#document_id').val(0);
		$('#document-number').val('');
		$('#title').val('');
		$('#file-list').html('');
		$('.file-list').html('');		
	}
	

	async function get_revisions(id , number){
		$('#revisions-title').html('Revisions for '+number);
		current_document_id = id;
		$('.error').hide();
		$('.success').hide();
		$(".error").html("");
		$(".success").html("");
	
		$('#success_div').hide();
		$("#success_div").html("");
		let html = ``;
		let url = 	`{{url('project/documents/edit/${id}')}}`	;
		let fetchRes = await fetch(url);
		let detail = await fetchRes.json();
		let url2 = 	`{{url('/project/documents/revisions/${id}')}}`	;
		let fetchRes2 = await fetch(url2);
		let revisions = await fetchRes2.json();
		if(detail.files.length > 0){
			html+=``;
			for(var i=0;i<detail.files.length;i++){
				var file_url = 	`{{asset('storage/project${detail.project_id}/documents${detail.id}/${detail.files[i].file}')}}`;	
				var preview_image = 	`{{asset('storage/project${detail.project_id}/documents${detail.id}/${detail.files[i].preview_image}')}}`;	
			
				html+=`<tr class="group hover:bg-gray-100 dark:hover:bg-gray-700" ${i==0 ? 'style="background-color: #ffd70026;"' : ''}>
                    <td class="py-2 px-4">${i + 1}</td>
					<td class="py-2 px-4"><a href="${preview_image}" target="_blank"><img src="${preview_image}" style="width:25%;"/></a></td>
                    <td class="py-2 px-4">${ detail.title == null ? '-' : detail.title}</td>
                    <td class="py-2 px-4">${ detail.user.name}</td>
                    <td class="py-2 px-4">${ detail.created_date}</td>
					
                    <td class="py-2 px-4">`;
						if(detail.status == 0){
							html+=`Pending`;
						}else if(detail.status == 1){
							html+=`Accepted`;
						}else{
							html+=`Rejected`;
							
						}
						
				
				html+=`</td>
                    <td class="py-2 px-4 flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                       `;

					   if(revisions.length == 0){
						
						if($('#accept_reject_document').val() == 1){
							if(detail.status ==0){
								html+=`<button onclick="update_doc_status(${detail.id} , 1 , '${detail.number}' , ${detail.files[i].id})" class="text-green-500 hover:text-green-700">
									<i data-feather="check" stroke-width="2" class="w-5 h-5"></i>
								</button>`;
								
							}
							if(detail.status ==0 ){
							
							html+=`<button  onclick="update_doc_status(${detail.id} , 2 , '${detail.number}' , ${detail.files[i].id})" class="text-red-500 hover:text-red-700">
								<i data-feather="x-circle" stroke-width="2" class="w-5 h-5"></i>
							</button>`;
							}
						}

						if($('#comments_permission').val() == 1){
							html+=`<button class="text-yellow-500 hover:text-yellow-700 comment-button" onclick="show_comment(${detail.files[i].id} , 'file',${detail.id})">
								<i data-feather="message-circle" stroke-width="2" class="w-5 h-5"></i>
							</button>`;
						}

							   html+=`<a target="_blank" href="${ file_url }" class="text-blue-500 hover:text-blue-700">
								<i data-feather="download" stroke-width="2" class="w-5 h-5"></i>
							</a>`;
					   
                       }
                   
                
                    html+=`</td>
                </tr>`;

	
			}
			
		}		

		if(revisions.length > 0){
			var z = i+1;
			for(let i=0; i<revisions.length; i++){
				
				html+=`<tr class="group hover:bg-gray-100 dark:hover:bg-gray-700">

                    <td class="py-2 px-4">${z++}</td>
					<td class="py-2 px-4"><a href="${revisions[i].preview_image }" target="_blank"><img src="${revisions[i].preview_image }" style="width:25%;"/></a></td>

                    <td class="py-2 px-4">${ revisions[i].title}</td>
                    <td class="py-2 px-4">${ revisions[i].user.name}</td>
                    <td class="py-2 px-4">${ revisions[i].upload_date}</td>
                    <td class="py-2 px-4">${ revisions[i].status_text}</td>
                    <td class="py-2 px-4 flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                       `;

					

						if($('#accept_reject_document').val() == 1){
						if(revisions[i].status ==0){
							html+=`<button onclick="update_status(${revisions[i].id} , 1 , '${detail.number}',${detail.id})" class="text-green-500 hover:text-green-700">
								<i data-feather="check" stroke-width="2" class="w-5 h-5"></i>
							</button>`;
							
						}
						
						if(revisions[i].status ==0){
						
							html+=`<button  onclick="update_status(${revisions[i].id} , 2 , '${detail.number}',${detail.id})" class="text-red-500 hover:text-red-700">
								<i data-feather="x-circle" stroke-width="2" class="w-5 h-5"></i>
							</button>`;
						}
						}

						if($('#comments_permission').val() == 1){
							html+=`<button class="text-yellow-500 hover:text-yellow-700 comment-button" onclick="show_comment(${revisions[i].id},'revision',${detail.id})">
								<i data-feather="message-circle" stroke-width="2" class="w-5 h-5"></i>
							</button>`;
						}
						if(revisions[i].file != null){
							   html+=`<a target="_blank" href="${ revisions[i].file }" class="text-blue-500 hover:text-blue-700">
								<i data-feather="download" stroke-width="2" class="w-5 h-5"></i>
							</a>`;
					   
						}	
							
                
                    html+=`</td>
                </tr>`;
			}
		}			
		
		$('#revisions-list').html(html);
		feather.replace();
		
	}
	let all_documents = {};
	let current_document_id = 0;
	let package_id = 0;
	get_documents();
	//get_packages();
	function set_package_id(id, text){
		package_id = id;
        //alert('/project/documents/package/'+id);
		//$('#current-doc-package').text(text);
		window.location.href = '/project/documents/package/'+id;
	}



	async function get_documents(page = 1){
		if(localStorage.getItem("project_tool") == 'documents'  || localStorage.getItem("project_tool") == 'activities'){
			if(localStorage.getItem("project_tool") == 'documents'){
				$('#revisions-list').html('');
				const orderBy = $('#order-by').val();
				const orderDirection = $('#order-direction').val();
				const DocNo = $('#searchDocuments').val();
                var package = `{{ $package_detail->id }}`;
				let url = 	`/project/documents/all?package_id=${package}&DocNO=${DocNo}&orderBy=${orderBy}&orderDirection=${orderDirection}`;

				
				let newurl = url.replace('amp;','');
				let fetchRes = await fetch(newurl);
				all_documents = await fetchRes.json();
                var package_name = `{{ $package_detail->name }}`;
				let html = ``;
				if(all_documents.length > 0){
                     document.getElementById('documents_list').classList.remove('hidden');
                     document.getElementById('doc_list').classList.remove('hidden');
					for(let i=0; i<all_documents.length; i++){
						html+=`<div id="doc${i}" class="relative h-36 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md group transition transform hover:scale-105">
							<h3 class="text-sm font-medium dark:text-gray-400 mb-2 truncate">${all_documents[i].title == null ? all_documents[i].number : all_documents[i].title}</h3>

							<span class="flex absolute bottom-10 right-4 text-xs font-semibold text-blue-500 dark:text-blue-300">
								${all_documents[i].created_date}
								{{--
								<a onclick="delete_doc(${i} , ${all_documents[i].id})" href="#" class="text-red-500 dark:text-red-400 hover:text-red-300">
									<i data-feather="trash" class="ms-2 w-5 h-5"></i>
								</a>
								--}}
							</span>
							
								<i data-feather="file-text" class="w-12 h-12 text-gray-400 dark:text-gray-500"></i>
							
							
						
							<span class="absolute bottom-2 right-2 flex items-center text-xs font-semibold bg-blue-900 text-white rounded-full px-2 py-1">
								<i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i>${all_documents[i].revisions_count}
							</span>
							<button onclick="get_revisions(${all_documents[i].id} , '${all_documents[i].number}')" data-modal="revisions-modal"
								class="absolute modal-toggler rounded-full bottom-2 left-2 bg-blue-500 text-white px-3 py-1 text-xs  block lg:hidden group-hover:block transition duration-200"
								aria-label="View Revisions"
							>
								Revisions
							</button>
						</div>`;
					}
				}
				$('#documents_list').html(html);
				feather.replace({ 'stroke-width': 1 });
			}else{
				let url = `project/documents/all_assigned?page=${page}`;

                let fetchRes = await fetch(url);
                const response = await fetchRes.json(); // full paginated response
                const all_docs_assigned= response.data;

				DocsData = all_docs_assigned.map(function(item) {
              
                return item;
                });

                await loadWidgetDocs();
                renderPaginationDocsWidget(response);

			}

		}

	}

    document.addEventListener('DOMContentLoaded', () => {
		reviewers_obj = populateChoices2('reviewers', [], true);
         get_reviewers();
       // accessibles_obj = populateChoices2('accessibles', [], true);

       // assignees_obj = populateChoices2('assignees', [], true);

    });
   

    async  function get_reviewers(){
		let fetchRes = await fetch(`{{url('project/documents/reviewers')}}`);
		const all_users = await fetchRes.json();
		const reviewers = all_users.users.map(function(item) {
		  return {'value' : item.id , 'label' : item.name};
		});
        reviewers.unshift({ value: -1, label: 'All' });

			//console.log(reviewers);
			//doc_reviewers = reviewers;
			reviewers_obj.clearStore();
			reviewers_obj.setChoices(reviewers);

        // const accessibles = all_users.accessibles.map(function(item) {
		//   return {'value' : item.id , 'label' : item.name};
		// });

		// 	accessibles_obj.clearStore();
		// 	accessibles_obj.setChoices(accessibles);

   
	}
	
</script>
@endsection
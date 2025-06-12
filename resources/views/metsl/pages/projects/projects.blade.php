@extends('metsl.layouts.master')

@section('title', 'Companies')

@section('header')
    <div><h1 class="text-xl mb-0">Projects</h1></div>
@endsection

@section('content')
@if(session()->has('success'))
<div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold">
    {{ session()->get('success') }}
</div>
@endif 
<div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold hidden success"></div>
<div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>
    <div class="flex justify-between items-center mb-6">
        <!-- Search Box -->
        <div class="relative flex items-center">
            <input type="text" id="searchBar" placeholder="Search companies..." 
                class=" p-2 pl-10 w-64 dark:bg-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600 focus:outline-none focus:ring focus:border-blue-300" />
            <i data-feather="search" class="absolute left-3"></i>
        </div>

        @if(checkIfUserHasThisPermission(Session::get('projectID') ,'create_projects'))
        <!-- Create Company Button -->
        <a href="{{ route('projects.create') }}" class="inline-flex bg-blue-900 text-white px-3 py-2  hover:bg-blue-600">
        <i data-feather="plus" class="mr-1"></i> Create Project
        </a>
        @endif
    </div>

    <!-- Responsive Grid for Companies -->
    <div id="companyGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
	    @if($projects->count() > 0) 
			@foreach($projects as $project)
			<div class="company-card bg-gray-100 dark:bg-gray-800 dark:text-gray-100 shadow  p-5 flex flex-col">
				<a href="{{ route('projects.edit', ['id' => $project->id]) }}"><img src="{{ $project->logo }}" alt="Company Logo" class="mb-4"></a>
				<a href="{{ route('projects.edit', ['id' => $project->id]) }}"><h3 class="text-lg font-semibold">{{ $project->name }}</h3></a>
				<p class="text-sm text-gray-600 dark:text-gray-300">{!! $project->description !!}</p>




                <a onclick="deleteProject({{ $project->id }} , '{{ $project->name  }}')" href="#" class="text-blue-500 dark:text-blue-400 hover:text-blue-300">
                    <i data-feather="delete" class="w-5 h-5"></i>
                </a>
			</div>

           
			@endforeach
		@endif
        <!-- Company Cards -->
      
	  </div>

    <!-- JavaScript for Filtering -->
    <script>

    async function deleteProject(id , name){
        const confirmed = confirm(`Are you sure you want to delete "${name}"?`);
        if (confirmed) {
            $('.error').hide(); 
            $('.success').hide();
            let url =`/project/destroy/${id}`;		
            let fetchRes = await fetch(url);
            if(fetchRes.status != 200){
                $('.error').show();
                $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+fetchRes.statusText+'</div>');

            }else{
                //console.log(fetchRes);

                $('.success').show();
                $('.success').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold"> Item Deleted Successfully</div>');

                setInterval(function() {
                    window.location.href="{{ url('projects') }}";
                }, 3000);	
            }
        }



    }


        document.getElementById('searchBar').addEventListener('input', function () {
            const searchQuery = this.value.toLowerCase();
            const companyCards = document.querySelectorAll('.company-card');
            
            companyCards.forEach(card => {
                const companyName = card.querySelector('h3').textContent.toLowerCase();
                
                if (companyName.includes(searchQuery)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
@endsection
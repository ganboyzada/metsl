@extends('metsl.layouts.master')

@section('title', 'Companies')

@section('header')
    <div><h1 class="text-xl mb-0">Projects</h1></div>
@endsection

@section('content')
<div class="flex justify-between items-center mb-6">
        <!-- Search Box -->
        <div class="relative flex items-center">
            <input type="text" id="searchBar" placeholder="Search companies..." 
                class=" p-2 pl-10 w-64 dark:bg-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600 focus:outline-none focus:ring focus:border-blue-300" />
            <i data-feather="search" class="absolute left-3"></i>
        </div>

        <!-- Create Company Button -->
        <a href="{{ route('projects.create') }}" class="inline-flex bg-blue-900 text-white px-3 py-2  hover:bg-blue-600">
        <i data-feather="plus" class="mr-1"></i> Create Project
        </a>
    </div>

    <!-- Responsive Grid for Companies -->
    <div id="companyGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
        <!-- Company Cards -->
        <a href="{{ route('projects.find', ['id' => 1]) }}" class="company-card bg-gray-100 dark:bg-gray-800 dark:text-gray-100 shadow  p-5 flex flex-col">
            <img src="https://via.placeholder.com/100" alt="Company Logo" class="mb-4">
            <h3 class="text-lg font-semibold">Alpha Builders</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300">Construction & Engineering</p>
        </a>
        
        <a href="{{ route('projects.find', ['id' => 2]) }}" class="company-card bg-gray-100 dark:bg-gray-800 dark:text-gray-100 shadow  p-5 flex flex-col">
            <img src="https://via.placeholder.com/100" alt="Company Logo" class="mb-4">
            <h3 class="text-lg font-semibold">Skyline Architects</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300">Architectural Design</p>
        </a>
        
        <a href="{{ route('projects.find', ['id' => 3]) }}" class="company-card bg-gray-100 dark:bg-gray-800 dark:text-gray-100 shadow  p-5 flex flex-col">
            <img src="https://via.placeholder.com/100" alt="Company Logo" class="mb-4">
            <h3 class="text-lg font-semibold">GreenEarth Solutions</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300">Environmental Consulting</p>
        </a>
        
        <a href="{{ route('projects.find', ['id' => 4]) }}" class="company-card bg-gray-100 dark:bg-gray-800 dark:text-gray-100 shadow  p-5 flex flex-col">
            <img src="https://via.placeholder.com/100" alt="Company Logo" class="mb-4">
            <h3 class="text-lg font-semibold">Urban Developers</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300">Real Estate Development</p>
        </a>
        
        <a href="{{ route('projects.find', ['id' => 5]) }}" class="company-card bg-gray-100 dark:bg-gray-800 dark:text-gray-100 shadow  p-5 flex flex-col">
            <img src="https://via.placeholder.com/100" alt="Company Logo" class="mb-4">
            <h3 class="text-lg font-semibold">Steelworks Ltd.</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300">Structural Engineering</p>
        </a>
        
        <a href="{{ route('projects.find', ['id' => 6]) }}" class="company-card bg-gray-100 dark:bg-gray-800 dark:text-gray-100 shadow  p-4 flex flex-col">
            <img src="https://via.placeholder.com/100" alt="Company Logo" class="mb-4">
            <h3 class="text-lg font-semibold">SolarRise Energy</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300">Renewable Energy</p>
        </a>
        
        <a href="{{ route('projects.find', ['id' => 7]) }}" class="company-card bg-gray-100 dark:bg-gray-800 dark:text-gray-100 shadow  p-4 flex flex-col">
            <img src="https://via.placeholder.com/100" alt="Company Logo" class="mb-4">
            <h3 class="text-lg font-semibold">Precision Surveyors</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300">Land Surveying</p>
        </a>
        
        <a href="{{ route('projects.find', ['id' => 8]) }}" class="company-card bg-gray-100 dark:bg-gray-800 dark:text-gray-100 shadow  p-4 flex flex-col">
            <img src="https://via.placeholder.com/100" alt="Company Logo" class="mb-4">
            <h3 class="text-lg font-semibold">EcoConstruct</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300">Sustainable Construction</p>
        </a>
    </div>

    <!-- JavaScript for Filtering -->
    <script>
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
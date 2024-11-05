@extends('metsl.layouts.master')

@section('title', 'Companies')

@section('header')
    Companies
@endsection

@section('content')
<div class="flex justify-between items-center mb-6">
        <!-- Search Box -->
        <div class="relative flex items-center">
            <input type="text" id="searchBar" placeholder="Search companies..." 
                class="border border-gray-300 rounded-lg p-2 pl-10 text-sm w-64 focus:outline-none focus:ring focus:border-blue-300" />
            <i class="fas fa-search absolute left-3 text-gray-500"></i>
        </div>

        <!-- Create Company Button -->
        <a href="#" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
            Create Company
        </a>
    </div>

    <!-- Responsive Grid for Companies -->
    <div id="companyGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <!-- Company Cards -->
        <a href="{{ route('company.detail', ['id' => 1]) }}" class="company-card bg-white shadow rounded-lg p-4 flex flex-col items-center">
            <img src="https://via.placeholder.com/100" alt="Company Logo" class="mb-4">
            <h3 class="text-lg font-semibold">Alpha Builders</h3>
            <p class="text-sm text-gray-600">Construction & Engineering</p>
        </a>
        
        <a href="{{ route('company.detail', ['id' => 2]) }}" class="company-card bg-white shadow rounded-lg p-4 flex flex-col items-center">
            <img src="https://via.placeholder.com/100" alt="Company Logo" class="mb-4">
            <h3 class="text-lg font-semibold">Skyline Architects</h3>
            <p class="text-sm text-gray-600">Architectural Design</p>
        </a>
        
        <a href="{{ route('company.detail', ['id' => 3]) }}" class="company-card bg-white shadow rounded-lg p-4 flex flex-col items-center">
            <img src="https://via.placeholder.com/100" alt="Company Logo" class="mb-4">
            <h3 class="text-lg font-semibold">GreenEarth Solutions</h3>
            <p class="text-sm text-gray-600">Environmental Consulting</p>
        </a>
        
        <a href="{{ route('company.detail', ['id' => 4]) }}" class="company-card bg-white shadow rounded-lg p-4 flex flex-col items-center">
            <img src="https://via.placeholder.com/100" alt="Company Logo" class="mb-4">
            <h3 class="text-lg font-semibold">Urban Developers</h3>
            <p class="text-sm text-gray-600">Real Estate Development</p>
        </a>
        
        <a href="{{ route('company.detail', ['id' => 5]) }}" class="company-card bg-white shadow rounded-lg p-4 flex flex-col items-center">
            <img src="https://via.placeholder.com/100" alt="Company Logo" class="mb-4">
            <h3 class="text-lg font-semibold">Steelworks Ltd.</h3>
            <p class="text-sm text-gray-600">Structural Engineering</p>
        </a>
        
        <a href="{{ route('company.detail', ['id' => 6]) }}" class="company-card bg-white shadow rounded-lg p-4 flex flex-col items-center">
            <img src="https://via.placeholder.com/100" alt="Company Logo" class="mb-4">
            <h3 class="text-lg font-semibold">SolarRise Energy</h3>
            <p class="text-sm text-gray-600">Renewable Energy</p>
        </a>
        
        <a href="{{ route('company.detail', ['id' => 7]) }}" class="company-card bg-white shadow rounded-lg p-4 flex flex-col items-center">
            <img src="https://via.placeholder.com/100" alt="Company Logo" class="mb-4">
            <h3 class="text-lg font-semibold">Precision Surveyors</h3>
            <p class="text-sm text-gray-600">Land Surveying</p>
        </a>
        
        <a href="{{ route('company.detail', ['id' => 8]) }}" class="company-card bg-white shadow rounded-lg p-4 flex flex-col items-center">
            <img src="https://via.placeholder.com/100" alt="Company Logo" class="mb-4">
            <h3 class="text-lg font-semibold">EcoConstruct</h3>
            <p class="text-sm text-gray-600">Sustainable Construction</p>
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
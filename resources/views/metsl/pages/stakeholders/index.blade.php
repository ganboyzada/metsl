
    <div class="flex justify-between items-center mb-6">
        <!-- Search Box -->
        <div class="relative flex items-center">
            <input type="text" id="searchStakeholders" placeholder="Search by name..." 
                class=" p-2 pl-10 w-64 dark:bg-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600 focus:outline-none focus:ring focus:border-blue-300" />
            <i data-feather="search" class="absolute left-3"></i>
        </div>

    </div>

    <!-- Responsive Grid for Companies -->
    <div id="stakeholdersGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
	    @if(isset($stakeholders) && $stakeholders->count() > 0) 
			@foreach($stakeholders as $user)
			<div class="company-card bg-gray-100 dark:bg-gray-800 dark:text-gray-100 shadow  p-5 flex flex-col">
				<a href=""><img src="{{ $user->photo }}" alt="user_photo" class="mb-4"></a>
				<a href=""><h3 class="text-lg font-semibold">{{ $user->name }}</h3></a>
				<p class="text-sm text-gray-600 dark:text-gray-300">{{ $user->email }}</p>
                <a href="#" class="text-blue-500 dark:text-blue-400 hover:text-blue-300">
                    <i data-feather="eye" class="w-5 h-5"></i>
                </a>
			</div>
			@endforeach
		@endif
        <!-- Company Cards -->
      
	  </div>

    <!-- JavaScript for Filtering -->
    <script>
        document.getElementById('searchStakeholders').addEventListener('input', function () {
            const searchQuery = this.value.toLowerCase();
            const stakeholderCards = document.querySelectorAll('.stakeholder-card');
            
            stakeholderCards.forEach(card => {
                const stakeholderName = card.querySelector('h3').textContent.toLowerCase();
                
                if (stakeholderName.includes(searchQuery)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>

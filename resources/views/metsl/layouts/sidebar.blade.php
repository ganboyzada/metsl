<aside class="w-64 bg-gray-800 dark:bg-gray-900 text-white flex flex-col">
    <div class="py-4 px-5 w-100">
        <img src="{{ asset('images/logo-light.png') }}" class="object-contain h-10" alt="">
    </div>
    <nav class="flex-1">
        <ul>
            <li class="flex items-center py-3 px-5 hover:bg-gray-700">
                <i class="fas fa-building mr-3 text-gray-400"></i>
                <a href="#" class="text-white">Entities</a>
            </li>
            <li class="flex items-center py-3 px-5 hover:bg-gray-700">
                <i class="fas fa-city mr-3 text-gray-400"></i>
                <a href="{{ route('companies') }}" class="text-white">Companies</a>
            </li>
            <li class="flex items-center py-3 px-5 hover:bg-gray-700">
                <i class="fas fa-cogs mr-3 text-gray-400"></i>
                <a href="#" class="text-white">Settings</a>
            </li>
            <li class="flex items-center py-3 px-5 hover:bg-gray-700">
                <i class="fas fa-file-alt mr-3 text-gray-400"></i>
                <a href="#" class="text-white">Documents</a>
            </li>
        </ul>
    </nav>
</aside>
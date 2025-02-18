<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 pt-[7rem] md:pt-[4rem]">

    <div class="h-screen">
        <!-- Sidebar -->

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            @include('metsl.layouts.header')

            <!-- Content -->
            <main class="relative z-5 px-3 px-md-6 py-6 bg-white dark:bg-gray-900 dark:text-gray-200">
                @yield('content')

                @include('metsl.modals.members')
            </main>
        </div>
    </div>

    <div id="preloader" class="loader-frame">
        <div class="loader"></div>
    </div>
    @stack('js')

</body>
</html>
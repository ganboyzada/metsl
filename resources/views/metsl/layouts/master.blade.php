<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-800">

    <div class="flex h-screen">
        <!-- Sidebar -->

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            @include('metsl.layouts.header')

            <!-- Content -->
            <main class="p-6 bg-white dark:bg-gray-900 dark:text-gray-200">
                @yield('content')

                @include('metsl.modals.members')
            </main>
        </div>
    </div>

    @stack('js')
</body>
</html>
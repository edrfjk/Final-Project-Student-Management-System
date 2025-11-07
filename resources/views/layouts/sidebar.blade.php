<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Management</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex">

    <!-- Sidebar -->
<!-- Sidebar -->
<aside class="w-64 bg-gray-900 text-white min-h-screen flex flex-col overflow-y-auto">
    <div class="p-6 text-2xl font-bold border-b border-gray-700">
        Student Mgmt System
    </div>

    <nav class="flex-1 p-4 space-y-2">
        <!-- Home -->
        <a href="{{ route('students.index') }}" 
           class="block p-2 rounded hover:bg-gray-700 {{ request()->routeIs('students.index') ? 'bg-gray-700' : '' }}">
            🏠 Home
        </a>

        <!-- Students -->
        <a href="{{ route('students.list') }}" 
           class="block p-2 rounded hover:bg-gray-700 {{ request()->routeIs('students.list') ? 'bg-gray-700' : '' }}">
           👩‍🎓 Students
        </a>

        <!-- Classes -->
        <a href="{{ route('classes.list') }}" 
           class="block p-2 rounded hover:bg-gray-700 {{ request()->routeIs('classes.list') ? 'bg-gray-700' : '' }}">
           🏫 Classes
        </a>
    </nav>

    <div class="p-4 border-t border-gray-700 text-center text-sm">
        © 2025 SMS
    </div>
</aside>


    <!-- Main Content -->
    <main class="flex-1 p-8">
        @yield('content')
    </main>
</body>
</html>

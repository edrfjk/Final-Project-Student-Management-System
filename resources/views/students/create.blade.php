@extends('layouts.sidebar')

@section('content')
<div class="max-w-xl mx-auto bg-white shadow-md rounded-xl p-6 mt-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-semibold text-gray-800">Add New Student</h1>
        <a href="{{ route('students.index') }}" 
           class="text-sm text-gray-500 hover:text-blue-600 transition">
            ← Back
        </a>
    </div>

    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <!-- Student Picture -->
        <div>
            <label class="block text-sm text-gray-700 font-medium mb-1">Student Picture</label>
            <input type="file" name="picture" 
                   class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <!-- Name -->
        <div>
            <label class="block text-sm text-gray-700 font-medium mb-1">Full Name</label>
            <input type="text" name="name" 
                   class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" 
                   placeholder="Enter name" required>
        </div>

        <!-- Email -->
        <div>
            <label class="block text-sm text-gray-700 font-medium mb-1">Email</label>
            <input type="email" name="email" 
                   class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" 
                   placeholder="example@email.com" required>
        </div>

        <!-- Address -->
        <div>
            <label class="block text-sm text-gray-700 font-medium mb-1">Address</label>
            <input type="text" name="address" 
                   class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" 
                   placeholder="Enter address">
        </div>

        <!-- Age & Year -->
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-sm text-gray-700 font-medium mb-1">Age</label>
                <input type="number" name="age" 
                       class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" 
                       placeholder="Age">
            </div>

            <div>
                <label class="block text-sm text-gray-700 font-medium mb-1">Year Level</label>
                <select name="year_level" 
                        class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">Select</option>
                    <option value="1">1st Year</option>
                    <option value="2">2nd Year</option>
                    <option value="3">3rd Year</option>
                    <option value="4">4th Year</option>
                </select>
            </div>
        </div>

        <!-- Assign Class -->
        <div>
            <label class="block text-sm text-gray-700 font-medium mb-1">Assign Class</label>
            <select name="class_id" 
                    class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">Select class</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Save Button -->
        <div class="pt-2">
            <button type="submit" 
                    class="w-full bg-blue-600 text-white text-sm font-medium py-2 rounded-md hover:bg-blue-700 transition">
                Save Student
            </button>
        </div>
    </form>
</div>
@endsection

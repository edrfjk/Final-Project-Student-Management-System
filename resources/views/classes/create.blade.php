@extends('layouts.sidebar')

@section('content')
<div class="max-w-xl mx-auto bg-white shadow-md rounded-xl p-6 mt-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-semibold text-gray-800">Add New Class</h1>
        <a href="{{ route('students.index') }}" 
           class="text-sm text-gray-500 hover:text-blue-600 transition">
            ← Back
        </a>
    </div>

    <form action="{{ route('classes.store') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Class Name -->
        <div>
            <label class="block text-sm text-gray-700 font-medium mb-1">Class Name</label>
            <input type="text" name="class_name" 
                   class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" 
                   placeholder="e.g. Web Development" required>
        </div>

        <!-- Class Code -->
        <div>
            <label class="block text-sm text-gray-700 font-medium mb-1">Class Code</label>
            <input type="text" name="class_code" 
                   class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" 
                   placeholder="e.g. IT-101">
        </div>

        <!-- Description -->
        <div>
            <label class="block text-sm text-gray-700 font-medium mb-1">Description</label>
            <textarea name="description" rows="3"
                      class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                      placeholder="Enter a short description about the class..."></textarea>
        </div>

        <!-- Buttons -->
        <div class="flex justify-end gap-2 pt-2">
            <a href="{{ route('students.index') }}" 
               class="bg-gray-500 text-white text-sm px-4 py-2 rounded-md hover:bg-gray-600 transition">
               Cancel
            </a>
            <button type="submit" 
                    class="bg-green-600 text-white text-sm px-4 py-2 rounded-md hover:bg-green-700 transition">
                Save Class
            </button>
        </div>
    </form>
</div>
@endsection

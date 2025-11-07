@extends('layouts.sidebar')

@section('content')
<div class="max-w-xl mx-auto bg-white shadow-md rounded-xl p-6 mt-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-semibold text-gray-800">Edit Student</h1>
        <a href="{{ route('students.index') }}" 
           class="text-sm text-gray-500 hover:text-blue-600 transition">
            ← Back
        </a>
    </div>

    <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <!-- Student Picture -->
        <div>
            <label class="block text-sm text-gray-700 font-medium mb-1">Student Picture</label>
            <div class="flex items-center gap-3">
                @if($student->photo)
                    <img src="{{ asset('storage/'.$student->photo) }}" class="h-12 w-12 rounded-full object-cover border">
                @else
                    <div class="h-12 w-12 bg-gray-300 rounded-full"></div>
                @endif
                <input type="file" name="picture" 
                       class="border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <p class="text-xs text-gray-400 mt-1">Leave blank to keep current picture.</p>
        </div>

        <!-- Name -->
        <div>
            <label class="block text-sm text-gray-700 font-medium mb-1">Full Name</label>
            <input type="text" name="name" value="{{ old('name', $student->name) }}"
                   class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                   required>
        </div>

        <!-- Email -->
        <div>
            <label class="block text-sm text-gray-700 font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $student->email) }}"
                   class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                   required>
        </div>

        <!-- Address -->
        <div>
            <label class="block text-sm text-gray-700 font-medium mb-1">Address</label>
            <input type="text" name="address" value="{{ old('address', $student->address) }}"
                   class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <!-- Age & Year -->
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-sm text-gray-700 font-medium mb-1">Age</label>
                <input type="number" name="age" value="{{ old('age', $student->age) }}"
                       class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-sm text-gray-700 font-medium mb-1">Year Level</label>
                <select name="year_level" 
                        class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">Select</option>
                    @for($i=1; $i<=4; $i++)
                        <option value="{{ $i }}" {{ $student->year_level == $i ? 'selected' : '' }}>
                            {{ $i }}{{ $i==1 ? 'st' : ($i==2 ? 'nd' : ($i==3 ? 'rd' : 'th')) }} Year
                        </option>
                    @endfor
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
                    <option value="{{ $class->id }}" {{ $student->classes->contains($class->id) ? 'selected' : '' }}>
                        {{ $class->class_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Save Button -->
        <div class="pt-2 flex justify-end gap-2">
            <a href="{{ route('students.index') }}" 
               class="bg-gray-400 text-white text-sm font-medium py-2 px-4 rounded-md hover:bg-gray-500 transition">
                Cancel
            </a>
            <button type="submit" 
                    class="bg-blue-600 text-white text-sm font-medium py-2 px-4 rounded-md hover:bg-blue-700 transition">
                Update Student
            </button>
        </div>
    </form>
</div>
@endsection

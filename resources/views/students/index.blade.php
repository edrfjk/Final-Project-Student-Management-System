@extends('layouts.sidebar')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-semibold text-gray-800">Students</h1>
    <div class="flex gap-2">
        <a href="{{ route('students.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm">Add Student</a>
        <a href="{{ route('classes.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 text-sm">Add Class</a>
    </div>
</div>

<form method="GET" class="flex flex-wrap gap-3 mb-6">
    <input type="text" name="search" placeholder="Search by name" value="{{ request('search') }}" 
        class="border border-gray-300 px-3 py-2 rounded-md text-sm w-1/4">
    
    <select name="year_level" class="border border-gray-300 px-3 py-2 rounded-md text-sm">
        <option value="">All Year Levels</option>
        @for($i=1; $i<=4; $i++)
            <option value="{{ $i }}" {{ request('year_level')==$i?'selected':'' }}>Year {{ $i }}</option>
        @endfor
    </select>

    <select name="class" class="border border-gray-300 px-3 py-2 rounded-md text-sm">
        <option value="">All Classes</option>
        @foreach($classes as $c)
            <option value="{{ $c->id }}" {{ request('class')==$c->id?'selected':'' }}>{{ $c->class_name }}</option>
        @endforeach
    </select>

    <button class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm hover:bg-gray-900">Filter</button>
</form>

<div class="overflow-x-auto bg-white shadow-md rounded-lg">
    <table class="min-w-full text-sm text-left border-collapse">
        <thead class="bg-gray-100 border-b text-gray-700">
            <tr>
                <th class="p-3 text-center w-20">Photo</th>
                <th class="p-3">Name</th>
                <th class="p-3">Email</th>
                <th class="p-3 text-center w-24">Year</th>
                <th class="p-3 w-52">Assigned Classes</th>
                <th class="p-3 text-center w-48">Assign Class</th>
                <th class="p-3 text-center w-32">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
            <tr class="border-t hover:bg-gray-50">
                <td class="p-3 text-center">
                    @if($student->photo)
        <img src="{{ asset('storage/' . $student->photo) }}" 
             alt="Student Photo" 
             class="h-10 w-10 rounded-full object-cover mx-auto">
    @else
        <div class="h-10 w-10 bg-gray-300 rounded-full mx-auto flex items-center justify-center text-gray-500 text-xs">
            N/A
        </div>
    @endif
                </td>
                <td class="p-3 font-medium text-gray-800">{{ $student->name }}</td>
                <td class="p-3 text-gray-600">{{ $student->email }}</td>
                <td class="p-3 text-center">{{ $student->year_level }}</td>

                <!-- Assigned Classes -->
                <td class="p-3">
@forelse($student->classes as $class)
        <form action="{{ route('students.removeClass', [$student->id, $class->id]) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <span class="text-sm bg-green-100 text-green-800 px-2 py-1 rounded inline-flex items-center">
                {{ $class->class_name }}
                <button type="submit" class="ml-1 text-red-500 hover:text-red-700 font-bold">&times;</button>
            </span>
        </form>
    @empty
        <span class="text-gray-400 text-sm">No class assigned</span>
    @endforelse
                </td>

                <!-- Assign Form -->
                <td class="p-3 text-center">
                    <form action="{{ route('students.assignClass', $student->id) }}" method="POST" class="flex items-center justify-center gap-1">
                        @csrf
                        <select name="class_id" class="border border-gray-300 rounded-md text-xs px-2 py-1">
                            <option value="">Select</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-blue-500 text-white text-xs px-3 py-1 rounded-md hover:bg-blue-600 transition">Assign</button>
                    </form>
                </td>

                <!-- Actions -->
                <td class="p-3 text-center">
                    <div class="flex justify-center gap-2">
                        <a href="{{ route('students.edit', $student) }}" 
                           class="bg-yellow-500 text-white text-xs px-3 py-1 rounded-md hover:bg-yellow-600 transition">Edit</a>
                        <form action="{{ route('students.destroy', $student) }}" method="POST" onsubmit="return confirm('Delete this student?')">
                            @csrf @method('DELETE')
                            <button class="bg-red-500 text-white text-xs px-3 py-1 rounded-md hover:bg-red-600 transition">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $students->links() }}
</div>
@endsection

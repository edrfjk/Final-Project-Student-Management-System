<div>
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Students</h1>
        <div class="flex gap-2">
            <a href="{{ route('students.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">Add Student</a>
            <a href="{{ route('classes.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">Add Class</a>
        </div>
    </div>

    <!-- Filters -->
    <div class="flex gap-3 mb-6">
        <input wire:model="search" type="text" placeholder="Search by name" class="border px-3 py-2 rounded w-1/4">
        <select wire:model="year_level" class="border px-3 py-2 rounded">
            <option value="">All Year Levels</option>
            @for($i=1; $i<=4; $i++)
                <option value="{{ $i }}">Year {{ $i }}</option>
            @endfor
        </select>
        <select wire:model="class_id" class="border px-3 py-2 rounded">
            <option value="">All Classes</option>
            @foreach($classes as $class)
                <option value="{{ $class->id }}">{{ $class->class_name }}</option>
            @endforeach
        </select>

        <!-- Search button -->
        <button wire:click="applyFilters" class="bg-blue-500 text-white px-3 py-1 rounded">Search</button>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full text-sm text-left border-collapse">
            <thead class="bg-gray-100 border-b text-gray-700">
                <tr>
                    <th class="p-3 text-center w-20">Photo</th>
                    <th class="p-3">Name</th>
                    <th class="p-3">Email</th>
                    <th class="p-3 text-center w-24">Year</th>
                    <th class="p-3 w-52">Classes</th>
                    <th class="p-3 w-48 text-center">Assign Class</th>
                    <th class="p-3 w-32 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3 text-center">
                        @if($student->photo)
                            <img src="{{ asset('storage/'.$student->photo) }}" class="h-10 w-10 rounded-full mx-auto object-cover">
                        @else
                            <div class="h-10 w-10 bg-gray-300 rounded-full flex items-center justify-center mx-auto text-gray-500">N/A</div>
                        @endif
                    </td>
                    <td class="p-3 font-medium">{{ $student->name }}</td>
                    <td class="p-3">{{ $student->email }}</td>
                    <td class="p-3 text-center">{{ $student->year_level }}</td>
                    <td class="p-3">
                        @foreach($student->classes as $class)
                            <span class="inline-flex items-center bg-green-100 text-green-800 px-2 py-1 rounded text-sm mr-1">
                                {{ $class->class_name }}
                                <button wire:click="removeClass({{ $student->id }}, {{ $class->id }})" class="ml-1 text-red-500 hover:text-red-700">×</button>
                            </span>
                        @endforeach
                    </td>
                    <td class="p-3 text-center">
                        <select wire:model="selected_class.{{ $student->id }}" class="border px-2 py-1 rounded text-xs mb-1">
                            <option value="">Select</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                            @endforeach
                        </select>
                        <button wire:click="assignClass({{ $student->id }})" class="bg-blue-500 text-white text-xs px-3 py-1 rounded">Assign</button>
                    </td>
                    <td class="p-3 text-center">
                        <button wire:click="deleteStudent({{ $student->id }})" onclick="return confirm('Delete this student?')" class="bg-red-500 text-white text-xs px-3 py-1 rounded">Delete</button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center p-4 text-gray-500">No students found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $students->links() }}
    </div>
</div>

@extends('layouts.sidebar')

@section('content')
<h1 class="text-2xl font-semibold text-gray-800 mb-6">🏫 Classes Overview & Reports</h1>

<!-- Summary Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-500 text-sm">Total Classes</p>
        <p class="text-2xl font-bold text-green-600">{{ $totalClasses }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-500 text-sm">Total Students Enrolled</p>
        <p class="text-2xl font-bold text-blue-600">{{ $totalStudents }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-500 text-sm">Most Populated Class</p>
        <p class="text-2xl font-bold text-purple-600">{{ $topClass ?? 'N/A' }}</p>
    </div>
</div>

<!-- Classes Table -->
<div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
    <table class="min-w-full text-sm text-left border-collapse">
        <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="p-3">Class Name</th>
                <th class="p-3">Class Code</th>
                <th class="p-3 text-center">Students Enrolled</th>
                <th class="p-3 text-center">Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($classes as $class)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3 font-medium text-gray-800">{{ $class->class_name }}</td>
                    <td class="p-3 text-gray-600">{{ $class->class_code ?? '—' }}</td>
                    <td class="p-3 text-center">{{ $class->students_count ?? 0 }}</td>
                    <td class="p-3 text-gray-600 text-sm">{{ $class->description ?? 'No description' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Chart -->
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">📈 Students per Class</h2>
    <canvas id="studentsPerClassChart" class="max-h-[300px]"></canvas>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('studentsPerClassChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($classNames) !!},
            datasets: [{
                label: 'Number of Students',
                data: {!! json_encode($classCounts) !!},
                backgroundColor: 'rgba(37, 99, 235, 0.6)',
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection

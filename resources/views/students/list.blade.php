@extends('layouts.sidebar')

@section('content')
<h1 class="text-xl font-semibold text-gray-800 mb-4">📊 Student Reports Dashboard</h1>

<!-- Summary Cards -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-500 text-xs">Total Students</p>
        <p class="text-2xl font-bold text-blue-600">{{ $totalStudents }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-500 text-xs">Total Classes</p>
        <p class="text-2xl font-bold text-green-600">{{ $totalClasses }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-500 text-xs">Average Age</p>
        <p class="text-2xl font-bold text-yellow-500">{{ $averageAge ?? 'N/A' }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow text-center">
        <p class="text-gray-500 text-xs">Top Year</p>
        <p class="text-2xl font-bold text-purple-600">{{ $topYear ?? 'N/A' }}</p>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <!-- Bar Chart -->
    <div class="bg-white p-4 rounded-lg shadow flex flex-col items-center">
        <h2 class="text-sm font-semibold text-gray-800 mb-3">Students per Year Level</h2>
        <div class="relative w-full max-w-[350px] h-[220px]">
            <canvas id="studentsYearChart"></canvas>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="bg-white p-4 rounded-lg shadow flex flex-col items-center">
        <h2 class="text-sm font-semibold text-gray-800 mb-3">Top 5 Most Populated Classes</h2>
        <div class="relative w-full max-w-[300px] h-[220px]">
            <canvas id="topClassesChart"></canvas>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const yearCtx = document.getElementById('studentsYearChart').getContext('2d');
    new Chart(yearCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($yearLabels) !!},
            datasets: [{
                label: 'Students',
                data: {!! json_encode($yearCounts) !!},
                backgroundColor: 'rgba(37,99,235,0.7)',
                borderRadius: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: true }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { font: { size: 10 } },
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: {
                    ticks: { font: { size: 10 } },
                    grid: { display: false }
                }
            }
        }
    });

    const classCtx = document.getElementById('topClassesChart').getContext('2d');
    new Chart(classCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($topClassNames) !!},
            datasets: [{
                data: {!! json_encode($topClassCounts) !!},
                backgroundColor: [
                    '#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { boxWidth: 10, font: { size: 9 } }
                }
            }
        }
    });
</script>
@endsection

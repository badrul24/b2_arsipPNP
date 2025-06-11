@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="stat-card">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-gray-500 text-sm font-medium">Total Documents</h3>
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-2 rounded-xl shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline">
                <h2 class="text-4xl font-bold text-gray-800">1,284</h2>
                <span class="ml-2 text-green-500 text-sm font-medium flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                    <span>12%</span>
                </span>
            </div>
            <p class="text-gray-500 text-sm mt-1">From last month</p>
            <div class="mt-4 h-1 w-full bg-gray-200 rounded-full overflow-hidden">
                <div class="bg-blue-500 h-full rounded-full" style="width: 75%"></div>
            </div>
        </div>

        <!-- Stat cards lainnya ... -->
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Document Statistics</h2>
            <div class="h-80">
                <canvas id="documentsChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Storage Usage</h2>
            <div class="h-80">
                <canvas id="storageChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Documents -->
    <h2 class="text-xl font-bold text-gray-800 mb-6">Recent Documents</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Document cards ... -->
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <!-- Document Categories ... -->
        </div>

        <div>
            <!-- Recent Activity ... -->
        </div>
    </div>
@endsection

@section('additional-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Documents Chart
            const documentsCtx = document.getElementById('documentsChart').getContext('2d');
            const documentsChart = new Chart(documentsCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Uploaded Documents',
                        data: [65, 78, 90, 105, 125, 138],
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                borderDash: [2, 4],
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Storage Chart
            const storageCtx = document.getElementById('storageChart').getContext('2d');
            const storageChart = new Chart(storageCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Reports', 'Finance', 'Meetings', 'Projects', 'Miscellaneous'],
                    datasets: [{
                        data: [425, 310, 275, 189, 85],
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(16, 185, 129, 0.8)',
                            'rgba(139, 92, 246, 0.8)',
                            'rgba(239, 68, 68, 0.8)',
                            'rgba(245, 158, 11, 0.8)'
                        ],
                        borderColor: [
                            'rgba(59, 130, 246, 1)',
                            'rgba(16, 185, 129, 1)',
                            'rgba(139, 92, 246, 1)',
                            'rgba(239, 68, 68, 1)',
                            'rgba(245, 158, 11, 1)'
                        ],
                        borderWidth: 1,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection

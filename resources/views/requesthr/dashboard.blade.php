@extends('layouts.hrrequest.app')
@section('content')
<div class="max-w-8xl mx-auto px-4 py-4 font-prompt">
    <div class="breadcrumbs text-sm">
        <ul>
            <li><a href="{{ route('welcome') }}">Home</a></li>
            <li><a href="{{ route('request.hr') }}">Request HR</a></li>
            <li>
                <a class="font-semibold text-gray-800 dark:text-red-500">
                    Request HR Dashboard
                </a>
            </li>
        </ul>
    </div>
    <div class="border border-gray-300/60 dark:border-gray-200/40 rounded-lg shadow-xl">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <div class="py-4">
            <div class="max-w-8xl mx-auto px-4">
                <div class="overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-4">

                            <div
                                class="card bg-base-100 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-300/40">
                                <div class="card-body p-6 flex flex-row items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 mb-1">จำนวนคำขอทั้งหมด</p>
                                        <h2 id="totalRequests" class="text-3xl font-bold text-gray-800 dark:text-white">
                                            {{ $totalRequests ?? 0 }}
                                        </h2>
                                        <p class="text-xs text-gray-400 mt-1">รายการ</p>
                                    </div>
                                    <div class="p-3 bg-blue-50 rounded-full text-blue-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="h-1 w-full bg-blue-500 rounded-b-2xl"></div>
                            </div>

                            <div
                                class="card bg-base-100 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-300/40">
                                <div class="card-body p-6 flex flex-row items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 mb-1">ดำเนินการเสร็จสิ้น</p>
                                        <h2 class="text-3xl font-bold text-green-600">
                                            {{ $statusCompleted ?? 0 }}
                                        </h2>
                                        <p class="text-xs text-gray-400 mt-1">อนุมัติเรียบร้อย</p>
                                    </div>
                                    <div class="p-3 bg-green-50 rounded-full text-green-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="h-1 w-full bg-green-500 rounded-b-2xl"></div>
                            </div>

                            <div
                                class="card bg-base-100 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-300/40">
                                <div class="card-body p-6 flex flex-row items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 mb-1">อยู่ระหว่างดำเนินการ</p>
                                        <h2 class="text-3xl font-bold text-orange-500">
                                            {{ $statusPending + $statusAPPROVEDHR ?? 0 }}

                                        </h2>
                                        <p class="text-xs text-gray-400 mt-1">รอการตรวจสอบ</p>
                                    </div>
                                    <div class="p-3 bg-orange-50 rounded-full text-orange-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="h-1 w-full bg-orange-500 rounded-b-2xl"></div>
                            </div>

                            <div
                                class="card bg-base-100 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-300/40">
                                <div class="card-body p-6 flex flex-row items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 mb-1">ปฏิเสธ/ยกเลิก</p>
                                        <h2 class="text-3xl font-bold text-red-500">{{ $statusCancelled ?? 0 }}</h2>
                                        <p class="text-xs text-gray-400 mt-1">ถูกตีกลับหรือยกเลิก</p>
                                    </div>
                                    <div class="p-3 bg-red-50 rounded-full text-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="h-1 w-full bg-red-500 rounded-b-2xl"></div>
                            </div>

                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="p-4 rounded-lg shadow-sm dark:bg-gray-800 border border-gray-300/60">
                                <h3 class="text-lg font-semibold mb-2 text-center text-gray-800 dark:text-white">
                                    คำร้องตามสถานะ
                                </h3>
                                <div class="relative h-64 w-full">
                                    <canvas id="statusChart"></canvas>
                                </div>
                            </div>

                            <div class="p-4 rounded-lg shadow-sm dark:bg-gray-800 border border-gray-300/60">
                                <h3 class="text-lg font-semibold mb-2 text-center text-gray-800 dark:text-white">
                                    คำร้องตามสายงาน
                                </h3>
                                <div class="relative h-64 w-full">
                                    <canvas id="divisionChart"></canvas>
                                </div>
                            </div>

                            <div class="p-4 rounded-lg shadow-sm dark:bg-gray-800 border border-gray-300/60">
                                <h3 class="text-lg font-semibold mb-2 text-center text-gray-800 dark:text-white">
                                    คำร้องตามหมวดหมู่
                                </h3>
                                <div class="relative h-64 w-full">
                                    <canvas id="categoryChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="p-4 rounded-lg shadow-sm dark:bg-gray-800 border border-gray-300/60">
                                <h3 class="text-lg font-semibold mb-2 text-center text-gray-800 dark:text-white">
                                    คำร้องตามแผนก
                                </h3>
                                <div class="relative h-64 w-full">
                                    <canvas id="departmentChart"></canvas>
                                </div>
                            </div>
                            <div class="p-4 rounded-lg shadow-sm dark:bg-gray-800 border border-gray-300/60">
                                <h3 class="text-lg font-semibold mb-2 text-center text-gray-800 dark:text-white">
                                    แนวโน้มคำร้องรายเดือน
                                </h3>
                                <div class="relative h-72 w-full ">
                                    <canvas id="monthlyTrendChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data from Laravel Controller
        const statusLabels = @json($statusLabels ?? []);
        const statusCounts = @json($statusCounts ?? []);
        const divisionLabels = @json($divisionLabels ?? []);
        const divisionCounts = @json($divisionCounts ?? []);
        const categoryLabels = @json($categoryLabels ?? []);
        const categoryCounts = @json($categoryCounts ?? []);
        const departmentLabels = @json($departmentLabels ?? []);
        const departmentCounts = @json($departmentCounts ?? []);
        const monthlyLabels = @json($monthlyLabels ?? []);
        const monthlyCounts = @json($monthlyCounts ?? []);

        const isDarkMode = document.documentElement.classList.contains('dark');
        const textColor = isDarkMode ? 'white' : '#1f2937';

        // --- Chart Color Mapping ---
        const colorMap = {
            'รอตรวจสอบโดยผู้จัดการ': '#f97316', // Orange
            'รออนุมัติโดยผู้จัดการ': '#f59e0b', // Amber
            'รอตรวจสอบโดยฝ่ายบุคคล': '#3b82f6', // Blue
            'ถูกปฏิเสธ': '#ef4444', // Red
            'ยกเลิก': '#ef4444', // Gray
            'ดำเนินการเสร็จสิ้น': '#22c55e', // Green
            'ส่งกลับแก้ไข': '#8b5cf6', // Violet
        };
        const chartBackgroundColors = statusLabels.map(label => colorMap[label] || '#a8a29e'); // Fallback to neutral

        // 1. Status Chart (Pie Chart)
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'pie',
            data: {
                labels: statusLabels,
                datasets: [{
                    label: 'Requests by Status',
                    data: statusCounts,
                    backgroundColor: chartBackgroundColors,
                    borderWidth: 0.5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: textColor
                        }
                    }
                }
            }
        });

        // 2. Division Chart (Bar Chart)
        const divisionCtx = document.getElementById('divisionChart').getContext('2d');
        new Chart(divisionCtx, {
            type: 'bar',
            data: {
                labels: divisionLabels,
                datasets: [{
                    label: 'Requests by Division',
                    data: divisionCounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: textColor
                        }
                    },
                    x: {
                        ticks: {
                            color: textColor
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: textColor
                        }
                    }
                }
            }
        });

        // 3. Category Chart (Doughnut Chart)
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: categoryLabels,
                datasets: [{
                    label: 'Requests by Category',
                    data: categoryCounts,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: textColor
                        }
                    }
                }
            }
        });

        // 4. Department Chart (Horizontal Bar Chart)
        const departmentCtx = document.getElementById('departmentChart').getContext('2d');
        new Chart(departmentCtx, {
            type: 'bar',
            data: {
                labels: departmentLabels,
                datasets: [{
                    label: 'Requests by Department',
                    data: departmentCounts,
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            color: textColor
                        }
                    },
                    y: {
                        ticks: {
                            color: textColor
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: textColor
                        }
                    }
                }
            }
        });

        // 5. Monthly Trend Chart (Line Chart)
        const monthlyTrendCtx = document.getElementById('monthlyTrendChart').getContext('2d');
        new Chart(monthlyTrendCtx, {
            type: 'line',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    label: 'Monthly Requests',
                    data: monthlyCounts,
                    borderColor: 'rgba(153, 102, 255, 1)',
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: textColor
                        }
                    },
                    x: {
                        ticks: {
                            color: textColor
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: textColor
                        }
                    }
                }
            }
        });
    });
</script>
@endsection

@extends('layouts.training.app')

@section('content')
    @php
        $maxCount = count($data) > 0 ? max($data) : 0;
        $popularCourses = [];
        if ($maxCount > 0) {
            foreach ($data as $index => $val) {
                if ($val == $maxCount) {
                    $popularCourses[] = $labels[$index];
                }
            }
        }
        $popularCourseText = count($popularCourses) > 0 ? implode(', ', $popularCourses) : 'ยังไม่มีข้อมูล';
    @endphp

    <div
        class="min-h-screen p-6 pt-8 pb-20 bg-slate-50 dark:bg-[#0f1117] text-slate-800 dark:text-gray-200 selection:bg-red-500/30">
        <div class="max-w-8xl mx-auto px-4 mb-4">
            <!-- Breadcrumbs -->
            <div class="flex items-center text-sm space-x-2">
                <a href="{{ route('welcome') }}"
                    class="text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors">Home</a>
                <i class="fas fa-chevron-right text-[10px] text-gray-500"></i>
                <a href="{{ route('training.index') }}"
                    class="text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors">ลงทะเบียน</a>
                <i class="fas fa-chevron-right text-[10px] text-gray-500"></i>
                <span class="text-red-500 font-medium tracking-tight">Dashboard</span>
            </div>
        </div>

        <div class="max-w-7xl mx-auto space-y-8">
            <!-- Top Navigation & Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1
                        class="text-3xl md:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-slate-900 to-slate-500 dark:from-white dark:to-slate-400 tracking-tight">
                        รายงานความสนใจฝึกอบรม
                    </h1>
                    <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm md:text-base">
                        ภาพรวมและสถิติการสมัครเข้าร่วมกิจกรรมการฝึกอบรมทั้งหมด
                    </p>
                </div>

                <a href="{{ route('training.index') }}"
                    class="group inline-flex items-center justify-center gap-2 bg-white dark:bg-[#1E2129] hover:bg-slate-50 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-700/60 text-slate-700 dark:text-slate-300 font-medium py-2.5 px-5 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 w-full md:w-auto">
                    <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                    กลับหน้ารายการ
                </a>
            </div>

            <!-- Filter Bar -->
            <div
                class="bg-white dark:bg-[#1E2129] rounded-3xl p-6 shadow-sm border border-slate-100 dark:border-slate-800/60 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                <form action="{{ route('training.dashboard') }}" method="GET" class="flex flex-col lg:flex-row gap-4">
                    <!-- Search Filter -->
                    <div class="flex-1 relative group">
                        <div
                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-red-500 transition-colors">
                            <i class="fa-solid fa-magnifying-glass text-sm"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="ค้นหาชื่อหลักสูตร..."
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-[#15171e] border-none rounded-2xl text-sm focus:ring-2 focus:ring-red-500/20 dark:text-white transition-all placeholder:text-slate-400">
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <!-- Year Filter -->
                        <div class="min-w-[120px]">
                            <select name="year"
                                class="w-full px-4 py-3 bg-slate-50 dark:bg-[#15171e] border-none rounded-2xl text-sm focus:ring-2 focus:ring-red-500/20 dark:text-white transition-all appearance-none cursor-pointer">
                                <option value="">ทุกปี</option>
                                @foreach($years as $year)
                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>ปี
                                        {{ $year + 543 }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Month Filter -->
                        <div class="min-w-[140px]">
                            <select name="month"
                                class="w-full px-4 py-3 bg-slate-50 dark:bg-[#15171e] border-none rounded-2xl text-sm focus:ring-2 focus:ring-red-500/20 dark:text-white transition-all appearance-none cursor-pointer">
                                <option value="">ทุกเดือน</option>
                                @php
                                    $months = [
                                        1 => 'มกราคม',
                                        2 => 'กุมภาพันธ์',
                                        3 => 'มีนาคม',
                                        4 => 'เมษายน',
                                        5 => 'พฤษภาคม',
                                        6 => 'มิถุนายน',
                                        7 => 'กรกฎาคม',
                                        8 => 'สิงหาคม',
                                        9 => 'กันยายน',
                                        10 => 'ตุลาคม',
                                        11 => 'พฤศจิกายน',
                                        12 => 'ธันวาคม'
                                    ];
                                @endphp
                                @foreach($months as $num => $name)
                                    <option value="{{ $num }}" {{ request('month') == $num ? 'selected' : '' }}>{{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Day Filter -->
                        <div class="min-w-[100px]">
                            <select name="day"
                                class="w-full px-4 py-3 bg-slate-50 dark:bg-[#15171e] border-none rounded-2xl text-sm focus:ring-2 focus:ring-red-500/20 dark:text-white transition-all appearance-none cursor-pointer">
                                <option value="">ทุกวัน</option>
                                @for($i = 1; $i <= 31; $i++)
                                    <option value="{{ $i }}" {{ request('day') == $i ? 'selected' : '' }}>วันที่ {{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <!-- Reset & Submit Button -->
                        <div class="flex items-center gap-2 pl-2">
                            @if(request()->anyFilled(['search', 'year', 'month', 'day']))
                                <a href="{{ route('training.dashboard') }}"
                                    class="p-3 text-slate-400 hover:text-red-500 transition-colors" title="ล้างตัวกรอง">
                                    <i class="fa-solid fa-rotate-right"></i>
                                </a>
                            @endif
                            <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-2xl shadow-lg shadow-red-500/20 transition-all active:scale-95">
                                ค้นหา
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Stats/Summary Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1 -->
                <div
                    class="bg-white dark:bg-[#1E2129] rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.2)] border border-slate-100 dark:border-slate-800/60 hover:-translate-y-1 hover:shadow-lg hover:shadow-blue-500/10 transition-all duration-300 relative overflow-hidden group">
                    <div
                        class="absolute -right-6 -top-6 w-24 h-24 bg-blue-500/5 dark:bg-blue-500/10 rounded-full group-hover:scale-150 transition-transform duration-500">
                    </div>
                    <div class="flex items-center gap-4 relative z-10">
                        <div
                            class="flex-shrink-0 w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-500/30 text-white">
                            <i class="fa-solid fa-book-open border-2 border-white/20 p-2 rounded-xl text-xl"></i>
                        </div>
                        <div>
                            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium mb-1">หลักสูตรทั้งหมด</p>
                            <div class="flex items-baseline gap-2">
                                <span
                                    class="text-3xl font-extrabold text-slate-800 dark:text-white tracking-tight">{{ number_format($totalCourses) }}</span>
                                <span class="text-xs text-slate-400 font-medium uppercase tracking-wider">หลักสูตร</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div
                    class="bg-white dark:bg-[#1E2129] rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.2)] border border-slate-100 dark:border-slate-800/60 hover:-translate-y-1 hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300 relative overflow-hidden group">
                    <div
                        class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-500/5 dark:bg-emerald-500/10 rounded-full group-hover:scale-150 transition-transform duration-500">
                    </div>
                    <div class="flex items-center gap-4 relative z-10">
                        <div
                            class="flex-shrink-0 w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/30 text-white">
                            <i class="fa-solid fa-users border-2 border-white/20 p-2 rounded-xl text-xl"></i>
                        </div>
                        <div>
                            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium mb-1">ผู้สนใจสมัครรวม</p>
                            <div class="flex items-baseline gap-2">
                                <span
                                    class="text-3xl font-extrabold text-slate-800 dark:text-white tracking-tight">{{ number_format($totalApplies) }}</span>
                                <span class="text-xs text-slate-400 font-medium uppercase tracking-wider">คน</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div
                    class="bg-white dark:bg-[#1E2129] rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.2)] border border-slate-100 dark:border-slate-800/60 hover:-translate-y-1 hover:shadow-lg hover:shadow-amber-500/10 transition-all duration-300 relative overflow-hidden group">
                    <div
                        class="absolute -right-6 -top-6 w-24 h-24 bg-amber-500/5 dark:bg-amber-500/10 rounded-full group-hover:scale-150 transition-transform duration-500">
                    </div>
                    <div class="flex items-center gap-4 relative z-10">
                        <div
                            class="flex-shrink-0 w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-lg shadow-amber-500/30 text-white">
                            <i class="fa-solid fa-chart-pie border-2 border-white/20 p-2 rounded-xl text-xl"></i>
                        </div>
                        <div>
                            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium mb-1">เฉลี่ยต่อหลักสูตร</p>
                            <div class="flex items-baseline gap-2">
                                <span class="text-3xl font-extrabold text-slate-800 dark:text-white tracking-tight">
                                    {{ $avgApplies }}
                                </span>
                                <span class="text-xs text-slate-400 font-medium uppercase tracking-wider">/หลักสูตร</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 4 (Most Popular) -->
                <div
                    class="bg-gradient-to-br from-rose-500 via-red-500 to-red-600 rounded-3xl p-6 shadow-lg shadow-red-500/30 border border-red-400/50 hover:-translate-y-1 hover:shadow-xl hover:shadow-red-500/40 transition-all duration-300 relative overflow-hidden group text-white">
                    <div
                        class="absolute -right-6 -top-6 w-32 h-32 bg-white/10 rounded-full group-hover:scale-150 transition-transform duration-700">
                    </div>
                    <div
                        class="absolute -left-6 -bottom-6 w-24 h-24 bg-black/10 rounded-full group-hover:scale-150 transition-transform duration-500">
                    </div>
                    <div class="flex flex-col h-full justify-between relative z-10">
                        <div class="flex justify-between items-start mb-2">
                            <p class="text-red-100 text-sm font-medium tracking-wide flex items-center gap-1.5"><i
                                    class="fa-solid fa-fire text-yellow-300"></i> สนใจมากที่สุด</p>
                            @if($totalApplies > 0 && $popularCourseName != '-')
                                <div
                                    class="bg-white/20 backdrop-blur-sm rounded-full px-3 py-1 flex items-center gap-1.5 text-xs font-semibold shadow-sm border border-white/10">
                                    <span>{{ $trainings->sortByDesc('applies_count')->first()->applies_count ?? 0 }}</span> คน
                                </div>
                            @endif
                        </div>
                        <div class="mt-auto pt-2">
                            <h4 class="text-lg font-bold leading-snug line-clamp-2 drop-shadow-sm"
                                title="{{ $popularCourseName }}">
                                {{ $popularCourseName }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Bar Chart -->
                <div
                    class="lg:col-span-2 bg-white dark:bg-[#1E2129] rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.2)] border border-slate-100 dark:border-slate-800/60 p-6 md:p-8 relative overflow-hidden transition-all duration-300 flex flex-col">
                    <div
                        class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 pb-4 border-b border-slate-100 dark:border-slate-800">
                        <div>
                            <h3 class="text-xl font-bold text-slate-800 dark:text-white flex items-center gap-3">
                                <span
                                    class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-500/10 text-blue-500 flex items-center justify-center">
                                    <i class="fa-solid fa-chart-line"></i>
                                </span>
                                สถิติความสนใจรายหลักสูตร
                            </h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 sm:ml-11">
                                กราฟแสดงจำนวนผู้ที่สนใจสมัครเข้าร่วมในแต่ละหลักสูตรอบรม</p>
                        </div>
                    </div>

                    <!-- Chart Container -->
                    <div id="trainingAnalyticsChart"
                        class="w-full h-[400px] flex-grow {{ $totalApplies > 0 ? '' : 'hidden' }}"></div>
                    @if($totalApplies == 0)
                        <div class="flex-grow flex flex-col items-center justify-center p-10 text-slate-400">
                            <i class="fa-solid fa-chart-column text-5xl mb-4 opacity-20"></i>
                            <p class="text-lg font-medium">ไม่พบข้อมูลสถิติ</p>
                            <p class="text-sm">กรุณาเลือกตัวกรองอื่น หรือยังไม่มีการสมัครในช่วงเวลานี้</p>
                        </div>
                    @endif
                </div>

                <!-- Bar Chart Comparison (was Donut) -->
                <div
                    class="bg-white dark:bg-[#1E2129] rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.2)] border border-slate-100 dark:border-slate-800/60 p-6 relative overflow-hidden transition-all duration-300 flex flex-col">
                    <div class="mb-4 pb-4 border-b border-slate-100 dark:border-slate-800">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white flex items-center gap-3">
                            <span
                                class="w-8 h-8 rounded-lg bg-amber-50 dark:bg-amber-500/10 text-amber-500 flex items-center justify-center">
                                <i class="fa-solid fa-chart-bar"></i>
                            </span>
                            เปรียบเทียบความสนใจ
                        </h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 sm:ml-11">
                            จำนวนผู้สมัครในแต่ละหลักสูตร</p>
                    </div>

                    <!-- Chart Container -->
                    <div id="trainingDonutChart"
                        class="w-full flex-grow flex items-center justify-center mt-4 {{ $totalApplies > 0 ? '' : 'hidden' }}">
                    </div>
                    @if($totalApplies == 0)
                        <div class="flex-grow flex flex-col items-center justify-center p-10 text-slate-400">
                            <i class="fa-solid fa-chart-pie text-5xl mb-4 opacity-20"></i>
                            <p class="text-lg font-medium">ไม่มีข้อมูลความสนใจ</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <!-- Require ApexCharts via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const labels = @json($labels);
            const dataCounts = @json($data);

            if (dataCounts.length === 0) {
                console.log("No data to display on charts");
                return;
            }

            const isDarkMode = document.documentElement.classList.contains('dark');
            const textColor = isDarkMode ? '#94a3b8' : '#64748b'; // slate-400 : slate-500
            const gridColor = isDarkMode ? '#334155' : '#f1f5f9'; // slate-700 : slate-100

            var options = {
                series: [{
                    name: 'จำนวนผู้สนใจ',
                    data: dataCounts
                }],
                chart: {
                    height: 450,
                    type: 'bar',
                    fontFamily: 'Prompt, sans-serif',
                    toolbar: {
                        show: true,
                        tools: {
                            download: true,
                            selection: false,
                            zoom: false,
                            zoomin: false,
                            zoomout: false,
                            pan: false,
                            reset: false
                        }
                    },
                    parentHeightOffset: 0
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        borderRadius: 8,
                        columnWidth: '50%',
                        borderRadiusApplication: 'end',
                        dataLabels: {
                            position: 'top',
                        },
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'light',
                        type: "vertical",
                        shadeIntensity: 0.5,
                        gradientToColors: ['#3b82f6'],
                        inverseColors: true,
                        opacityFrom: 1,
                        opacityTo: 0.8,
                        stops: [0, 100],
                    }
                },
                colors: ['#60a5fa'],
                dataLabels: {
                    enabled: true,
                    offsetY: -20,
                    style: {
                        fontSize: '12px',
                        fontWeight: 600,
                        colors: [isDarkMode ? '#e2e8f0' : '#475569']
                    },
                    formatter: function (val) {
                        return val;
                    }
                },
                labels: labels,
                xaxis: {
                    type: 'category',
                    labels: {
                        style: {
                            colors: textColor,
                            fontSize: '12px',
                        },
                        trim: true,
                        rotate: -45,
                        hideOverlappingLabels: false,
                    },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: [{
                    title: {
                        text: 'จำนวนผู้สมัคร (คน)',
                        style: {
                            color: textColor,
                            fontSize: '13px',
                            fontWeight: 500,
                        }
                    },
                    labels: {
                        style: { colors: textColor },
                        formatter: function (val) {
                            return Math.round(val);
                        }
                    }
                }],
                grid: {
                    borderColor: gridColor,
                    strokeDashArray: 4,
                    padding: { top: 10, right: 10, bottom: 0, left: 10 }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    offsetY: -10,
                    markers: { radius: 12 },
                    itemMargin: { horizontal: 10, vertical: 0 },
                    labels: { colors: textColor }
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    y: {
                        formatter: function (y) {
                            if (typeof y !== "undefined") {
                                return y.toFixed(0) + " คน";
                            }
                            return y;
                        }
                    },
                    theme: isDarkMode ? 'dark' : 'light',
                    style: { fontSize: '13px' }
                }
            };

            var chart = new ApexCharts(document.querySelector("#trainingAnalyticsChart"), options);
            chart.render();

            // Horizontal Bar Chart Options (Replaces Donut)
            var donutOptions = {
                series: [{
                    name: 'จำนวนผู้สนใจ',
                    data: dataCounts
                }],
                chart: {
                    type: 'bar',
                    height: 380,
                    fontFamily: 'Prompt, sans-serif',
                    toolbar: { show: false }
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        borderRadius: 6,
                        barHeight: '70%',
                        distributed: true,
                        dataLabels: {
                            position: 'bottom'
                        }
                    }
                },
                colors: ['#3b82f6', '#ef4444', '#10b981', '#f59e0b', '#8b5cf6', '#06b6d4', '#ec4899', '#14b8a6'],
                dataLabels: {
                    enabled: true,
                    textAnchor: 'start',
                    style: {
                        colors: ['#fff'],
                        fontWeight: 600
                    },
                    formatter: function (val, opt) {
                        return opt.w.globals.labels[opt.dataPointIndex] + ": " + val + " คน"
                    },
                    offsetX: 0
                },
                xaxis: {
                    categories: labels,
                    labels: {
                        style: {
                            colors: textColor,
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        show: false
                    }
                },
                grid: {
                    borderColor: gridColor,
                    xaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                legend: {
                    show: false
                },
                tooltip: {
                    theme: isDarkMode ? 'dark' : 'light',
                    y: {
                        formatter: function (val) {
                            return val + " คน"
                        }
                    }
                }
            };

            var donutChart = new ApexCharts(document.querySelector("#trainingDonutChart"), donutOptions);
            donutChart.render();

            // Observe theme changes to adapt chart coloring
            const observer = new MutationObserver(function (mutations) {
                mutations.forEach(function (mutation) {
                    if (mutation.attributeName === "class" || mutation.attributeName === "data-theme") {
                        const darkNow = document.documentElement.classList.contains('dark');
                        const newText = darkNow ? '#94a3b8' : '#64748b';
                        const newGrid = darkNow ? '#334155' : '#f1f5f9';

                        chart.updateOptions({
                            xaxis: { labels: { style: { colors: newText } } },
                            yaxis: [{
                                title: { style: { color: newText } },
                                labels: { style: { colors: newText } }
                            }],
                            legend: { labels: { colors: newText } },
                            grid: { borderColor: newGrid },
                            dataLabels: {
                                style: { colors: [darkNow ? '#e2e8f0' : '#475569'] }
                            },
                            tooltip: { theme: darkNow ? 'dark' : 'light' }
                        });

                        donutChart.updateOptions({
                            xaxis: { labels: { style: { colors: newText } } },
                            grid: { borderColor: newGrid },
                            tooltip: { theme: darkNow ? 'dark' : 'light' }
                        });
                    }
                });
            });

            observer.observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['class', 'data-theme']
            });
        });
    </script>
@endsection
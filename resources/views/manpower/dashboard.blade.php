@extends('layouts.manpower.app')

@section('content')
    <div class="min-h-screen p-6 mt-6 rounded-2xl transition-colors duration-200 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
        
        {{-- Header Section --}}
        <div class="flex flex-col gap-4 mb-8 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                    <span class="text-blue-600 dark:text-blue-400">Manpower</span> Dashboard
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    ภาพรวมทรัพยากรบุคคล สถิติ และข้อมูลเชิงลึกขององค์กร
                </p>
            </div>
            
            <div class="flex flex-wrap gap-3">
                {{-- Date Filter Mockup --}}
                <div class="relative">
                    <select class="h-10 pl-3 pr-8 text-sm bg-white border border-gray-300 rounded-lg appearance-none dark:bg-gray-800 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>เดือนนี้</option>
                        <option>ไตรมาสนี้</option>
                        <option>ปีนี้</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                <!-- <button class="inline-flex items-center px-4 py-2 text-sm font-medium btn btn-success text-gray-700 transition-colors border border-gray-300 rounded-lg shadow-sm dark:text-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <svg class="w-4 h-4 mr-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Import Data
                </button> -->

                <button class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg shadow-sm dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <svg class="w-4 h-4 mr-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Export Report
                </button>
                
                <!-- <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-colors bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    เพิ่มพนักงาน
                </a> -->
            </div>
        </div>

        {{-- Key Metrics Grid --}}
        <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2 lg:grid-cols-4">
            
            <!-- Card 1: Total Employees -->
            <div class="p-6 transition-all bg-white border border-gray-100 shadow-sm dark:bg-gray-800 rounded-xl dark:border-gray-700 hover:shadow-md">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">พนักงานทั้งหมด</p>
                        <h3 class="mt-2 text-3xl font-bold text-gray-800 dark:text-white">{{ number_format($totalEmployees) }}</h3>
                    </div>
                    <div class="p-2 rounded-lg bg-blue-50 dark:bg-blue-900/30">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>
                <div class="flex items-center mt-4 text-sm">
                    <span class="flex items-center font-medium {{ $growthRate >= 0 ? 'text-green-500' : 'text-red-500' }}">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $growthRate >= 0 ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6' }}"></path></svg>
                        {{ $growthRate >= 0 ? '+' : '' }}{{ number_format($growthRate, 1) }}%
                    </span>
                    <span class="ml-2 text-gray-400 dark:text-gray-500">จากเดือนที่แล้ว</span>
                </div>
                <div class="mt-3 text-xs text-gray-400 dark:text-gray-500">
                    ชาย: {{ number_format($maleCount) }} | หญิง: {{ number_format($femaleCount) }}
                </div>
            </div>

            <!-- Card 2: New Hires -->
            <div class="p-6 transition-all bg-white border border-gray-100 shadow-sm dark:bg-gray-800 rounded-xl dark:border-gray-700 hover:shadow-md">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">พนักงานใหม่ (เดือนนี้)</p>
                        <h3 class="mt-2 text-3xl font-bold text-gray-800 dark:text-white">{{ number_format($newHiresCount) }}</h3>
                    </div>
                    <div class="p-2 rounded-lg bg-green-50 dark:bg-green-900/30">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    </div>
                </div>
                <div class="flex items-center mt-4 text-sm">
                    <span class="text-gray-500 dark:text-gray-400">ยินดีต้อนรับสมาชิกใหม่</span>
                </div>
            </div>

            <!-- Card 3: Turnover Rate -->
            <div class="p-6 transition-all bg-white border border-gray-100 shadow-sm dark:bg-gray-800 rounded-xl dark:border-gray-700 hover:shadow-md">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">อัตราการลาออก</p>
                        <h3 class="mt-2 text-3xl font-bold text-gray-800 dark:text-white">{{ number_format($turnoverRate, 1) }}%</h3>
                    </div>
                    <div class="p-2 rounded-lg bg-red-50 dark:bg-red-900/30">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                </div>
                <div class="flex items-center mt-4 text-sm">
                    <span class="text-gray-500 dark:text-gray-400">{{ $resignationsCount }} คนในเดือนนี้</span>
                </div>
            </div>

            <!-- Card 4: Average Tenure -->
            <div class="p-6 transition-all bg-white border border-gray-100 shadow-sm dark:bg-gray-800 rounded-xl dark:border-gray-700 hover:shadow-md">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">อายุงานเฉลี่ย</p>
                        <h3 class="mt-2 text-3xl font-bold text-gray-800 dark:text-white">{{ number_format($avgTenureYears, 1) }} <span class="text-lg font-normal text-gray-500">ปี</span></h3>
                    </div>
                    <div class="p-2 rounded-lg bg-purple-50 dark:bg-purple-900/30">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div class="flex items-center mt-4 text-sm">
                    <span class="text-gray-500 dark:text-gray-400">ความผูกพันองค์กร</span>
                </div>
            </div>
        </div>

        {{-- Charts Section --}}
        <div class="grid grid-cols-1 gap-6 mb-8 lg:grid-cols-3">
            
            <!-- Chart 1: Department Distribution -->
            <div class="p-6 bg-white border border-gray-100 shadow-sm dark:bg-gray-800 rounded-xl dark:border-gray-700 lg:col-span-2">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">จำนวนพนักงานแยกตามฝ่าย</h3>
                </div>
                
                <div class="relative h-64 p-4 border border-dashed border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-900 dark:border-gray-700">
                    @if($divisionStats->count() > 0)
                        @php 
                            $maxDiv = $divisionStats->max('count'); 
                            $count = $divisionStats->count();
                            $segmentWidth = 100 / $count;
                            $points = [];
                            
                            foreach($divisionStats->values() as $index => $div) {
                                $x = ($index * $segmentWidth) + ($segmentWidth / 2);
                                // Map values to 10-85% vertical range (leaving more space for labels at bottom)
                                $percentage = $maxDiv > 0 ? ($div->count / $maxDiv) : 0;
                                $y = 85 - ($percentage * 65); // Top 20% to Bottom 85%
                                $points[] = "$x,$y";
                            }
                            $pointsString = implode(' ', $points);
                            
                            $firstX = ($segmentWidth / 2);
                            $lastX = (($count - 1) * $segmentWidth) + ($segmentWidth / 2);
                        @endphp

                        <svg class="absolute inset-0 w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                            <line x1="0" y1="85" x2="100" y2="85" stroke="currentColor" stroke-width="0.5" class="text-gray-200 dark:text-gray-700" vector-effect="non-scaling-stroke" />
                            <line x1="0" y1="20" x2="100" y2="20" stroke="currentColor" stroke-width="0.5" class="text-gray-200 dark:text-gray-700" stroke-dasharray="4 4" vector-effect="non-scaling-stroke" />
                            <polygon 
                                fill="currentColor" 
                                class="text-blue-500 opacity-10 dark:text-blue-400" 
                                points="{{ $firstX }},85 {{ $pointsString }} {{ $lastX }},85" 
                                vector-effect="non-scaling-stroke"
                            />
                            <polyline 
                                fill="none" 
                                stroke="currentColor" 
                                stroke-width="2" 
                                class="text-blue-500 dark:text-blue-400" 
                                points="{{ $pointsString }}" 
                                vector-effect="non-scaling-stroke"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>

                        <!-- Data Points & Labels -->
                        <div class="absolute inset-0">
                            @foreach($divisionStats->values() as $index => $div)
                                @php 
                                    $left = ($index * $segmentWidth) + ($segmentWidth / 2);
                                    $percentage = $maxDiv > 0 ? ($div->count / $maxDiv) : 0;
                                    $bottom = 15 + ($percentage * 65); // Inverse of Y calculation (100 - 85 = 15)
                                @endphp
                                
                                <!-- Point Container -->
                                <div class="absolute flex flex-col items-center group" style="left: {{ $left }}%; bottom: {{ $bottom }}%; transform: translate(-50%, 50%);">
                                    <!-- Dot -->
                                    <div class="w-3 h-3 bg-white border-2 border-blue-500 rounded-full dark:border-blue-400 dark:bg-gray-800 group-hover:scale-125 transition-transform z-10 cursor-pointer"></div>
                                    
                                    <!-- Tooltip -->
                                    <div class="absolute bottom-full mb-2 opacity-0 group-hover:opacity-100 transition-opacity z-20 pointer-events-none">
                                        <div class="px-2 py-1 text-xs text-white bg-gray-800 rounded shadow-lg whitespace-nowrap dark:bg-gray-700">
                                            {{ $div->count }} คน
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- X-Axis Label with Count -->
                                <div class="absolute bottom-1 flex flex-col items-center justify-end pointer-events-none" style="left: {{ $left }}%; transform: translateX(-50%); width: {{ $segmentWidth }}%;">
                                    <div class="mb-1 text-xs font-bold text-blue-600 dark:text-blue-400">
                                        {{ $div->count }}
                                    </div>
                                    <div class="w-full text-[10px] text-center text-gray-500 dark:text-gray-400 truncate px-1" title="{{ $div->division_name }}">
                                        {{ Str::limit($div->division_name, 10) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="absolute inset-0 flex items-center justify-center text-gray-400">ไม่มีข้อมูล</div>
                    @endif
                </div>
                 {{-- Section Distribution --}}
            <h3 class="mt-6 text-lg font-bold text-gray-800 dark:text-white">จำนวนพนักงานแยกตามสายงาน (Section)</h3>
            
            <div class="relative h-64 p-4 border border-dashed border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-900 dark:border-gray-700">
                @if($sectionStats->count() > 0)
                    @php 
                        $maxSec = $sectionStats->max('count'); 
                        $count = $sectionStats->count();
                    @endphp
                    
                    <div class="absolute inset-0 flex items-end justify-around px-4 pb-12">
                        @foreach($sectionStats as $stat)
                            @php 
                                $height = $maxSec > 0 ? ($stat->count / $maxSec) * 80 : 0; // Max height 80%
                            @endphp
                            <div class="relative flex flex-col items-center justify-end w-full h-full group">
                                <!-- Count Label on top -->
                                <div class="mb-1 text-xs font-bold text-indigo-600 dark:text-indigo-400 opacity-0 group-hover:opacity-100 transition-opacity">
                                    {{ $stat->count }}
                                </div>
                                
                                <!-- Bar -->
                                <div class="w-12 bg-indigo-500 rounded-t-lg opacity-80 hover:opacity-100 transition-all duration-300 relative group-hover:scale-105" style="height: {{ $height }}%"></div>
                                
                                <!-- Label -->
                                <div class="absolute bottom-0 w-full text-center transform translate-y-full pt-2">
                                    <div class="text-xs font-medium text-gray-600 dark:text-gray-400 truncate px-1" title="{{ $stat->section_code }}">
                                        {{ Str::limit($stat->section_code, 15) }}
                                    </div>
                                    <div class="text-xs font-bold text-indigo-600 dark:text-indigo-400 mt-1">
                                        {{ $stat->count }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="absolute inset-0 flex items-center justify-center text-gray-400">ไม่มีข้อมูล</div>
                @endif
            </div>
            </div>

            <!-- Chart 2: Workplace -->
            <div class="flex flex-col gap-6">
                <div class="flex-1 p-6 bg-white border border-gray-100 shadow-sm dark:bg-gray-800 rounded-xl dark:border-gray-700">
                    <h3 class="mb-4 text-lg font-bold text-gray-800 dark:text-white">สถานที่ทำงาน (Workplace)</h3>
                    
                    @if($workplaceStats->count() > 0)
                        @php 
                            $totalWP = $workplaceStats->sum('count'); 
                            $colors = ['bg-blue-500', 'bg-indigo-400', 'bg-purple-400', 'bg-pink-400', 'bg-gray-400'];
                        @endphp
                        <div class="flex items-center justify-center h-40 mb-4">
                            {{-- Simple Pie Chart Representation using Conic Gradient --}}
                            @php
                                $gradient = [];
                                $current = 0;
                                $colorHex = ['#3b82f6', '#818cf8', '#c084fc', '#f472b6', '#9ca3af'];
                                foreach($workplaceStats as $index => $wp) {
                                    $percent = ($wp->count / $totalWP) * 100;
                                    $end = $current + $percent;
                                    $color = $colorHex[$index % count($colorHex)];
                                    $gradient[] = "$color $current% $end%";
                                    $current = $end;
                                }
                                $gradientString = implode(', ', $gradient);
                            @endphp
                            <div class="relative w-32 h-32 rounded-full" style="background: conic-gradient({{ $gradientString }});">
                                <div class="absolute inset-0 m-auto w-20 h-20 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center">
                                    <span class="text-xs font-bold text-gray-600 dark:text-gray-300">{{ $workplaceStats->count() }} Sites</span>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-3">
                            @foreach($workplaceStats as $index => $wp)
                            <div class="flex items-center justify-between text-sm">
                                <span class="flex items-center text-gray-600 dark:text-gray-300">
                                    <span class="w-3 h-3 mr-2 {{ $colors[$index % count($colors)] }} rounded-full"></span> 
                                    {{ $wp->workplace }}
                                </span>
                                <span class="font-medium text-gray-800 dark:text-white">{{ number_format(($wp->count / $totalWP) * 100, 1) }}%</span>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex items-center justify-center h-40 text-gray-400">ไม่มีข้อมูล</div>
                    @endif
                </div>

                <!-- Gender Chart -->
                <div class="flex-1 p-6 bg-white border border-gray-100 shadow-sm dark:bg-gray-800 rounded-xl dark:border-gray-700">
                    <h3 class="mb-4 text-lg font-bold text-gray-800 dark:text-white">สัดส่วนเพศ (Gender)</h3>
                    
                    <div class="flex items-center justify-center h-40 mb-4">
                        {{-- Donut Chart for Gender --}}
                        @php
                            $totalGender = $maleCount + $femaleCount;
                            $malePercent = $totalGender > 0 ? ($maleCount / $totalGender) * 100 : 0;
                            $femalePercent = $totalGender > 0 ? ($femaleCount / $totalGender) * 100 : 0;
                        @endphp
                        <div class="relative w-32 h-32 rounded-full" style="background: conic-gradient(#3b82f6 0% {{ $malePercent }}%, #ec4899 {{ $malePercent }}% 100%);">
                            <div class="absolute inset-0 m-auto w-20 h-20 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center">
                                <div class="text-center">
                                    <span class="block text-xs font-bold text-gray-600 dark:text-gray-300">Total</span>
                                    <span class="text-sm font-bold text-gray-800 dark:text-white">{{ number_format($totalGender) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex items-center justify-between text-sm">
                            <span class="flex items-center text-gray-600 dark:text-gray-300">
                                <span class="w-3 h-3 mr-2 bg-blue-500 rounded-full"></span> 
                                ชาย (Male)
                            </span>
                            <span class="font-medium text-gray-800 dark:text-white">{{ number_format($maleCount) }} ({{ number_format($malePercent, 1) }}%)</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="flex items-center text-gray-600 dark:text-gray-300">
                                <span class="w-3 h-3 mr-2 bg-pink-500 rounded-full"></span> 
                                หญิง (Female)
                            </span>
                            <span class="font-medium text-gray-800 dark:text-white">{{ number_format($femaleCount) }} ({{ number_format($femalePercent, 1) }}%)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       

        {{-- Level Distribution (Full Width) --}}
        <div class="p-6 mb-8 bg-white border border-gray-100 shadow-sm dark:bg-gray-800 rounded-xl dark:border-gray-700">
            <h3 class="mb-6 text-lg font-bold text-gray-800 dark:text-white">โครงสร้างระดับพนักงาน (Level Hierarchy)</h3>
            <div class="space-y-4">
                @if($levelStats->count() > 0)
                    @php $maxLevel = $levelStats->max('count'); @endphp
                    @foreach($levelStats as $stat)
                    @php 
                        $width = ($stat->count / $maxLevel) * 100; 
                        // Map color name to tailwind class if possible, or use default
                        $colorClass = 'bg-blue-500';
                        if(str_contains($stat->color, 'error')) $colorClass = 'bg-red-500';
                        elseif(str_contains($stat->color, 'info')) $colorClass = 'bg-sky-500';
                        elseif(str_contains($stat->color, 'primary')) $colorClass = 'bg-blue-600';
                        elseif(str_contains($stat->color, 'success')) $colorClass = 'bg-green-500';
                        elseif(str_contains($stat->color, 'warning')) $colorClass = 'bg-yellow-500';
                        elseif(str_contains($stat->color, 'accent')) $colorClass = 'bg-teal-500';
                        elseif(str_contains($stat->color, 'secondary')) $colorClass = 'bg-purple-500';
                        elseif(str_contains($stat->color, 'neutral')) $colorClass = 'bg-gray-500';
                    @endphp
                    <div class="flex items-center text-sm">
                        <div class="w-40 font-medium text-gray-600 dark:text-gray-300 truncate" title="{{ $stat->label }}">
                            ระดับพนักงาน : 
                            {{ $stat->label }}</div>
                        <div class="flex-1 h-4 mx-4 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-700">
                            <div class="h-full {{ $colorClass }} rounded-full opacity-80" style="width: {{ $width }}%"></div>
                        </div>
                        <div class="w-12 text-right text-gray-500 dark:text-gray-400">{{ $stat->count }}</div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center text-gray-400">ไม่มีข้อมูล</div>
                @endif
            </div>
        </div>

        {{-- Tables Section --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            
            <!-- Recent Hires Table -->
            <div class="overflow-hidden bg-white border border-gray-100 shadow-sm dark:bg-gray-800 rounded-xl dark:border-gray-700">
                <div class="flex items-center justify-between p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/30">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">พนักงานใหม่ล่าสุด</h3>
                    <a href="{{ route('users.index') }}" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-400">ดูทั้งหมด</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-3">ชื่อ-สกุล</th>
                                <th class="px-6 py-3">ตำแหน่ง</th>
                                <th class="px-6 py-3">วันที่เริ่มงาน</th>
                                <th class="px-6 py-3">สถานะ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($recentHires as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    <div class="flex items-center gap-3">
                                        <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-full dark:bg-blue-900 text-blue-600 dark:text-blue-300 uppercase">
                                            {{ substr($user->first_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-bold">{{ $user->prefix . " " . $user->fullname }}</div>
                                            <div class="text-xs text-gray-500">{{ $user->employee_code }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                    {{ $user->position ?? '-' }}
                                    <div class="text-xs text-gray-400">แผนก : {{ $user->department->department_fullname ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                    {{ $user->startwork_date ? \Carbon\Carbon::parse($user->startwork_date)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $user->status == \App\Models\User::STATUS_ACTIVE ? 'text-green-600 bg-green-100 dark:text-green-400 dark:bg-green-900/30' : 'text-red-600 bg-red-100 dark:text-red-400 dark:bg-red-900/30' }}">
                                        {{ $user->status_label }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">ไม่มีข้อมูลพนักงานใหม่</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Probation / Contract Expiry -->
            <div class="bg-white border border-gray-100 shadow-sm dark:bg-gray-800 rounded-xl dark:border-gray-700">
                <div class="flex items-center justify-between p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-700/30">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">ครบกำหนดทดลองงาน (เร็วๆ นี้)</h3>
                    <span class="text-xs text-gray-500 dark:text-gray-400">30 วันข้างหน้า</span>
                </div>
                <div class="p-6 space-y-4">
                    @forelse($probationUpcoming as $user)
                    @php 
                        $probationDate = \Carbon\Carbon::parse($user->startwork_date)->addDays(119);
                        $daysLeft = now()->diffInDays($probationDate, false);
                    @endphp
                    <div class="flex items-center justify-between p-4 transition-colors border border-orange-100 rounded-lg cursor-pointer bg-orange-50 dark:bg-orange-900/20 dark:border-orange-800 hover:bg-orange-100 dark:hover:bg-orange-900/30">
                        <div class="flex items-center gap-4">
                            <div class="flex items-center justify-center w-10 h-10 text-orange-600 bg-white rounded-full shadow-sm dark:bg-gray-800 dark:text-orange-400 uppercase font-bold">
                                {{ substr($user->first_name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 dark:text-white">{{ $user->fullname }}</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $user->department->department_name ?? '-' }} • 
                                    <span class="{{ $daysLeft < 7 ? 'text-red-500 font-bold' : '' }}">
                                        ครบกำหนด: {{ $probationDate->format('d/m/Y') }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <button class="px-3 py-1.5 text-xs font-medium text-gray-600 bg-white border border-gray-200 rounded shadow-sm dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 hover:text-blue-600 dark:hover:text-blue-400">
                            ประเมิน
                        </button>
                    </div>
                    @empty
                    <div class="text-center text-gray-500 py-4">ไม่มีพนักงานครบกำหนดทดลองงานในช่วงนี้</div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
@endsection

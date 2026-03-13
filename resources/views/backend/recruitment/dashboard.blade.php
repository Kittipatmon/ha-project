@extends('layouts.recruitment.app')

@section('title', 'Recruitment Dashboard')

@section('content')
    <div class="space-y-8">
        <div class="flex justify-between items-center mt-6">
            <h2 class="text-2xl font-bold dark:text-white text-gray-800">Recruitment Overview</h2>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div
                class="bg-white dark:bg-kumwell-card p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-800 hover:shadow-lg transition-all">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/20 text-yellow-600 rounded-xl flex items-center justify-center text-xl shadow-sm">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">คำขอรออนุมัติ</p>
                        <p class="text-2xl font-black text-gray-800 dark:text-white">
                            {{ number_format($stats['pending_requests']) }}
                        </p>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-kumwell-card p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-800 hover:shadow-lg transition-all">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 bg-green-100 dark:bg-green-900/20 text-green-600 rounded-xl flex items-center justify-center text-xl shadow-sm">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">ประกาศที่เปิดอยู่</p>
                        <p class="text-2xl font-black text-gray-800 dark:text-white">
                            {{ number_format($stats['active_posts']) }}
                        </p>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-kumwell-card p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-800 hover:shadow-lg transition-all">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 bg-blue-100 dark:bg-blue-900/20 text-blue-600 rounded-xl flex items-center justify-center text-xl shadow-sm">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">ผู้สมัครทั้งหมด</p>
                        <p class="text-2xl font-black text-gray-800 dark:text-white">
                            {{ number_format($stats['total_applications']) }}
                        </p>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-kumwell-card p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-800 hover:shadow-lg transition-all">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 bg-red-100 dark:bg-red-900/20 text-kumwell-red rounded-xl flex items-center justify-center text-xl shadow-sm">
                        <i class="fa-solid fa-fire"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">ผู้สมัครมาใหม่</p>
                        <p class="text-2xl font-black text-gray-800 dark:text-white">
                            {{ number_format($stats['new_applications']) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Applications -->
            <div
                class="bg-white dark:bg-kumwell-card rounded-3xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
                <div class="p-6 border-b border-gray-50 dark:border-gray-800 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 dark:text-white">ผู้สมัครล่าสุด</h3>
                    <a href="{{ route('backend.recruitment.applications.index') }}"
                        class="text-xs text-kumwell-red hover:underline">ดูทั้งหมด</a>
                </div>
                <div class="p-0">
                    <table class="w-full text-left text-sm">
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                            @foreach($recent_applications as $app)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-gray-700 dark:text-gray-200">
                                            {{ $app->applicant?->full_name ?? 'N/A' }}
                                        </p>
                                        <p class="text-[10px] text-gray-400 uppercase">
                                            {{ $app->jobPost?->title ?? 'N/A' }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-4 text-gray-400 text-xs">{{ $app->created_at->diffForHumans() }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <span
                                            class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $app->status == 'new' ? 'bg-red-100 text-kumwell-red' : 'bg-gray-100 text-gray-500' }}">
                                            {{ $app->status }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Requests -->
            <div
                class="bg-white dark:bg-kumwell-card rounded-3xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
                <div class="p-6 border-b border-gray-50 dark:border-gray-800 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 dark:text-white">รายการคำขอเปิดรับสมัครพนักงาน</h3>
                    <a href="{{ route('backend.recruitment.requests.index') }}"
                        class="text-xs text-kumwell-red hover:underline">ดูทั้งหมด</a>
                </div>
                <div class="p-0">
                    <table class="w-full text-left text-sm">
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                            @foreach($recent_requests as $req)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-gray-700 dark:text-gray-200">
                                            {{ $req->position_name ?: ($req->jobPosition?->position_name ?? 'N/A') }}
                                        </p>
                                        <p class="text-[10px] text-gray-400 uppercase">
                                            {{ $req->department?->department_name ?? 'N/A' }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <p class="text-xs font-bold text-gray-600 dark:text-gray-400">{{ $req->headcount }}</p>
                                        <p class="text-[10px] text-gray-400 uppercase">อัตรา</p>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase 
                                                                            @if($req->status == 'approved') bg-green-100 text-green-700
                                                                            @elseif($req->status == 'pending') bg-yellow-100 text-yellow-700
                                                                            @else bg-gray-100 text-gray-500 @endif">
                                            {{ $req->status }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('content')
    <div class="p-8">
        <div class="max-w-7xl mx-auto">
            
            <!-- Breadcrumb -->
            <nav class="text-sm mb-6 font-light">
                <ol class="list-none p-0 inline-flex">
                    <li class="flex items-center">
                        <a href="{{ route('welcome') }}" class="hover:text-gray-700">Home</a>
                        <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
                    </li>
                    <li>
                        <span class="text-red-500 font-medium">Request HR</span>
                    </li>
                </ol>
            </nav>

            <!-- Main Card Container -->
            <div class="rounded-[20px] p-10 pb-32 custom-shadow w-full relative overflow-visible border border-gray-400/40">
                
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-6 border-b border-gray-200 dark:border-gray-100/60 pb-4">
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <div class="bg-red-100 p-2 rounded-lg text-red-600">
                                    <i class="fa-solid fa-file-signature text-xl"></i>
                                </div>
                                <h1 class="text-3xl font-bold text-red-500 tracking-tight">ระบบ Request HR</h1>
                            </div>
                            <p class="text-gray-500 text-base font-light pl-1">จัดการคำขอ แจ้งเปลี่ยนแปลงแก้ไขเวลา และติดตามสถานะ</p>
                        </div>
                        
                        <div class="flex gap-3 text-xs font-medium text-gray-500 bg-gray-50 px-4 py-2 rounded-xl border border-gray-100">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-sky-500"></span> รออนุมัติ
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-yellow-500"></span> กำลังดำเดินการ
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-green-600"></span> เสร็จสิ้น
                            </div>
                        </div>
                    </div>

                <!-- Action Buttons Area -->
                <div class="flex flex-wrap items-center gap-4">
                    
                    <a href="{{ route('requesthr.index') }}">
                        <button class="group relative flex items-center gap-3 px-8 py-3.5 bg-gradient-to-r from-red-600 to-rose-500 text-white rounded-2xl shadow-lg shadow-red-500/30 hover:shadow-red-500/50 hover:-translate-y-1 transition-all duration-300">
                            <i class="fa-solid fa-paper-plane text-sm group-hover:rotate-12 transition-transform duration-300"></i>
                            <span class="font-semibold tracking-wide">สร้างคำขอใหม่</span>
                        </button>
                    </a>

                    <div class="dropdown dropdown-bottom">
                        <div tabindex="0" role="button" class="group flex items-center gap-3 px-6 py-2.5 rounded-2xl font-semibold border border-gray-200 hover:border-red-200 hover:bg-red-50/30 transition-all duration-200 shadow-sm">
                            
                            <div class="w-8 h-8 rounded-lg bg-red-50 text-red-500 flex items-center justify-center group-hover:bg-red-500 group-hover:text-white transition-colors">
                                <i class="fa-solid fa-chart-line"></i>
                            </div>
                            
                            <span>รายงานข้อมูลคำขอ</span>
                            
                            <div class="flex items-center gap-1.5 ml-3 pl-3 border-l border-gray-200">
                                <span class="flex items-center justify-center badge badge-outline badge-info rounded-md" title="รออนุมัติ">0</span>
                                <span class="flex items-center justify-center badge badge-outline badge-warning rounded-md" title="ดำเนินการ">0</span>
                                <span class="flex items-center justify-center badge badge-outline badge-success rounded-md" title="เสร็จสิ้น">0</span>
                            </div>

                            <i class="fa-solid fa-chevron-down text-xs text-gray-400 ml-2 group-hover:text-red-500 transition-colors"></i>
                        </div>

                        <ul tabindex="-1" class="dropdown-content menu p-2 shadow-[0_20px_50px_rgba(0,0,0,0.1)] rounded-2xl w-60 mt-2 border border-gray-100 z-50">
                            <li class="menu-title px-4 py-2 text-xs font-bold text-gray-400 uppercase">เลือกประเภทรายงาน</li>
                            <li>
                                <a class="rounded-xl py-3 hover:bg-red-50 hover:text-red-600 group active:bg-red-100">
                                    <i class="fa-regular fa-file-lines w-5 text-gray-400 group-hover:text-red-500"></i>
                                    รายการที่รอดำเนินการ
                                </a>
                            </li>
                            <li>
                                <a class="rounded-xl py-3 hover:bg-red-50 hover:text-red-600 group active:bg-red-100">
                                    <i class="fa-solid fa-clock-rotate-left w-5 text-gray-400 group-hover:text-red-500"></i>
                                    รายการทั้งหมด
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
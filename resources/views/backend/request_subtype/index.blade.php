@extends('layouts.sidebar')
@section('title', 'ประเภทย่อยคำร้อง')
@section('content')
<div class="container mx-auto px-4 py-3">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-3 gap-4">
        <!-- <h1 class="text-2xl font-bold text-gray-800 dark:text-white">จัดการประเภทคำร้อง</h1> -->
        <button type="button" id="openCreateModal" class="btn btn-success text-white shadow-md">
            <i class="fa-solid fa-plus mr-2"></i> เพิ่มประเภทย่อยคำร้อง
        </button>
    </div>

    <div class=" dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead class="bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-200 uppercase text-sm font-semibold">
                    <tr>
                        <th class="px-6 py-2 text-left">ลำดับ</th>
                        <!-- <th class="px-6 py-2 text-left">รหัส</th> -->
                        <th class="px-6 py-2 text-left">ชื่อประเภทย่อยคำร้อง</th>
                        <th class="px-6 py-2 text-left">ตัวเลือกคำร้อง</th>
                        <th class="px-6 py-2 text-center">สถานะ</th>
                        <th class="px-6 py-2 text-left">คำอธิบาย</th>
                        <th class="px-6 py-2 text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($requestsubtypes as $index => $requestsubtype)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-600 transition duration-150">
                        <td class="px-6 py-2">{{ $loop->iteration }}</td>
                        <!-- <td class="px-6 py-2 font-mono text-sm text-blue-600 dark:text-blue-400">{{ $requestsubtype->code ?? '-' }}</td> -->
                        <td class="px-6 py-2 font-mono text-sm text-blue-600 dark:text-blue-400">{{ $requestsubtype->name_th }}</td>
                        <td class="px-6 py-2 font-medium">{{ $requestsubtype->requestType->name_th ?? '-' }}</td>
                        <td class="px-6 py-2 text-center">
                            @if($requestsubtype->is_active == '0')
                                <span class="badge badge-success text-white gap-1 p-3">
                                    <i class="fa-solid fa-check-circle text-xs"></i> ใช้งาน
                                </span>
                            @else
                                <span class="badge badge-error text-white gap-1 p-3">
                                    <i class="fa-solid fa-times-circle text-xs"></i> ไม่ใช้งาน
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-2 text-gray-500 dark:text-gray-400 truncate max-w-xs" title="{{ $requestsubtype->description }}">
                            {{ $requestsubtype->description ?? '-' }}
                        </td>
                        <td class="px-6 py-2 text-center space-x-2">
                            <button type="button" class="btn btn-warning btn-sm btn-square text-white editBtn shadow-sm"
                                data-id="{{ $requestsubtype->id }}"
                                data-code="{{ $requestsubtype->code }}"
                                data-name_th="{{ $requestsubtype->name_th }}"
                                data-name_en="{{ $requestsubtype->name_en }}"
                                data-description="{{ $requestsubtype->description }}"
                                data-is_active="{{ $requestsubtype->is_active }}"
                                title="แก้ไข">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button type="button" class="btn btn-error btn-sm btn-square text-white deleteBtn shadow-sm"
                                data-id="{{ $requestsubtype->id }}"
                                data-name="{{ $requestsubtype->name_th }}"
                                title="ลบ">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-10 text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col items-center">
                                <i class="fa-solid fa-folder-open text-4xl mb-3 opacity-50"></i>
                                <p>ไม่พบข้อมูลประเภทคำร้อง</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
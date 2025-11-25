@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-3">
    <div class="breadcrumbs text-sm">
        <ul>
            <li><a>Home</a></li>
            <li><a href="{{ route('request.hr') }}">Request HR</a></li>
            <li class="text-red-600">รายงานข้อมูลทั้งหมด</li>
        </ul>
    </div>

    <div class=" dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table table-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700">
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-300">
                            เลขที่รายการ</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-300">ชื่อ-สกุล
                        </th>
                        <!-- <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-300">
                            หัวข้อคำร้อง</th> -->
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-300">
                            หมวดหมู่คำร้อง</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-300">
                            ประเภทคำร้อง</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-300">ประเภทย่อย
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-300">
                            วันที่ส่งคำร้อง</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-300">สถานะ</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-300">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hrrequests as $request)
                    <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="text-sm text-gray-700 dark:text-gray-300">{{ $request->request_code }}</td>
                        <td class="text-sm text-gray-700 dark:text-gray-300">{{ $request->user->fullname }}</td>
                        <!-- <td class="text-sm text-gray-700 dark:text-gray-300">{{ $request->title }}</td> -->

                        <td class="text-sm text-gray-700 dark:text-gray-300">{{ $request->category->name_th ?? '-' }}
                        </td>
                        <td class="text-sm text-gray-700 dark:text-gray-300">{{ $request->type->name_th ?? '-' }}</td>
                        <td class="text-sm text-gray-700 dark:text-gray-300">{{ $request->subtype->name_th ?? '-' }}
                        </td>
                        <td class="text-sm text-gray-700 dark:text-gray-300">{{ $request->created_at->format('d/m/Y') }}
                        </td>
                        <td>
                            <span class="px-2 py-1 rounded-full badge {{ $request->status_color }} badge-sm">
                                {{ $request->status_label }}
                            </span>
                        </td>
                        <td class="text-gray-700 dark:text-gray-300">
                            <a href="{{ route('requesthr.detailUser', $request->hr_request_id ) }}" class="btn btn-info btn-xs text-white hover:underline">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="#" class="btn btn-error btn-xs text-white hover:underline">
                                <i class="fas fa-cancel"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    @if($hrrequests->isEmpty())
                    <tr>
                        <td colspan="9" class="px-4 py-3 text-center text-gray-500 dark:text-gray-300">
                            ไม่มีคำร้องรอดำเนินการ</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
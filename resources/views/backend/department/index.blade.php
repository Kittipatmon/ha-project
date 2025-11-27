@extends('layouts.sidebar')
@section('title', 'ข้อมูลแผนก (Department)')
@section('content')



<div class="max-w-8xl rounded-xl shadow-xl">
    <div class="flex justify-between items-center">
        <!-- <h1 class="text-xl font-semibold mb-4">ข้อมูลแผนก (Department)</h1> -->

        <div class="mb-4">
            <a href="{{ route('departments.create') }}" class="btn btn-success text-white">
                <i class="fa fa-plus mr-1"></i>
                สร้างแผนกใหม่</a>
        </div>
    </div>
    <div class=" dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table table-sm w-full">
                <thead
                    class="bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-200 uppercase text-sm font-semibold">
                    <tr>
                        <th class="px-6 py-2 text-left">ลำดับ</th>
                        <th class="px-6 py-2 text-left">รหัสฝ่าย</th>
                        <th class="px-6 py-2 text-left">ชื่อ(ย่อ)</th>
                        <th class="px-6 py-2 text-left">ชื่อเต็ม</th>
                        <th class="px-6 py-2 text-left">สถานะ</th>
                        <th class="px-6 py-2 text-left">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($departments as $department)
                    <tr>
                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2">
                            {{ $department->division->division_fullname ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $department->department_name }}</td>
                        <td class="px-4 py-2">{{ $department->department_fullname }}</td>
                        <td class="px-4 py-2">
                            @if ($department->department_status === 0)
                            <span class="badge badge-success badge-sm text-white">ใช้งาน</span>
                            @else
                            <span class="badge badge-error badge-sm text-white">ไม่ใช้งาน</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <a href="{{ route('departments.edit', $department->department_id) }}"
                                class="btn btn-sm btn-warning">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="{{ route('departments.destroy', $department->department_id) }}" method="POST"
                                class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-error"
                                    onclick="return confirm('คุณแน่ใจหรือว่าต้องการลบแผนกนี้?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
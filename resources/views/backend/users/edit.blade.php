@extends('layouts.sidebar')
@section('title', 'แก้ไขข้อมูลพนักงาน' . " " . "รหัสพนักงาน : " . $user->employee_code)
@section('content')
<div class="container mx-auto px-4">
    <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="col-span-1 md:col-span-2 lg:col-span-4 pb-2 mb-2 border-b border-gray-100 dark:border-gray-700">
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">ข้อมูลส่วนตัว</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-3">
            <div>
                <label for="employee_code" class="block font-medium mb-1">รหัสพนักงาน <span
                        class="text-red-500">*</span></label>
                <input type="text" id="employee_code" name="employee_code"
                    value="{{ old('employee_code', $user->employee_code) }}"
                    class="input input-bordered w-full dark:bg-gray-700" required>
            </div>
            <div>
                <label for="startwork_date" class="block font-medium mb-1">วันที่เริ่มงาน <span
                        class="text-red-500">*</span></label>
                <input type="date" id="startwork_date" name="startwork_date"
                    value="{{ old('startwork_date', $user->startwork_date) }}"
                    class="input input-bordered w-full dark:bg-gray-700">
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="prefix" class="block font-medium mb-1">คำนำหน้า <span class="text-red-500">*</span></label>
                <select id="prefix" name="prefix" class="select select-bordered w-full dark:bg-gray-700" required>
                    <option value="นาย" {{ old('prefix', $user->prefix) == 'นาย' ? 'selected' : '' }}>นาย</option>
                    <option value="นางสาว" {{ old('prefix', $user->prefix) == 'นางสาว' ? 'selected' : '' }}>นางสาว
                    </option>
                    <option value="นาง" {{ old('prefix', $user->prefix) == 'นาง' ? 'selected' : '' }}>นาง</option>
                </select>
            </div>
            <div>
                <label for="sex" class="block font-medium mb-1">เพศ <span class="text-red-500">*</span></label>
                <input type="text" id="sex" name="sex" value="{{ old('sex', $user->sex) }}"
                    class="input input-bordered w-full dark:bg-gray-700" required>
            </div>
            <div>
                <label for="first_name" class="block font-medium mb-1">ชื่อ <span class="text-red-500">*</span></label>
                <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}"
                    class="input input-bordered w-full dark:bg-gray-700" required>
            </div>
            <div>
                <label for="last_name" class="block font-medium mb-1">นามสกุล <span
                        class="text-red-500">*</span></label>
                <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}"
                    class="input input-bordered w-full dark:bg-gray-700" required>
            </div>
        </div>
        <div
            class="col-span-1 md:col-span-2 lg:col-span-4 pb-2 mb-2 mt-4 border-b border-gray-100 dark:border-gray-700">
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">ตำแหน่งและสังกัด</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="position" class="block font-medium mb-1">ตำแหน่ง</label>
                <input type="text" id="position" name="position" value="{{ old('position', $user->position) }}"
                    class="input input-bordered w-full dark:bg-gray-700">
            </div>
            <div>
                <label for="department_id" class="block font-medium mb-1">แผนก</label>
                <select id="department_id" name="department_id" class="select select-bordered w-full dark:bg-gray-700">
                    <option value="">-- เลือกแผนก --</option>
                    @foreach ($departments as $department)
                    <option value="{{ $department->department_id }}"
                        {{ old('department_id', $user->department_id) == $department->department_id ? 'selected' : '' }}>
                        {{ $department->department_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="division_id" class="block font-medium mb-1">ฝ่าย</label>
                <select id="division_id" name="division_id" class="select select-bordered w-full dark:bg-gray-700">
                    <option value="">-- เลือกฝ่าย --</option>
                    @foreach ($divisions as $division)
                    <option value="{{ $division->division_id }}"
                        {{ old('division_id', $user->division_id) == $division->division_id ? 'selected' : '' }}>
                        {{ $division->division_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="section_id" class="block font-medium mb-1">สายงาน</label>
                <select id="section_id" name="section_id" class="select select-bordered w-full dark:bg-gray-700">
                    <option value="">-- เลือกสายงาน --</option>
                    @foreach ($sections as $section)
                    <option value="{{ $section->section_id }}"
                        {{ old('section_id', $user->section_id) == $section->section_id ? 'selected' : '' }}>
                        {{ $section->section_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div
            class="col-span-1 md:col-span-2 lg:col-span-4 pb-2 mb-2 mt-4 border-b border-gray-100 dark:border-gray-700">
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">สิทธิ์การใช้งาน</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="level_user" class="block font-medium mb-1">ระดับพนักงาน <span
                        class="text-red-500">*</span></label>
                <select id="level_user" name="level_user" class="select select-bordered w-full dark:bg-gray-700"
                    required>
                    @foreach ($userTypes as $userType)
                    <option value="{{ $userType->type_name }}"
                        {{ old('level_user', $user->level_user) == $userType->type_name ? 'selected' : '' }}>
                        {{ $userType->type_name }} ({{ $userType->description }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="hr_status" class="block font-medium mb-1">สถานะ HR<span
                        class="text-red-500">*</span></label>
                @php
                $hrStatusOptions = \App\Models\User::getHrStatusOptions();
                @endphp
                <select id="hr_status" name="hr_status" class="select select-bordered w-full dark:bg-gray-700" required>
                    @foreach($hrStatusOptions as $value => $meta)
                    <option value="{{ $value }}" @if(old('hr_status', $user->hr_status)==$value) selected
                        @endif>{{ $meta['label'] }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mt-6 text-center">
            <div class="modal-action mt-8 pt-4 border-t border-gray-100 dark:border-gray-700">
                <a href="{{ route('users.index') }}" class="btn">ยกเลิก</a>
                <button type="submit" id="confirm-add-user" class="btn btn-success text-white px-8">
                    <i class="fa-solid fa-save mr-2"></i> บันทึกข้อมูล
                </button>
            </div>
        </div>

    </form>
</div>

@endsection
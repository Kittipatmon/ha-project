@extends('layouts.sidebar')

@section('content')
<div class="card border">
    <!-- <div class="card-header border rounded-lg">
        Section Header
    </div> -->
    <div class="card-body ">

        <div class="flex justify-end">
            <button class="btn btn-success" onclick="document.getElementById('modal-create-section').showModal()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus">
                    <path d="M5 12h14" />
                    <path d="M12 5v14" />
                </svg> Add Section
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="table table-sm">
                <thead">
                    <tr>
                        <th></th>
                        <th>รหัสสายงาน</th>
                        <th>ชื่อสายงาน</th>
                        <th>ชื่อเต็มสายงาน</th>
                        <th>สถานะ</th>
                        <!-- <th>Last Login</th>
                        <th>Favorite Color</th> -->
                        <th>Actions</th>
                    </tr>
                    </thead>
                    @foreach($sections as $section)
                    <tbody>
                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <td>{{ $section->section_code  }}</td>
                            <td>{{ $section->section_name }}</td>
                            <td>{{ $section->section_fullname }}</td>
                            <td>
                                <span class="badge badge-{{ \App\Models\Section::getStatusColor($section->section_status) }}">
                                    {{ \App\Models\Section::getStatusLabel($section->section_status) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn bg-orange-500 btn-sm" onclick="document.getElementById('modal-edit-section-{{ $section->section_id }}').showModal()">Edit</button>
                                <form action="{{ route('sections.destroy', $section->section_id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn bg-red-500 btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                    @endforeach
            </table>
        </div>
    </div>
</div>

<!-- Create Section Modal -->
<dialog id="modal-create-section" class="modal">
    <div class="modal-box w-11/12 max-w-2xl">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="font-bold text-lg mb-4">Add Section</h3>
        <form action="{{ route('sections.store') }}" method="POST">
            @csrf
            <div class="mb-2">
                <label class="block">รหัสสายงาน</label>
                <input type="text" name="section_code" class="input input-bordered w-full" required>
            </div>
            <div class="mb-2">
                <label class="block">ชื่อสายงาน</label>
                <input type="text" name="section_name" class="input input-bordered w-full" required>
            </div>
            <div class="mb-2">
                <label class="block">ชื่อเต็มสายงาน</label>
                <input type="text" name="section_fullname" class="input input-bordered w-full">
            </div>
            <div class="mb-2">
                <label class="block">สถานะ</label>
                <select name="section_status" class="select select-bordered w-full">
                    <option value="0">ใช้งาน</option>
                    <option value="1">ไม่ใช้งาน</option>
                </select>
            </div>
            <div class="modal-action">
                <button type="submit" class="btn btn-success">บันทึกข้อมูล</button>
            </div>
        </form>
    </div>
</dialog>

<!-- Edit Section Modals -->
@foreach($sections as $section)
<dialog id="modal-edit-section-{{ $section->section_id }}" class="modal">
    <div class="modal-box w-11/12 max-w-2xl">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="font-bold text-lg mb-4">Edit Section</h3>
        <form action="{{ route('sections.update', $section->section_id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-2">
                <label class="block">รหัสสายงาน</label>
                <input type="text" name="section_code" class="input input-bordered w-full" value="{{ $section->section_code }}" required>
            </div>
            <div class="mb-2">
                <label class="block">ชื่อสายงาน</label>
                <input type="text" name="section_name" class="input input-bordered w-full" value="{{ $section->section_name }}" required>
            </div>
            <div class="mb-2">
                <label class="block">ชื่อเต็มสายงาน</label>
                <input type="text" name="section_fullname" class="input input-bordered w-full" value="{{ $section->section_fullname }}">
            </div>
            <div class="mb-2">
                <label class="block">สถานะ</label>
                <select name="section_status" class="select select-bordered w-full">
                    <option value="0" @if($section->section_status=='0') selected @endif>ใช้งาน</option>
                    <option value="1" @if($section->section_status=='1') selected @endif>ไม่ใช้งาน</option>
                </select>
            </div>
            <div class="modal-action">
                <button type="submit" class="btn btn-success">บันทึกข้อมูล</button>
            </div>
        </form>
    </div>
</dialog>
@endforeach

@endsection
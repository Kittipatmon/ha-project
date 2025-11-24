@extends('layouts.sidebar')

@section('content')
<div class="card border">
    <!-- <div class="card-header border rounded-lg">
        Section Header
    </div> -->
    <div class="card-body ">

        <div class="flex justify-end">
            <a href="{{ route('sections.create') }}" class="btn btn-success"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg> Add Section</a>
        </div>

        <div class="overflow-x-auto">
            <table class="table table-sm">
                <thead class="bg-base-300">
                    <tr>
                        <th></th>
                        <th>รหัสสายงาน</th>
                        <th>ชื่อแผนก</th>
                        <th>ชื่อเต็มแผนก</th>
                        <th>สถานะ</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                @foreach($departments as $department)
                <tbody>
                    <tr>
                        <th>{{ $loop->iteration }}</th>
                        <td>{{ $department->section->section_code   }}</td>
                        <td>{{ $department->department_name   }}</td>
                        <td>{{ $department->department_fullname }}</td>
                        <td>{{ $department->department_status }}</td>
                        <td>
                            <a href="{{ route('sections.edit', 1) }}" class="btn bg-orange-500 btn-sm">Edit</a>
                            <form action="{{ route('sections.destroy', 1) }}" method="POST" class="inline">
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
@endsection
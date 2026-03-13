@extends('layouts.sidebar')

@section('title', 'สร้างคำขอเปิดรับสมัครพนักงาน')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('backend.recruitment.requests.index') }}"
                class="text-gray-400 hover:text-kumwell-red transition-colors">
                <i class="fa-solid fa-arrow-left text-xl"></i>
            </a>
            <h2 class="text-2xl font-bold dark:text-white text-gray-800">สร้างคำขอเปิดอัตราใหม่</h2>
        </div>

        <form action="{{ route('backend.recruitment.requests.store') }}" method="POST"
            class="bg-white dark:bg-kumwell-card rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-8 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">แผนกที่ต้องการรับ
                        (Department)</label>
                    <select name="department_id"
                        class="w-full bg-gray-50 dark:bg-kumwell-dark border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-kumwell-red transition-all"
                        required>
                        <option value="">เลือกแผนก</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->department_id }}">{{ $dept->department_fullname }}
                                ({{ $dept->department_name }})</option>
                        @endforeach
                    </select>
                    @error('department_id') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">ตำแหน่งงาน (Position)</label>
                    <input type="text" name="position_name" list="position-list"
                        class="w-full bg-gray-50 dark:bg-kumwell-dark border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-kumwell-red transition-all"
                        placeholder="พิมพ์หรือเลือกตำแหน่งงาน..." required>
                    <datalist id="position-list">
                        @foreach($employeePositions as $pName)
                            <option value="{{ $pName }}"></option>
                        @endforeach
                        @foreach($positions as $pos)
                            <option value="{{ $pos->position_name }}">{{ $pos->position_code }}</option>
                        @endforeach
                    </datalist>
                    @error('position_name') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">จำนวนอัตรา (Headcount)</label>
                    <input type="number" name="headcount" min="1"
                        class="w-full bg-gray-50 dark:bg-kumwell-dark border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-kumwell-red transition-all"
                        required>
                    @error('headcount') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">วันที่ต้องการเริ่มงาน (Required
                        Start Date)</label>
                    <input type="date" name="required_start_date"
                        class="w-full bg-gray-50 dark:bg-kumwell-dark border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-kumwell-red transition-all">
                    @error('required_start_date') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">เงินเดือนเริ่มต้น (Salary
                        Min)</label>
                    <input type="number" name="salary_min"
                        class="w-full bg-gray-50 dark:bg-kumwell-dark border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-kumwell-red transition-all">
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">เงินเดือนสูงสุด (Salary
                        Max)</label>
                    <input type="number" name="salary_max"
                        class="w-full bg-gray-50 dark:bg-kumwell-dark border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-kumwell-red transition-all">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">เหตุผลในการเปิดรับ (Reason)</label>
                <textarea name="reason" rows="3"
                    class="w-full bg-gray-50 dark:bg-kumwell-dark border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-kumwell-red transition-all"></textarea>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">รายละเอียดงาน (Job
                    Description)</label>
                <textarea name="job_description" rows="5"
                    class="w-full bg-gray-50 dark:bg-kumwell-dark border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-kumwell-red transition-all"></textarea>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">คุณสมบัติ (Qualification)</label>
                <textarea name="qualification" rows="5"
                    class="w-full bg-gray-50 dark:bg-kumwell-dark border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-kumwell-red transition-all"></textarea>
            </div>

            <div class="pt-4 flex justify-end gap-3">
                <button type="reset"
                    class="px-6 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all font-semibold">
                    ยกเลิก
                </button>
                <button type="submit"
                    class="px-8 py-2.5 rounded-xl bg-kumwell-red hover:bg-red-700 text-white font-bold shadow-lg shadow-red-500/30 transition-all active:scale-95">
                    ส่งคำขอ
                </button>
            </div>
        </form>
    </div>
@endsection
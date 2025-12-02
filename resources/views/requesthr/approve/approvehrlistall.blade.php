@extends('layouts.hrrequest.app')
@section('content')
<div class="max-w-8xl mx-auto py-3">
    <div class="breadcrumbs text-sm">
        <ul>
            <li><a>Home</a></li>
            <li><a href="{{ route('request.hr') }}">Request HR</a></li>
            <li class="text-red-600">รายงานคำร้องขอ (รอรับทราบ/อนุมัติ)</li>
        </ul>
    </div>

    <div
        class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-md overflow-hidden mb-6">
        <div
            class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                </path>
            </svg>
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">ตัวกรองค้นหา
                (Search Filters)</h3>
        </div>

        <div class="p-3">
            <form action="{{ route('approve.approvehrlistall') }}" method="GET">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-7 gap-3">
                     <div class="relative group">
                        <label for="" class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5 uppercase">
                            กรอกคำค้นหา
                        </label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="ค้นหาเลขที่คำร้อง ชื่อ-สกุล หัวข้อคำร้อง"
                            class="input input-bordered w-full rounded-lg border-gray-300  dark:bg-gray-700 dark:border-gray-600 placeholder-gray-400">
                    </div>
                    <div class="relative group">
                        <label for="category"
                            class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5 uppercase">หมวดหมู่</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-hover:text-red-500 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                    </path>
                                </svg>
                            </div>
                            <select id="category" name="category"
                                class="select select-bordered w-full rounded-lg border-gray-300  dark:bg-gray-700 dark:border-gray-600">
                                <option value="">ทั้งหมด</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category')==$category->id ? 'selected' : '' }}>
                                    {{ $category->name_th }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="relative group">
                        <label for="type"
                            class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5 uppercase">ประเภท</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-hover:text-red-500 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                            </div>
                            <select id="type" name="type"
                                class="select select-bordered w-full rounded-lg border-gray-300  dark:bg-gray-700 dark:border-gray-600">
                                <option value="">ทั้งหมด</option>
                                @foreach ($types as $type)
                                <option value="{{ $type->id }}" {{ request('type')==$type->id ? 'selected' : '' }}>
                                    {{ $type->name_th }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="relative group">
                        <label for="subtype"
                            class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5 uppercase">ประเภทย่อย</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-hover:text-red-500 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                    </path>
                                </svg>
                            </div>
                            <select id="subtype" name="subtype"
                                class="select select-bordered w-full rounded-lg border-gray-300  dark:bg-gray-700 dark:border-gray-600">
                                <option value="">ทั้งหมด</option>
                                @foreach ($subtypes as $subtype)
                                <option value="{{ $subtype->id }}"
                                    {{ request('subtype')==$subtype->id ? 'selected' : '' }}>
                                    {{ $subtype->name_th }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="relative group">
                        <label for="status"
                            class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5 uppercase">สถานะ</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-hover:text-red-500 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <select id="status" name="status"
                                class="select select-bordered w-full rounded-lg border-gray-300  dark:bg-gray-700 dark:border-gray-600">
                                <option value="">ทั้งหมด</option>
                                @foreach ($statuses as $status)
                                <option value="{{ $status['id'] }}"
                                    {{ request('status')==$status['id'] ? 'selected' : '' }}>
                                    {{ $status['name'] }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="relative group">
                        <label for="start_date"
                            class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5 uppercase">วันที่เริ่มต้น</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-hover:text-red-500 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}"
                                class="input input-bordered w-full rounded-lg border-gray-300  dark:bg-gray-700 dark:border-gray-600 placeholder-gray-400">
                        </div>
                    </div>

                    <div class="relative group">
                        <label for="end_date"
                            class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5 uppercase">วันที่สิ้นสุด</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-hover:text-red-500 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}"
                                class="input input-bordered w-full rounded-lg border-gray-300  dark:bg-gray-700 dark:border-gray-600 placeholder-gray-400">
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-between space-x-3">
                    <div class="flex space-x-3">
                        <a href="{{ route('approve.approvehrlistall.export', request()->query()) }}" class="btn btn-success btn-outline">
                            <i class="fas fa-file-excel mr-1"></i>
                            Excel
                        </a>
                        <a href="{{ route('approve.approvehrlistall.pdf', request()->query()) }}" target="_blank" class="btn btn-error btn-outline">
                            <i class="fas fa-file-pdf mr-1"></i>
                            PDF
                        </a>
                    </div>
                    <div class="flex space-x-3">

                        <a href="{{ route('approve.approvehrlistall') }}"
                            class="btn btn-secondary btn-outline text-white border border-gray-300 rounded-lg gap-2 px-5 shadow-sm transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                            ล้างค่า
                        </a>
                        <button type="submit"
                            class="btn btn-primary btn-outline text-white rounded-lg gap-2 px-6 shadow-md hover:shadow-lg transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            ค้นหาข้อมูล
                        </button>

                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class=" dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg overflow-hidden">

        <div class="overflow-x-auto">
            <table class="table table-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700">
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-300">
                            เลขที่รายการ</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-300">
                                รหัสพนักงาน
                            </th>
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
                <tbody id="hr-list-tbody">
                    @foreach ($hrrequests as $request)
                    <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="text-sm text-gray-700 dark:text-gray-300">{{ $request->request_code }}</td>
                        <td class="text-sm text-gray-700 dark:text-gray-300">{{ $request->user->employee_code }}</td>
                        <td class="text-sm text-gray-700 dark:text-gray-300">{{ $request->user->fullname }}</td>
                        <td class="text-sm text-gray-700 dark:text-gray-300">{{ $request->category->name_th ?? '-' }}</td>
                        <td class="text-sm text-gray-700 dark:text-gray-300">{{ $request->type->name_th ?? '-' }}</td>
                        <td class="text-sm text-gray-700 dark:text-gray-300">{{ $request->subtype->name_th ?? '-' }}</td>
                        <td class="text-sm text-gray-700 dark:text-gray-300">{{ $request->created_at->format('d/m/Y') }}</td>
                        <td class="text-sm">
                            <span class="px-2 py-1 rounded-full badge {{ $request->status_color }}">
                                {{ $request->status_label }}
                            </span>
                        </td>
                        <td class="text-sm text-gray-700 dark:text-gray-300">
                            <a href="{{ route('requesthr.detailhr', $request->hr_request_id ) }}"
                                class="btn btn-info btn-xs text-white hover:underline">
                                รายละเอียด
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
@push('scripts')
<script>
    (function() {
        const form = document.querySelector('form[action="{{ route('approve.approvehrlistall') }}"]');
        if (!form) return;
        const tbody = document.getElementById('hr-list-tbody');
        let debounceTimer = null;
        let activeController = null;

        function buildQuery() {
            const data = new FormData(form);
            const params = new URLSearchParams();
            for (const [key, value] of data.entries()) {
                if (value !== '') params.append(key, value.trim());
            }
            return params.toString();
        }

        function setLoading() {
            tbody.innerHTML = `<tr><td colspan="9" class="px-4 py-6 text-center text-gray-400">กำลังโหลดข้อมูล...</td></tr>`;
        }

        async function refreshTable(isDebounced = false) {
            if (!isDebounced) setLoading();
            const qs = buildQuery();
            const url = `{{ route('approve.approvehrlistall.data') }}?${qs}`;

            // update URL (no reload)
            if (window.history && window.history.replaceState) {
                const newUrl = `${location.pathname}?${qs}`;
                window.history.replaceState(null, '', newUrl);
            }

            // abort previous request
            if (activeController) activeController.abort();
            activeController = new AbortController();

            try {
                const res = await fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    signal: activeController.signal
                });
                if (!res.ok) return;
                const html = await res.text();
                tbody.innerHTML = html;
            } catch (err) {
                if (err.name !== 'AbortError') console.error(err);
            }
        }

        function debouncedRefresh() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => refreshTable(true), 250);
        }

        // Attach events: text inputs debounced, others immediate
        form.querySelectorAll('input, select').forEach(el => {
            if (el.name === 'search') {
                el.addEventListener('input', debouncedRefresh);
            } else if (el.type === 'date') {
                el.addEventListener('change', refreshTable);
            } else if (el.tagName === 'SELECT') {
                el.addEventListener('change', refreshTable);
            }
        });

        // Intercept submit (manual click)
        form.addEventListener('submit', e => {
            e.preventDefault();
            refreshTable();
        });

        // Optional: handle clear button without full reload
        const clearLink = form.parentElement.querySelector('a[href="{{ route('approve.approvehrlistall') }}"]');
        if (clearLink) {
            clearLink.addEventListener('click', e => {
                e.preventDefault();
                form.reset();
                refreshTable();
            });
        }
    })();
    </script>
@endpush
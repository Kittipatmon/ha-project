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

    <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-md overflow-hidden mb-2">
        <div class="px-6 py-2 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 flex justify-between  gap-2">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                    </path>
                </svg>
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">ตัวกรองค้นหา
                    (Search Filters)
                </h3>
            </div>
            <div class="flex items-center">
                <button type="button" data-collapse-toggle="filterFormHr" aria-expanded="true"
                    aria-controls="filterFormHr"
                    class="btn btn-sm btn-circle btn-ghost hover:bg-gray-200 dark:hover:bg-gray-700 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div class="p-3"  id="filterForm">
            <form action="{{ route('approve.approvehrlistall') }}" method="GET">
                @include('requesthr.approve.filter.filter')
            </form>
            <script>
                // filterFormHr
                document.addEventListener('DOMContentLoaded', function() {
                    const filterButton = document.querySelector('button[data-collapse-toggle="filterFormHr"]');
                    const filterForm = document.getElementById('filterForm');
                    if (filterButton && filterForm) {
                        filterButton.addEventListener('click', function() {
                            filterForm.classList.toggle('hidden');
                        });
                    }
                });
            </script>
        </div>
    </div>

    <div class=" dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg overflow-hidden">

        <div class="overflow-x-auto">
            <table class="table table-xs">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700">
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-300">
                            เลขที่รายการ</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-300">
                            รหัสผู้ขอ
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
                        <td class="text-sm text-gray-700 dark:text-gray-300">{{ $request->category->name_th ?? '-' }}
                        </td>
                        <td class="text-sm text-gray-700 dark:text-gray-300">{{ $request->type->name_th ?? '-' }}</td>
                        <td class="text-sm text-gray-700 dark:text-gray-300">{{ $request->subtype->name_th ?? '-' }}
                        </td>
                        <td class="text-sm text-gray-700 dark:text-gray-300">{{ $request->created_at->format('d/m/Y') }}
                        </td>
                        <td class="text-sm">
                            <span class="px-2 py-1 rounded-full badge {{ $request->status_color }} badge-sm">
                                {{ $request->status_label }}
                            </span>
                        </td>
                        <td class="text-sm text-gray-700 dark:text-gray-300">
                            <a href="{{ route('requesthr.detailhr', $request->hr_request_id ) }}"
                                class="btn btn-info btn-xs text-white hover:underline">
                                detail
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
        tbody.innerHTML =
            `<tr><td colspan="9" class="px-4 py-6 text-center text-gray-400">กำลังโหลดข้อมูล...</td></tr>`;
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
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
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
@extends('layouts.sidebar')
@section('title', 'ข้อมูลฝ่าย (Division)')
@section('content')
<div class="max-w-8xl rounded-xl shadow-xl">
    <div class="flex justify-between items-center">
        <!-- <h1 class="text-xl font-semibold mb-4">ข้อมูลฝ่าย (Division)</h1> -->

        <div class="mb-4">
            <button type="button" class="btn btn-success text-white" onclick="openCreateModal()">
                <i class="fa fa-plus mr-1"></i>
                สร้างฝ่ายใหม่
            </button>
        </div>
    </div>
    <div class=" dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table table-sm w-full">
                <thead class="bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-200 uppercase text-sm font-semibold">
                    <tr>
                        <th class="px-6 py-2 text-left">ลำดับ</th>
                        <th class="px-6 py-2 text-left">สายงาน</th>
                        <th class="px-6 py-2 text-left">ชื่อ(ย่อ)</th>
                        <th class="px-6 py-2 text-left">ชื่อเต็ม</th>
                        <th class="px-6 py-2 text-left">สถานะ</th>
                        <th class="px-6 py-2 text-left">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($divisions as $division)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-600 transition duration-150">
                        <td class="px-6 py-2">{{ $loop->iteration }}</td>
                        <td class="px-6 py-2">{{ $division->section->section_code ?? '-' }}</td>
                        <td class="px-6 py-2">{{ $division->division_name }}</td>
                        <td class="px-6 py-2">{{ $division->division_fullname }}</td>
                        <td class="px-6 py-2">
                            @if ($division->division_status === 0)
                                <span class="badge badge-success text-white">ใช้งาน</span>
                            @else
                                <span class="badge badge-error text-white">ไม่ใช้งาน</span>
                            @endif
                        </td>
                        <td class="px-6 py-2">
                            <button type="button" class="btn btn-sm btn-warning" onclick='openEditModal(@json($division))'>
                                <i class="fa fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-error" onclick="deleteDivision({{ $division->division_id }})">
                                    <i class="fa fa-trash"></i>
                                </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="divisionModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative top-20 mx-auto p-5  w-1/3 shadow-lg rounded-md ">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="modalTitle">
                    สร้างฝ่ายใหม่
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" onclick="closeModal()">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="p-4 md:p-5">
            <form id="divisionForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="methodField" value="POST">
                <input type="hidden" name="id" id="divisionId">

                <div class="mb-4">
                    <label for="section_id" class="block text-sm font-bold mb-2">รหัสฝ่าย:</label>
                    <select name="section_id" id="section_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="" disabled selected>-- เลือกรหัสฝ่าย --</option>
                        @foreach ($sections as $section)
                            <option value="{{ $section->section_id }}">{{ $section->section_code }} - {{ $section->section_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="division_name" class="block text-sm font-bold mb-2">ชื่อ(ย่อ):</label>
                    <input type="text" name="division_name" id="division_name" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-700" required>
                </div>
                <div class="mb-4">
                    <label for="division_fullname" class="block text-sm font-bold mb-2">ชื่อเต็ม:</label>
                    <input type="text" name="division_fullname" id="division_fullname" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-700" required>
                </div>
                <div class="mb-4">
                    <label for="division_status" class="block text-sm font-bold mb-2">สถานะ:</label>
                    <select name="division_status" id="division_status" class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-700" required>
                        <option value="0" class="text-green-600">ใช้งาน</option>
                        <option value="1" class="text-red-600">ไม่ใช้งาน</option>
                    </select>
                </div>

                <div class="flex items-center justify-end">
                    <button type="button" class="btn btn-default" onclick="closeModal()">ยกเลิก</button>
                    <button type="submit" class="btn btn-success ml-2" id="submitButton">บันทึกข้อมูล</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // ตรวจสอบว่า Flowbite Modal โหลดหรือยัง ถ้ายังให้ใช้ class hidden manual
    let modal;
    try {
        const modalElement = document.getElementById('divisionModal');
        modal = new Modal(modalElement);
    } catch (e) {
        console.warn('Flowbite modal not initialized, using fallback toggle logic.');
    }

    const form = document.getElementById('divisionForm');
    const modalTitle = document.getElementById('modalTitle');
    const methodField = document.getElementById('methodField');
    const divisionId = document.getElementById('divisionId');
    const submitButton = document.getElementById('submitButton');
    
    // แยกฟังก์ชันเปิด Modal Create
    function openCreateModal() {
        modalTitle.innerText = 'สร้างฝ่ายใหม่';
        form.action = '{{ route("divisions.store") }}';
        methodField.value = 'POST';
        divisionId.value = '';
        form.reset();
        
        // รีเซ็ต Select ให้เป็นค่า default
        document.getElementById('section_id').value = "";
        document.getElementById('division_status').value = "0";
        
        submitButton.innerText = 'บันทึก';
        showModal();
    }

    // แยกฟังก์ชันเปิด Modal Edit
    function openEditModal(division) {
        modalTitle.innerText = 'แก้ไขฝ่าย';
        // ตรวจสอบ URL ให้ถูกต้อง
        form.action = '{{ url("divisions") }}/' + division.division_id;
        methodField.value = 'PUT';
        divisionId.value = division.division_id;
        
        // Assign Values
        // จุดที่แก้ไข: ต้อง Set value ให้ Select Dropdown ด้วย
        document.getElementById('section_id').value = division.section_id; 
        document.getElementById('division_name').value = division.division_name;
        document.getElementById('division_fullname').value = division.division_fullname;
        document.getElementById('division_status').value = division.division_status;
        
        submitButton.innerText = 'บันทึกข้อมูล';
        showModal();
    }

    function showModal() {
        if(modal) {
            modal.show();
        } else {
            document.getElementById('divisionModal').classList.remove('hidden');
            document.getElementById('divisionModal').classList.add('flex');
        }
    }

    function closeModal() {
        if(modal) {
            modal.hide();
        } else {
            document.getElementById('divisionModal').classList.add('hidden');
            document.getElementById('divisionModal').classList.remove('flex');
        }
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const action = form.action;
        const formData = new FormData(form);
        // ดึงค่า method จาก hidden field ใส่เข้าไปใน formData (ถึงแม้ Laravel จะอ่าน _method ก็ตาม)
        const method = methodField.value; 

        fetch(action, {
            method: 'POST', // Browser form submit ใช้ POST เสมอ แล้ว Laravel จะดู _method เอง
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json' // บอก server ว่าขอ response เป็น json
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                closeModal();
                // อาจจะใช้ SweetAlert ตรงนี้แทนการ reload ทันทีก็ได้
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // แสดง Error message อย่างง่าย
            let msg = "เกิดข้อผิดพลาด!";
            if(error.errors) {
                msg = Object.values(error.errors).flat().join('\n');
            } else if (error.message) {
                msg = error.message;
            }
            alert(msg);
        });
    });

    function deleteDivision(id) {
        if (confirm('คุณแน่ใจหรือว่าต้องการลบฝ่ายนี้?')) {
            const formData = new FormData();
            formData.append('_method', 'DELETE');

            fetch('{{ url("divisions") }}/' + id, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('ไม่สามารถลบได้');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    }
</script>
@endpush
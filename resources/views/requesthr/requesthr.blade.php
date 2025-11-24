@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 font-prompt">
    <div class="breadcrumbs text-sm">
        <ul>
            <li><a>Home</a></li>
            <li><a href="{{ route('request.hr') }}">Request HR</a></li>
            <li>
                <a class="font-semibold text-gray-800 dark:text-red-500">
                    Request HR Form
                </a>
            </li>
        </ul>
    </div>
    <div class="border border-gray-300/60 dark:border-gray-200/40 p-4 rounded-lg shadow-xl">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold flex items-center gap-2">
                    <i class="fa-solid fa-clipboard-list text-error"></i> Request HR Form
                </h1>
                <p class="text-sm text-gray-500">แจ้งร้องขอดำเนินการเอกสารฝ่ายทรัพยากรบุคคล</p>
            </div>
            <div class="text-xs mt-2 md:mt-0 bg-red-500 text-white px-3 py-1 rounded-full font-medium shadow-sm">
                วันที่ร้องขอ: {{ date('d/m/Y') }}
            </div>
            <!-- <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-primary btn-sm text-white shadow-lg shadow-primary/30">
                    <i class="fa-solid fa-list-check"></i> Action 
                    <span class="badge badge-warning badge-sm border-0">0</span> 
                    <span class="badge badge-success badge-sm border-0 text-white">0</span>
                </div>
                <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-64 p-2 shadow-xl border border-gray-100 mt-2">
                    <li><a class="flex justify-between">รายการรออนุมัติ <span class="badge badge-warning badge-sm">0</span></a></li>
                    <li><a class="flex justify-between">รายการที่เสร็จสิ้น <span class="badge badge-success badge-sm text-white">0</span></a></li>
                    <li><a class="flex justify-between">รายการทั้งหมด <span class="badge badge-info badge-sm text-white">0</span></a></li>
                </ul>
            </div> -->
        </div>

        <div class="card bg-base-100 ">
            <div class="card-body p-2 md:p-4">
                
                <form id="hrRequestForm" enctype="multipart/form-data">
                    <div class="text-sm text-gray-500 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-circle-info text-info"></i> กรุณากรอกข้อมูลให้ครบถ้วน (<span class="text-error">*</span> จำเป็นต้องระบุ)
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="form-control w-full">
                            <label class="label font-medium">
                                <span class="label-text">ประเภทคำร้อง <span class="text-error">*</span></span>
                            </label>
                            <select id="typeSelect" class="select select-bordered w-full transition-colors">
                                <option disabled selected value="">เลือกประเภทคำร้อง</option>
                                <option value="การแจ้งแก้ไขเวลา">การแจ้งแก้ไขเวลา</option>
                                <option value="การแจ้งขอเอกสารอื่นๆ">การแจ้งขอเอกสารอื่นๆ</option>
                                <option value="การแจ้งขอเอกสาร Safety">การแจ้งขอเอกสาร Safety</option>
                            </select>
                        </div>

                        <div class="form-control w-full">
                            <label class="label font-medium">
                                <span class="label-text">ตัวเลือกการร้องขอ <span class="text-error">*</span></span>
                            </label>
                            <select id="requestSelect" class="select select-bordered w-full transition-colors" disabled>
                                <option disabled selected value="">กรุณาเลือกประเภทคำร้องก่อน</option>
                            </select>
                        </div>

                        <div id="sectionCertificate" class="hidden space-y-4">
                            <div class="form-control max-w-md">
                                <label class="label">ประเภทใบรับรอง</label>
                                <select class="select select-bordered w-full">
                                    <option disabled selected value="">เลือกประเภทใบรับรอง</option>
                                    <option value="ใบรับรองเงินเดือน">ใบรับรองเงินเดือน</option>
                                    <option value="ใบรับรองการทำงาน">ใบรับรองการทำงาน</option>
                                </select>
                            </div>
                            <div class="form-control">
                                <label class="label">เหตุผลที่ขอใบรับรอง</label>
                                <textarea class="textarea textarea-bordered w-full" placeholder="ระบุเหตุผล..."></textarea>
                            </div>
                        </div>

                        <div id="sectionWelfare" class="hidden space-y-4">
                            <div class="form-control max-w-md">
                                <label class="label">ประเภทสวัสดิการ</label>
                                <select id="welfareTypeSelect" class="select select-bordered w-full">
                                    <option disabled selected value="">เลือกประเภทสวัสดิการ</option>
                                    <option value="ค่าคลอดบุตร">ค่าคลอดบุตร</option>
                                    <option value="ค่าสมรส">ค่าสมรส</option>
                                    <option value="ค่าเจ็บป่วยในงาน">ค่าเจ็บป่วยในงาน</option>
                                    <option value="ค่าฌาปนกิจ">ค่าฌาปนกิจ</option>
                                    <option value="อื่นๆ">อื่นๆ</option>
                                </select>
                            </div>
                            <div id="welfareOtherInput" class="hidden form-control max-w-md">
                                <input type="text" class="input input-bordered w-full" placeholder="ระบุประเภทสวัสดิการอื่นๆ" />
                            </div>
                            <div class="form-control">
                                <label class="label">เหตุผลที่ขอสวัสดิการ</label>
                                <textarea class="textarea textarea-bordered w-full" placeholder="ระบุเหตุผล..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="divider"></div> -->

                    <div id="dynamicContent">

                        <div id="sectionTimeEdit" class="hidden space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label class="label font-medium">เหตุผลที่ขอดำเนินการ</label>
                                    <textarea class="textarea textarea-bordered w-full h-24" placeholder="ระบุสาเหตุ..."></textarea>
                                </div>
                                
                                <div class="form-control">
                                    <label class="label">วันที่เริ่มต้น</label>
                                    <input type="date" class="input input-bordered" />
                                </div>
                                <div class="form-control">
                                    <label class="label">เวลาเริ่มต้น</label>
                                    <input type="time" class="input input-bordered" />
                                </div>
                                
                                <div class="form-control">
                                    <label class="label">วันที่สิ้นสุด</label>
                                    <input type="date" class="input input-bordered" />
                                </div>
                                <div class="form-control">
                                    <label class="label">เวลาสิ้นสุด</label>
                                    <input type="time" class="input input-bordered" />
                                </div>
                            </div>

                            <div class="form-control mt-4">
                                <label class="label font-medium">แนบไฟล์หลักฐาน</label>
                                <div class="flex items-center gap-4">
                                    <input type="file" id="fileInput" class="file-input file-input-bordered file-input-primary w-full max-w-md" accept="image/*,application/pdf" />
                                </div>
                                <div id="filePreviewContainer" class="mt-3 hidden p-4 border rounded-lg bg-gray-50">
                                    <div class="flex items-center gap-3">
                                        <div id="fileIcon" class="text-2xl"></div>
                                        <div class="flex-1 overflow-hidden">
                                            <p id="fileName" class="text-sm font-semibold truncate"></p>
                                            <button type="button" id="btnPreviewFile" class="btn btn-xs btn-outline btn-info mt-1">ดูตัวอย่าง</button>
                                        </div>
                                        <button type="button" id="btnClearFile" class="btn btn-square btn-ghost btn-sm text-error">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="sectionUniform" class="hidden space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="form-control">
                                    <label class="label">เพศ</label>
                                    <select class="select select-bordered w-full">
                                        <option disabled selected value="">เลือกเพศ</option>
                                        <option value="ชาย">ชาย</option>
                                        <option value="หญิง">หญิง</option>
                                    </select>
                                </div>
                                <div class="form-control">
                                    <label class="label">ขนาดชุด</label>
                                    <select class="select select-bordered w-full">
                                        <option disabled selected value="">เลือกขนาด</option>
                                        <option value="S">S</option>
                                        <option value="M">M</option>
                                        <option value="L">L</option>
                                        <option value="XL">XL</option>
                                        <option value="XXL">XXL</option>
                                    </select>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="label">เหตุผลที่ขอชุด</label>
                                    <textarea class="textarea textarea-bordered w-full" placeholder="ระบุเหตุผล..."></textarea>
                                </div>
                            </div>
                        </div>

                    

                        <div id="sectionSafetyEquip" class="hidden space-y-4">
                            <label class="label font-medium">รายการอุปกรณ์ที่ร้องขอ</label>
                            
                            <div id="safetyListContainer" class="space-y-3">
                                </div>

                            <button type="button" id="btnAddSafety" class="btn btn-outline btn-info btn-sm">
                                <i class="fa-solid fa-plus"></i> เพิ่มรายการ
                            </button>
                        </div>

                        <div id="sectionSafetyReason" class="hidden space-y-4 mt-4">
                            <div class="form-control">
                                <label class="label font-medium">เหตุผลที่ขอเอกสาร Safety</label>
                                <textarea class="textarea textarea-bordered w-full h-24" placeholder="ระบุเหตุผล..."></textarea>
                            </div>
                        </div>

                    </div>

                    <div class="card-actions justify-end mt-8 pt-4 border-t border-gray-100">
                        <button type="button" class="btn btn-secondary">
                            <i class="fa-solid fa-xmark"></i> ยกเลิก
                        </button>
                        <button type="button" class="btn btn-success px-8 text-white shadow-lg shadow-primary/30" onclick="submitForm()">
                            <i class="fa-solid fa-save"></i> บันทึกข้อมูล
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<dialog id="preview_modal" class="modal">
    <div class="modal-box p-0 overflow-hidden relative max-w-3xl">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2 z-10 bg-white/50 hover:bg-white" onclick="preview_modal.close()">✕</button>
        <div class="bg-gray-100 flex justify-center items-center min-h-[300px]">
             <img id="modalPreviewImage" src="" alt="Preview" class="max-w-full max-h-[80vh] object-contain" />
        </div>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // --- Data Definitions ---
        const optionsData = {
            'การแจ้งแก้ไขเวลา': ['ลาป่วย', 'ลากิจ', 'ลาพักร้อน', 'ลืมสแกนนิ้ว', 'สแกนนิ้วไม่ติด'],
            'การแจ้งขอเอกสารอื่นๆ': ['เลือกประเภทคำร้อง', 'ใบรับรอง', 'ใบร้องขอสวัสดิการ', 'ใบร้องขอชุดยูนิฟอร์ม'],
            'การแจ้งขอเอกสาร Safety': ['เลือกประเภทคำร้อง', 'ใบร้องขออุปกรณ์ Safety', 'ใบรับรอง Safety', 'ใบขอนอนห้องพยาบาล']
        };

        // --- Element References ---
        const typeSelect = document.getElementById('typeSelect');
        const requestSelect = document.getElementById('requestSelect');
        const welfareTypeSelect = document.getElementById('welfareTypeSelect');
        const welfareOtherInput = document.getElementById('welfareOtherInput');
        
        // Sections
        const sections = {
            timeEdit: document.getElementById('sectionTimeEdit'),
            uniform: document.getElementById('sectionUniform'),
            certificate: document.getElementById('sectionCertificate'),
            welfare: document.getElementById('sectionWelfare'),
            safetyEquip: document.getElementById('sectionSafetyEquip'),
            safetyReason: document.getElementById('sectionSafetyReason')
        };

        // --- Logic: Populate Sub-Dropdown ---
        typeSelect.addEventListener('change', function() {
            const selectedType = this.value;
            requestSelect.innerHTML = '<option disabled selected value="">เลือกรายการ</option>';
            
            if (optionsData[selectedType]) {
                requestSelect.disabled = false;
                optionsData[selectedType].forEach(item => {
                    if(item !== 'เลือกประเภทคำร้อง'){ // Skip placeholder
                        const option = document.createElement('option');
                        option.value = item;
                        option.textContent = item;
                        requestSelect.appendChild(option);
                    }
                });
            } else {
                requestSelect.disabled = true;
            }
            updateVisibility(); // Reset sections
        });

        // --- Logic: Main Visibility Controller ---
        requestSelect.addEventListener('change', updateVisibility);
        
        function updateVisibility() {
            const type = typeSelect.value;
            const request = requestSelect.value;

            // Hide all sections first
            Object.values(sections).forEach(el => el.classList.add('hidden'));

            // Show sections based on logic
            if (type === 'การแจ้งแก้ไขเวลา') {
                sections.timeEdit.classList.remove('hidden');
            } else if (type === 'การแจ้งขอเอกสาร Safety') {
                 if (request === 'ใบร้องขออุปกรณ์ Safety') {
                    sections.safetyEquip.classList.remove('hidden');
                 } else {
                    sections.safetyReason.classList.remove('hidden');
                 }
            } else {
                // General Requests
                switch (request) {
                    case 'ใบร้องขอชุดยูนิฟอร์ม':
                        sections.uniform.classList.remove('hidden');
                        break;
                    case 'ใบรับรอง':
                        sections.certificate.classList.remove('hidden');
                        break;
                    case 'ใบร้องขอสวัสดิการ':
                        sections.welfare.classList.remove('hidden');
                        break;
                }
            }
        }

        // --- Logic: Welfare Other ---
        welfareTypeSelect.addEventListener('change', function() {
            if (this.value === 'อื่นๆ') {
                welfareOtherInput.classList.remove('hidden');
            } else {
                welfareOtherInput.classList.add('hidden');
            }
        });

        // --- Logic: Safety Equipment List (Dynamic) ---
        const safetyContainer = document.getElementById('safetyListContainer');
        const btnAddSafety = document.getElementById('btnAddSafety');

        function addSafetyItem() {
            const div = document.createElement('div');
            div.className = 'flex gap-2 items-center animate-fade-in-down';
            div.innerHTML = `
                <div class="relative w-full">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fa-solid fa-helmet-safety text-gray-400"></i>
                    </div>
                    <input type="text" class="input input-bordered pl-10 w-full" placeholder="ชื่ออุปกรณ์" />
                </div>
                <input type="number" min="1" value="1" class="input input-bordered w-24 text-center" />
                <button type="button" class="btn btn-square btn-outline btn-error btn-sm btn-remove-safety">
                    <i class="fa-solid fa-minus"></i>
                </button>
            `;
            
            // Add delete event to the button inside
            div.querySelector('.btn-remove-safety').addEventListener('click', function() {
                if (safetyContainer.children.length > 1) {
                    div.remove();
                } else {
                    Swal.fire({ icon: 'warning', title: 'แจ้งเตือน', text: 'ต้องมีรายการอย่างน้อย 1 รายการ', timer: 1500, showConfirmButton: false });
                }
            });

            safetyContainer.appendChild(div);
        }

        // Initialize with one item
        addSafetyItem(); 
        
        btnAddSafety.addEventListener('click', addSafetyItem);


        // --- Logic: File Preview ---
        const fileInput = document.getElementById('fileInput');
        const previewContainer = document.getElementById('filePreviewContainer');
        const fileIcon = document.getElementById('fileIcon');
        const fileName = document.getElementById('fileName');
        const btnPreviewFile = document.getElementById('btnPreviewFile');
        const btnClearFile = document.getElementById('btnClearFile');
        let currentFile = null;

        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;
            
            currentFile = file;
            fileName.textContent = file.name;
            previewContainer.classList.remove('hidden');

            if (file.type === 'application/pdf') {
                fileIcon.innerHTML = '<i class="fa-solid fa-file-pdf text-red-500"></i>';
                btnPreviewFile.onclick = () => window.open(URL.createObjectURL(file), '_blank');
            } else if (file.type.startsWith('image/')) {
                fileIcon.innerHTML = '<i class="fa-solid fa-file-image text-blue-500"></i>';
                btnPreviewFile.onclick = () => {
                    document.getElementById('modalPreviewImage').src = URL.createObjectURL(file);
                    document.getElementById('preview_modal').showModal();
                };
            } else {
                fileIcon.innerHTML = '<i class="fa-solid fa-file text-gray-500"></i>';
                btnPreviewFile.style.display = 'none';
            }
        });

        btnClearFile.addEventListener('click', function() {
            fileInput.value = '';
            currentFile = null;
            previewContainer.classList.add('hidden');
        });
    });

    // --- Global Submit Function ---
    function submitForm() {
        // Validation logic can go here
        Swal.fire({
            title: 'บันทึกข้อมูล?',
            text: "ต้องการยืนยันการทำรายการหรือไม่",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // document.getElementById('hrRequestForm').submit();
                Swal.fire('บันทึกสำเร็จ!', 'ระบบได้รับข้อมูลเรียบร้อยแล้ว', 'success');
            }
        });
    }
</script>

<style>
    /* Custom simple animation for dynamic list */
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-down {
        animation: fadeInDown 0.3s ease-out;
    }
</style>
@endpush
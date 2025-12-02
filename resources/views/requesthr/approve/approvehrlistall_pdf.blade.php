<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <title>รายงานคำร้องขอ (รอรับทราบ/อนุมัติ)</title>
    <style>
    @page {
        margin: 24px;
    }

    /* Embed TH Sarabun fonts from public/fonts */
    @font-face {
        font-family: 'THSarabun';
        font-style: normal;
        font-weight: 400;
        src: url('{{ public_path('fonts/THSarabun.ttf') }}') format('truetype');
    }

    @font-face {
        font-family: 'THSarabun';
        font-style: italic;
        font-weight: 400;
        src: url("{{ public_path('fonts/THSarabun Italic.ttf') }}") format('truetype');
    }

    @font-face {
        font-family: 'THSarabun';
        font-style: normal;
        font-weight: 700;
        src: url("{{ public_path('fonts/THSarabun Bold.ttf') }}") format('truetype');
    }

    @font-face {
        font-family: 'THSarabun';
        font-style: italic;
        font-weight: 700;
        src: url("{{ public_path('fonts/THSarabun BoldItalic.ttf') }}") format('truetype');
    }

    body {
        font-family: 'THSarabun', 'DejaVu Sans', sans-serif;
        font-size: 12px;
        color: #111;
    }

    h1 {
        font-size: 16px;
        margin: 0 0 8px;
    }

    .meta {
        font-size: 11px;
        color: #444;
        margin-bottom: 12px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #999;
        padding: 6px 8px;
    }

    th {
        background: #f0f0f0;
        text-align: left;
        font-weight: bold;
    }

    .text-center {
        text-align: center;
    }

    .small {
        font-size: 11px;
    }

    /* Dompdf-friendly four-column header row (Flex isn't supported) */
    .info-row {
        margin: 8px 0 12px;
        width: 100%;
    }

    .info-cell {
        display: inline-block;
        width: 22.5%;
        vertical-align: top;
        padding: 4px 6px;
        border: 1px solid #ccc;
        box-sizing: border-box;
        font-size: 11px;
    }

    .info-label {
        color: #666;
        margin-right: 4px;
    }
    </style>
</head>

<body>
    <h1>รายงานคำร้องขอ (รอรับทราบ/อนุมัติ)</h1>
    <div class="info-row">
        <div class="info-cell"><span class="info-label">รายการคำขอทั้งหมด:</span> {{ $totalCount ?? $hrrequests->count() }}</div>
        <div class="info-cell"><span class="info-label">รอตรวจสอบโดยผู้จัดการ:</span> {{ $statusPending }}</div>
        <div class="info-cell"><span class="info-label">รอตรวจสอบโดยฝ่ายบุคคล:</span> {{ $statusAPPROVEDHR }}</div>
        <div class="info-cell"><span class="info-label">ยกเลิก/ปฏิเสธ:</span> {{ $statusCancelled }}</div>
    </div>

    <div class="meta">พิมพ์เมื่อ: {{ $generated_at->format('d/m/Y H:i') }}</div>

    <table>
        <thead>
            <tr>
                <th style="width: 14%">เลขที่รายการ</th>
                <th style="width: 14%">รหัสพนักงาน</th>
                <th style="width: 15%">ชื่อ-สกุล</th>
                <th style="width: 16%">หมวดหมู่คำร้อง</th>
                <th style="width: 16%">ประเภทคำร้อง</th>
                <th style="width: 16%">ประเภทย่อย</th>
                <th style="width: 10%" class="text-center">วันที่ส่ง</th>
                <th style="width: 8%">สถานะ</th>
            </tr>
        </thead>
        <tbody>
            @forelse($hrrequests as $req)
            <tr>
                <td class="small">{{ $req->request_code }}</td>
                <td class="small">{{ optional($req->user)->employee_code }}</td>
                <td class="small">{{ optional($req->user)->fullname }}</td>
                <td class="small">{{ optional($req->category)->name_th ?? '-' }}</td>
                <td class="small">{{ optional($req->type)->name_th ?? '-' }}</td>
                <td class="small">{{ optional($req->subtype)->name_th ?? '-' }}</td>
                <td class="text-center small">{{ optional($req->created_at)->format('d/m/Y') }}</td>
                <td class="small">{{ $req->status_label ?? $req->status }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">ไม่พบข้อมูล</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- <div class="meta" style="margin-top: 10px;">
        หมายเหตุ: เพื่อการแสดงผลภาษาไทยที่สมบูรณ์ ควรติดตั้งฟอนต์ Sarabun ให้กับ Dompdf
    </div> -->
</body>

</html>
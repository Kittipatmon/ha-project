<?php

namespace App\Http\Controllers\backend\users;
use App\Http\Controllers\Controller;

use App\Models\Department;
use App\Models\Division;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    // API: รองรับฟิลเตอร์แบบเดียวกับหน้าเว็บ
    public function apiUsers(Request $request)
    {
        // ส่งกลับเป็นรูปแบบ paginate เพื่อให้ frontend ใช้ข้อมูลหน้า/ลิงก์ได้
        $perPage = (int) $request->input('per_page', 20);
        // กันค่าแปลกๆ
        $perPage = max(1, min($perPage, 100));

        $users = $this->filteredUsers($request)
            ->paginate($perPage)
            ->appends($request->query());


        return response()->json($users);
    }

    public function profileUser(){
        // Get the currently authenticated user as a single model instance
        $user = Auth::user();

        // If not authenticated, redirect to login (or handle as you prefer)
        if (!$user) {
            return redirect()->route('login');
        }

        // Pass a single $user to the view
        return view('backend.users.profile', compact('user'));
    }

    // หน้าเว็บ: แสดงผลแบบ paginate + ส่งค่ากลับไปเติมในฟอร์ม
    public function index(Request $request)
    {
        $users = $this->filteredUsers($request)->paginate(20)->withQueryString();
        
        $departments = Department::all();
        $divisions = Division::all();
        $sections = Section::all();

        return view('backend.users.index', compact('users', 'departments', 'divisions', 'sections'));
    }

    /**
     * Core filter (ใช้ร่วมกันทั้ง apiUsers และ index)
     * @param  Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function filteredUsers(Request $request)
    {
        $query = User::with(['department', 'division', 'section']);

        $simpleFilters = [
            'employee_code' => 'like',
            'prefix'        => 'like',
            'position'      => 'like',
            'level_user'    => '=',
        ];

        foreach ($simpleFilters as $field => $operator) {
            if ($request->filled($field)) {
                $value = trim($request->input($field));
                $query->where($field, $operator, ($operator === 'like' ? "%{$value}%" : $value));
            }
        }

        if ($request->filled('fullname')) {
            $name = trim($request->input('fullname'));
            $query->where(function ($q) use ($name) {
                $q->where('first_name', 'like', "%{$name}%")
                  ->orWhere('last_name', 'like', "%{$name}%")
                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$name}%"]);
            });
        }

        $relations = [
            'department' => ['name' => 'department_name', 'code' => 'department_code'],
            'division'   => ['name' => 'division_name',   'code' => 'division_code'],
            'section'    => ['name' => 'section_name',    'code' => 'section_code'],
        ];

        foreach ($relations as $relation => $fields) {
            if ($request->filled($relation)) {
                $value = $request->input($relation);
                if (is_numeric($value)) {
                    $query->where("{$relation}_id", (int)$value);
                } else {
                    $query->whereHas($relation, function ($q) use ($fields, $value) {
                        $q->where($fields['name'], 'like', "%{$value}%")
                          ->orWhere($fields['code'], 'like', "%{$value}%");
                    });
                }
            }
        }

        $from = $request->input('startwork_date_from');
        $to   = $request->input('startwork_date_to');

        if ($from && $to) {
            $query->whereBetween('startwork_date', [
                Carbon::parse($from)->startOfDay(),
                Carbon::parse($to)->endOfDay()
            ]);
        } elseif ($from) {
            $query->whereDate('startwork_date', '>=', Carbon::parse($from));
        } elseif ($to) {
            $query->whereDate('startwork_date', '<=', Carbon::parse($to));
        }

        // เรียงล่าสุดเข้าเริ่มงานก่อน (ปรับได้ตามต้องการ)
        $query->orderByDesc('startwork_date')->orderBy('employee_code');

        return $query;
    }

public function store(Request $request)
{
    // 1. กำหนดกฎการตรวจสอบข้อมูล (Validation Rules)
    $validator = Validator::make($request->all(), [
        // ใช้ตารางและคอนเนกชันที่ถูกต้องตาม Model: userkml2025.userskml
        'employee_code' => 'required|unique:userkml2025.userskml,employee_code|max:50',
        'sex'           => 'required|string|max:20',
        'prefix'        => 'required|string|max:50',
        'first_name'    => 'required|string|max:255',
        'last_name'     => 'required|string|max:255',
        'position'      => 'nullable|string|max:255',
        // ระบุคอนเนกชันให้ตรง (ในกรณีที่ตารางอยู่ในคอนเนกชันเดียวกันกับ userskml)
        'department_id' => 'nullable|exists:userkml2025.departments,department_id',
        'division_id'   => 'nullable|exists:userkml2025.divisions,division_id',
        'section_id'    => 'nullable|exists:userkml2025.sections,section_id',
        'level_user'    => 'required|string',
        'hr_status'     => 'required|string',
        // 'startwork_date' => 'nullable|date', // หากมีการเปิดใช้ input นี้
    ], [
        // กำหนดข้อความ Error ภาษาไทย (Optional)
        'employee_code.unique' => 'รหัสพนักงานนี้มีอยู่ในระบบแล้ว',
        'employee_code.required' => 'กรุณาระบุรหัสพนักงาน',
        'first_name.required' => 'กรุณาระบุชื่อจริง',
        // ... เพิ่มตามต้องการ
    ]);

    // ถ้า Validation ไม่ผ่าน ให้ส่ง Error กลับไปเป็น JSON (Status 422)
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // 2. เริ่มต้น Transaction เพื่อความปลอดภัยของข้อมูล
    DB::beginTransaction();

    try {
        // เตรียมข้อมูล Fullname
        // $fullname = trim($request->prefix . ' ' . $request->first_name . ' ' . $request->last_name);

        // สร้าง User ใหม่
        $user = new User();
        $user->employee_code = $request->employee_code;
        $user->sex = $request->sex;
        $user->prefix = $request->prefix;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        // $user->fullname = $fullname; // บันทึกชื่อเต็ม
        
        $user->position = $request->position;
        $user->department_id = $request->department_id;
        $user->division_id = $request->division_id;
        $user->section_id = $request->section_id;
        
        $user->level_user = $request->level_user;
        $user->hr_status = $request->hr_status;
        
        // จัดการวันที่ (ถ้ามี)
        if ($request->has('startwork_date')) {
            $user->startwork_date = $request->startwork_date;
        } else {
            // Default วันปัจจุบัน หรือ null ตาม business logic
            $user->startwork_date = now(); 
        }

        // --- ส่วนจัดการ Auth (Email/Password) ---
        // กรณีตาราง Users บังคับ Email แต่ใน Form ไม่มี -> สร้าง Dummy Email
        // $user->email = $request->employee_code . '@example.com'; 
        
        // ตั้งรหัสผ่านเริ่มต้น (Default Password) 
        // เช่นใช้รหัสพนักงาน หรือ '12345678'
        // $user->password = Hash::make($request->employee_code); // หรือ Hash::make('12345678');

        $user->save();

        // Commit ข้อมูลลง Database
        DB::commit();

        // ส่ง Response กลับเป็น JSON (Status 200)
        return response()->json([
            'status' => 'success',
            'message' => 'บันทึกข้อมูลพนักงานเรียบร้อยแล้ว',
            'data' => $user
        ], 200);

    } catch (\Exception $e) {
        // ถ้ามี Error ให้ Rollback ข้อมูล
        DB::rollBack();

        // ส่ง Error กลับเป็น JSON (Status 500)
        return response()->json([
            'status' => 'error',
            'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()
        ], 500);
    }
}

    // Proxy for legacy route name users.storeUser
    public function storeUser(Request $request)
    {
        return $this->store($request);
    }

}

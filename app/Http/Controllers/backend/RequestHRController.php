<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;

class RequestHRController extends Controller
{
    public function welcomeRequest()
    {
        $breadcrumbs = [
            // ['label' => 'หน้าหลัก', 'url' => route('dashboard')],
            ['label' => 'งานบริการ', 'url' => route('welcome.system')],
            ['label' => 'Request HR', 'url' => null],
        ];
        return view('requesthr.welcomerequest', compact('breadcrumbs'));
    }

    public function requestHR()
    {
        return view('requesthr.requesthr');
    }
}

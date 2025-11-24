<?php

namespace App\Http\Controllers\backend\requestdata;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Division;

class DivisionController extends Controller
{
    public function apiDivision()
    {
        return response()->json(Division::all());
    }

    public function index()
    {
        $divisions = Division::all();
        return view('backend.division.index', compact('divisions'));
    }
}

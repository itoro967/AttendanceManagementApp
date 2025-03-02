<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function login()
    {
        return view('auth.loginAdmin');
    }

    public function attendanceList(Request $request)
    {
        $date = $request->input('date', today()->format('Y-m-d'));
        $users = User::all();
        $subquery = Work::where('date', $date)->groupBy('user_id')->selectRaw('user_id, max(type) as max_type');
        $works = Work::joinSub($subquery, 'sub', function ($join) {
            $join->on('works.user_id', 'sub.user_id')->on('works.type', 'sub.max_type');
        })->where('works.date', $date)->get();
        return view('attendancelistAmin', compact('works', 'date', 'users'));
    }
}

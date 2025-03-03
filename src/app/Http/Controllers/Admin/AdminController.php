<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Work;
use Illuminate\Http\Request;

#管理者用コントローラー
class AdminController extends Controller
{
    public function login()
    {
        return view('auth.loginAdmin');
    }
    #勤怠一覧(日単位)
    public function attendanceList(Request $request)
    {
        $date = $request->input('date', today()->format('Y-m-d'));
        $staffs = User::all();
        $subquery = Work::where('date', $date)->groupBy('user_id')->selectRaw('user_id, max(type) as max_type');
        $works = Work::joinSub($subquery, 'sub', function ($join) {
            $join->on('works.user_id', 'sub.user_id')->on('works.type', 'sub.max_type');
        })->where('works.date', $date)->get();
        return view('admin.attendanceListAdmin', compact('works', 'date', 'staffs'));
    }
    #スタッフの勤怠詳細
    public function attendanceDetail(string $id)
    {
        $work = Work::with('user')->find($id);
        return view('admin.attendanceDetail', compact('work'));
    }
}

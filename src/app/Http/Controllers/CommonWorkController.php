<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Support\Facades\Auth;

#勤怠情報を扱うコントローラー
class CommonWorkController extends Controller
{
    #勤怠詳細
    public function detail(string $id)
    {
        if (Auth::user()->is_admin) {
            $work = Work::with('user')->find($id);
            return view('admin.attendanceDetail', compact('work'));
        } else {
            $work = Auth::user()->works->find($id);
            return view('staff.attendanceDetail', compact('work'));
        }
    }
}

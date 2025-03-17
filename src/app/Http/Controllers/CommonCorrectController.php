<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

# 修正コントローラ
class CommonCorrectController extends Controller
{
    public function list(Request $request)
    {
        $is_confirmed = $request->input('confirmed') ?? 0;
        if (Auth::user()->is_admin) {
            $corrects = Work::where('type', '<>', 0)->where('is_confirmed', $is_confirmed)->with('user')->get();
            return view('admin.correctList', compact('corrects'));
        } else {
            $corrects = Auth::user()->works()->where('type', '<>', 0)->where('is_confirmed', $is_confirmed)->with('user')->get();
            return view('staff.correctList', compact('corrects'));
        }
    }
}

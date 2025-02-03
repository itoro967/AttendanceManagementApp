<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Work;
use Illuminate\Support\Facades\Auth;

class WorkController extends Controller
{
    public function attendance(Request $request)
    {
        $state = $request->input('state');
        $is_work = Work::Today()->exists();
        #出社
        if ($state == '1' and !$is_work) {
            Work::create(['user_id' => Auth::user()->id, 'date' => today(), 'begin_at' => now()]);
        }
        #退勤
        elseif ($state == '0' and $is_work) {
            Work::Today()->update(['finish_at' => now()]);
            $state = 9;
        }
        #退勤済
        elseif (isset(Work::Today()->first()->finish_at)) {
            $state = 9;
        }
        return view('attendance', compact('state'));
    }
}

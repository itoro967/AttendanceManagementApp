<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Work;
use Illuminate\Support\Facades\Auth;

class WorkController extends Controller
{
    private function state_check()
    {
        $is_work = Work::Today()->exists();
        if ($is_work) {
            $is_finish = isset(Work::Today()->first()->finish_at);
            $rests = Work::Today()->first()->rests();
            if ($rests->first())
                $is_resting = !isset($rests->latest()->first()->finish_at);
            else
                $is_resting = false;
        }

        if (!$is_work)
            $state = 0;
        elseif ($is_work && !$is_finish && !$is_resting)
            $state = 1;
        elseif ($is_work && !$is_finish && $is_resting)
            $state = 2;
        elseif ($is_finish)
            $state = 9;

        return $state;
    }
    #state 0:未出社 1:出社 2:休憩中 9:退勤 
    public function attendance()
    {
        $state = $this->state_check();
        return view('attendance', compact('state'));
    }
    public function punch(Request $request)
    {
        $state = $this->state_check();
        $punch = $request->input('punch');
        #出社
        if ($punch == '1' and $state == 0) {
            Work::create(['user_id' => Auth::user()->id, 'date' => today(), 'begin_at' => now()]);
            $state = 1;
        }
        #休憩入
        elseif ($punch == '2' and $state == 1) {
            Work::Today()->first()->rests()->create(['begin_at' => now()]);
            $state = 2;
        }
        #休憩戻
        elseif ($punch == '3' and $state == 2) {
            Work::Today()->first()->rests()->latest()->first()->update(['finish_at' => now()]);
            $state = 1;
        }
        #退勤
        elseif ($punch == '9' and $state == 1) {
            Work::Today()->update(['finish_at' => now()]);
            $state = 9;
        }
        return view('attendance', compact('state'));
    }
}

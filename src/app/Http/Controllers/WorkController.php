<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Work;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;

class WorkController extends Controller
{
    private function stateCheck()
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
        $state = $this->stateCheck();
        return view('attendance', compact('state'));
    }

    public function punch(Request $request)
    {
        $state = $this->stateCheck();
        $punch = $request->input('punch');
        #出社
        if ($punch == '1' and $state == 0) {
            Work::create(['user_id' => Auth::user()->id, 'date' => today(), 'begin_at' => now(), 'type' => 0]);
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
    public function attendanceList(Request $request)
    {
        $month = $request->input('month', today()->format('Y-m'));
        $CarbonMonth = new Carbon($month);

        $startOfMonth = $CarbonMonth->startOfMonth()->toDateString();
        $endOfMonth = $CarbonMonth->endOfMonth()->toDateString();
        $periods = CarbonPeriod::create($startOfMonth, $endOfMonth)->toArray();

        #日付毎の最大typeを取得
        $subQuery = Auth()->user()->works()->selectRaw('date as d,MAX(type) as t')
            ->whereYear('date', '=', substr($month, 0, 4))
            ->whereMonth('date', '=', substr($month, 5, 2))->groupBy('date');

        $works = Auth()->user()->works()->joinSub($subQuery, 'max_works', function ($join) {
            $join->on('works.type', '=', 'max_works.t')
                ->on('works.date', '=', 'max_works.d');
        })->get();

        return view('attendancelist', compact('works', 'month', 'periods'));
    }
    public function detail(string $id)
    {
        $work = Work::find($id);
        return view('attendanceDetail', compact('work'));
    }
}

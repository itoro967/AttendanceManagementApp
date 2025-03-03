<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;

#勤怠情報を扱うコントローラー
class WorkController extends Controller
{
    #勤怠一覧
    public function list(Request $request)
    {
        $month = $request->input('month', today()->format('Y-m'));
        $CarbonMonth = new Carbon($month);

        $startOfMonth = $CarbonMonth->startOfMonth()->toDateString();
        $endOfMonth = $CarbonMonth->endOfMonth()->toDateString();
        $periods = CarbonPeriod::create($startOfMonth, $endOfMonth)->toArray();

        #日付毎の最大typeを取得
        $subQuery = Auth::user()->works()->selectRaw('date as d,MAX(type) as t')
            ->whereYear('date', '=', substr($month, 0, 4))
            ->whereMonth('date', '=', substr($month, 5, 2))->groupBy('date');

        $works = Auth::user()->works()->joinSub($subQuery, 'max_works', function ($join) {
            $join->on('works.type', '=', 'max_works.t')
                ->on('works.date', '=', 'max_works.d');
        })->get();

        return view('staff.attendanceList', compact('works', 'month', 'periods'));
    }
    #勤怠詳細
    public function detail(string $id)
    {
        $work = Auth::user()->works->find($id);
        return view('staff.attendanceDetail', compact('work'));
    }
}

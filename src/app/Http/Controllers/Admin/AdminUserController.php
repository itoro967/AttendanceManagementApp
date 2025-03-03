<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    #スタッフ一覧
    public function list()
    {
        $staffs = User::all();
        return view('admin.staffList', compact('staffs'));
    }
    #特定ユーザーの勤怠一覧
    public function detail(Request $request, string $id)
    {
        $month = $request->input('month', today()->format('Y-m'));
        $CarbonMonth = new Carbon($month);

        $startOfMonth = $CarbonMonth->startOfMonth()->toDateString();
        $endOfMonth = $CarbonMonth->endOfMonth()->toDateString();
        $periods = CarbonPeriod::create($startOfMonth, $endOfMonth)->toArray();

        $staff = User::find($id);
        #日付毎の最大typeを取得
        $subQuery = $staff->works()->selectRaw('date as d,MAX(type) as t')
            ->whereYear('date', '=', substr($month, 0, 4))
            ->whereMonth('date', '=', substr($month, 5, 2))->groupBy('date');

        $works = $staff->works()->joinSub($subQuery, 'max_works', function ($join) {
            $join->on('works.type', '=', 'max_works.t')
                ->on('works.date', '=', 'max_works.d');
        })->get();
        return view('admin.staffAttendanceList', compact('works', 'month', 'periods'));
    }
}

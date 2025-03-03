<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

# 修正コントローラ
class CorrectController extends Controller
{
    public function correct(Request $request)
    {
        $work_data = $request->only(['date', 'begin_at', 'finish_at', 'type', 'note', 'work_id']);
        $work_data['user_id'] = Auth::user()->id;
        $work_data['is_confirmed'] = false;
        $rest_data_list = $request->input('rest');
        $work = Work::create($work_data);
        foreach ($rest_data_list as $rest_data) {
            $work->rests()->create($rest_data);
        }
        return redirect()->route('staff.attendanceList');
    }
    public function list(Request $request)
    {
        $is_confirmed = $request->input('confirmed') ?? 0;
        $corrects = Auth::user()->works()->where('type', '<>', 0)->where('is_confirmed', $is_confirmed)->with('user')->get();
        return view('staff.correctList', compact('corrects'));
    }
}

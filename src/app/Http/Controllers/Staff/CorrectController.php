<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\CorrectPostRequest;
use App\Models\Work;
use Illuminate\Support\Facades\Auth;

# 修正コントローラ
class CorrectController extends Controller
{
    public function correct(CorrectPostRequest $request)
    {
        $work_data = $request->only(['date', 'begin_at', 'finish_at', 'type', 'note', 'work_id']);
        $work_data['user_id'] = Auth::user()->id;
        $work_data['is_confirmed'] = false;
        $rest_data_list = $request->input('rest',[]);
        $work = Work::create($work_data);
        foreach ($rest_data_list as $rest_data) {
            $work->rests()->create($rest_data);
        }
        return redirect()->route('staff.attendanceList')->with('message','申請完了');
    }
}

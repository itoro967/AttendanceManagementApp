<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

# 修正コントローラ
class AdminCorrectController extends Controller
{
    public function correct(Request $request)
    {
        $work_data = $request->only(['date', 'begin_at', 'finish_at', 'type', 'note', 'work_id']);
        $rest_data_list = $request->input('rest');

        $work = Work::find($work_data['work_id']);
        $work->update($work_data);

        foreach ($rest_data_list as $rest_data) {
            $rest = $work->rests()->find($rest_data['rest_id']);
            $rest->update($rest_data);
        }
        return redirect()->back();
    }
    public function list(Request $request)
    {
        $is_confirmed = $request->input('confirmed') ?? 0;
        $corrects = Auth::user()->works()->where('type', '<>', 0)->where('is_confirmed', $is_confirmed)->with('user')->get();
        return view('staff.correctList', compact('corrects'));
    }
}

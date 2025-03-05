<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CorrectPostRequest;
use App\Models\Work;
use Illuminate\Http\Request;

# 修正コントローラ
class AdminCorrectController extends Controller
{
    public function correct(CorrectPostRequest $request)
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
    public function correctConfirm(Request $request, string $id)
    {
        $work = Work::find($id);
        return view('admin.correctConfirmAdmin', compact('work'));
    }
    public function confirm(Request $request)
    {
        $id = $request->input('work_id');

        $work = Work::find($id);
        $work->is_confirmed = true;
        $work->update();
        return redirect()->route('correctList');
    }
}

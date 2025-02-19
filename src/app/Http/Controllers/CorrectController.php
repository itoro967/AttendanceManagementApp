<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return redirect('/attendance/list');
    }
}

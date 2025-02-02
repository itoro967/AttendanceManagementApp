<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOption\None;

class WorkController extends Controller
{
    public function attendance(Request $request)
    {
        $work = $request->input('work');
        if ($work == '1')
            $state = 1;
        elseif ($work == '0' or $work == null)
            $state = 0;
        elseif ($work == '2')
            $state = 2;
        return view('attendance', compact('state'));
    }
}

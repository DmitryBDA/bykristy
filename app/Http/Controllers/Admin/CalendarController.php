<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Record;
use Illuminate\Support\Carbon;

class CalendarController extends Controller
{
    public function index()
    {
        return view('admin.pages.calendar');
    }

    public function records()
    {
        header('Content-type: application/json');
        $tekDate = Carbon::today()->format('Y-m-d');

        $data = Record::whereDate('start', '>=', $tekDate)->orderBy('start', 'asc')->get(['id', 'title', 'start', 'end', 'status', 'all_day']);

        foreach ($data as $elem) {
            switch ($elem->status){
                case 1:
                    $elem->setAttr('className', "greenEvent");break;
                Case 2:
                    $elem->setAttr('className', "yellowEvent");break;
                Case 3:
                    $elem->setAttr('className', "redEvent");break;
                Case 4:
                    $elem->setAttr('className', "greyEvent");break;
            }
        }

        return response()->json($data);
    }
}

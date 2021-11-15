<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Record;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

    public function createRecords(Request $request)
    {

        $arrTimeRecords = $request->timeRecords;

        foreach ($arrTimeRecords as $Event) {

            if(!$Event) continue;

            $date = $request->date . ' ' . $Event['value'];
            $arrData = [
                'title' => isset($Event['title']) ? $Event['title']: '',
                'start' => $date,
                'end' => $date,
                'status' => isset($Event['status']) ? $Event['status']: 1
            ];
            $event = Record::create($arrData);
        }

        return response()->json($event);
    }

    public function showActionRecord(Request $request)
    {
        $record = Record::with('user')->with('service')->find($request->recordId);

        $moreRecords = null;

        $userId = $record->user_id;
        if($userId){
            $tekDate = Carbon::today()->format('Y-m-d');
            $eventList = Record::where('start', '>=', $tekDate)->where('user_id', $userId)->where('id', '!=',$record->id)->with('user')->orderBy('start', 'asc')->get();

            if(isset($eventList) and $eventList->isNotEmpty() ){
                $moreRecords = $eventList;
            }
        }
        $services = Service::all();
        return view('admin.modal.ajax.action-record', compact('record', 'services', 'moreRecords'))->render();

    }

    public function recordUser(Request $request)
    {
        $arrDataForm = $request->dataForm;
        $recordId = $request->recordId;



        $arFio = explode(" ", $arrDataForm[2]['value']);
        $surname = $arFio[0];
        $name = $arFio[1];
        $phone = $arrDataForm[3]['value'];
        $phone = str_replace(['(', ')', " ", '-'],'', $phone );

        $obUser = User::where('phone', $phone)->get()->first();

        if(empty($obUser)){
            $lastId = User::orderBy('id', 'desc')->get()->first()->id;
            $lastId++;
            $dataUser = [
                'name' => $name,
                'surname' => $surname,
                'phone' => $phone,
                'password' => Hash::make(Str::random(8)),
                'email' => "user$lastId@user.com",
            ];
            $obUser = User::create($dataUser);
        }
        $userId = $obUser->id;

        $data = [
            'user_id' => $userId,
            'service_id' => $arrDataForm[1]['value'],
            'status' => 3
        ];

        $obRecord = Record::find($recordId);
        $obRecord->update($data);

    }

    public function actionRecord(Request $request)
    {
        switch ($request->type) {

            case 'confirm':

                $dataUpdate = [
                    'status' => 3,
                ];

                $record = Record::find($request->recordId)->update($dataUpdate);

                return response()->json($record);
                break;

            case 'close':

                $record = Record::find($request->recordId)->update([
                    'status' => 1,
                    'user_id' => null,
                    'service_id' => null,
                ]);

                return response()->json($record);
                break;

            case 'delete':

                $record = Record::find($request->recordId)->delete();
                return response()->json($record);
                break;
        }
    }

    public function updateDateRecord(Request $request)
    {

        $recordId = $request->recordId;

        $newDate = Carbon::create($request->newDate)->format('Y-m-d');

        $obRecord = Record::find($recordId);
        $time = Carbon::create($obRecord->start)->format('H:i');

        $strNewDate = $newDate . ' ' . $time;
        $upgradeDate = Carbon::create($strNewDate)->format('Y-m-d H:i');

        $updateArr = ['start' => $upgradeDate, 'end' => $upgradeDate];
        $obRecord->update($updateArr);
        return response()->json($obRecord);

    }
}

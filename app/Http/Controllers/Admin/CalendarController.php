<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Record;
use App\Models\Service;
use App\Models\User;
use App\Repositories\RecordRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CalendarController extends Controller
{
    private $recordRepository;
    public function __construct()
    {
        $this->recordRepository = app(RecordRepository::class);
    }

    public function index()
    {
        //Получить все записи (события)
        $eventList = $this->recordRepository->getActiveRecords();

        return view('admin.pages.calendar', compact('eventList'));
    }

    public function records()
    {
        header('Content-type: application/json');

        $data = $this->recordRepository->getRecords();

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

        $TimeRecord = $arrDataForm[0]['value'];

        $obRecord = Record::find($recordId);
        $date = Carbon::create($obRecord->start)->format('Y-m-d') . ' ' . $TimeRecord;

        if($arrDataForm[0]['name'] !== 'myself_time' && $arrDataForm[1]['value'] && $arrDataForm[2]['value'] && $arrDataForm[3]['value']){
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
                'start' => $date,
                'end' => $date,
                'user_id' => $userId,
                'service_id' => $arrDataForm[1]['value'],
                'status' => $obRecord->status == 1 ? 3: $obRecord->status,
            ];
        }elseif($arrDataForm[0]['name'] === 'myself_time') {
            $data = [
                'start' => $date,
                'end' => $date,
                'title' => $arrDataForm[1]['value'],
            ];
        } else {
            $data = [
                'start' => $date,
                'end' => $date,
            ];
        }

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

    public function autocompletionInput(Request $request)
    {
        $strSearch = $request->input('query');
        $countWords = count(preg_split('/\s+/u', $strSearch, null, PREG_SPLIT_NO_EMPTY));
        $arr = [];
        if($countWords == 1){
            $result = User::select('name', 'surname')
                ->where('name', 'LIKE', "%{$request->input('query')}%")
                ->orWhere('surname', 'LIKE', "%{$request->input('query')}%")
                ->get();
            if(!$result->isEmpty()){
                foreach ($result as $item)
                {
                    $arr[]['name'] =  $item->surname . ' ' . $item->name;
                }
            } else {
                $arr[]['name'] = '';
            }
        }

        return response()->json($arr);
    }

    public function searchPhone(Request $request){
        $name = $request->name;
        $arrNameAndSurname = explode(' ', $name);
        if(count($arrNameAndSurname) == 2){
            $result = User::select('phone')->where('surname', $arrNameAndSurname[0])->where('name', $arrNameAndSurname[1])->get();

            if($result->count() == 1){
                return response()->json($result->first()->phone);
            } else {
                return response()->json('error');
            }
        }
    }
}

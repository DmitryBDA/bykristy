<?php

namespace App\Repositories;

use App\Models\Record as Model;
use Illuminate\Support\Carbon;

class RecordRepository extends CoreRepository
{

  protected function getModelClass()
  {
    return Model::class;
  }

  /**
   * @return mixed
   */
  public function getActiveRecords()
  {
      $tekDate = Carbon::today()->format('Y-m-d');

      $data = $this->startCondition()
          ->whereDate('start', '>=', $tekDate)
          ->orderBy('start', 'asc')
          ->get(['id', 'title', 'start', 'end', 'status', 'all_day']);

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
      return $data;
  }
}


<form class="form-horizontal _form_for_record" data-record-id="@isset($record){{$record->id}}@endisset">
    <div class="card-body">
        @isset($record)
            <p>Выбранный день: {{ Date::parse($record->start)->format('j.m.Y (D)')}}</p>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Время</label>
                @if($record->status == 4)
                    <div class="input-group col-sm-10 mb-3 ">
                        <input type="time" name="myself_time" class="form-control"
                               value="{{ Date::parse($record->start)->format('H:i')}}">
                        <input type="text" name="myself_time" class="form-control" value="{{ $record->title }}">
                    </div>
                @else
                    <div class="col-sm-10">
                        <input type="time" class="form-control" name="time"
                               value="{{ Date::parse($record->start)->format('H:i')}}">
                    </div>
                @endif


            </div>

            @if($record->status != 4)
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Услуга</label>
                    <div class="col-sm-10">
                        <select name="service" class="form-control" required="">
                            <option value="" selected="">Не выбрано</option>
                            @isset($services)
                                @foreach($services as $service)
                                    <option @if( $record->service_id == $service->id ) selected
                                            @endif value="{{$service->id}}">{{$service->name}}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Имя</label>
                    <div class="col-sm-10">
                        <input  type="text" class="form-control add_name" name="name" autocomplete="off"
                               value="@if($record->user){{$record->user->surname}} {{$record->user->name}}@endif">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Телефон</label>
                    <div class="col-sm-10">
                        <input type="text" name="phone" class="form-control" data-inputmask='"mask": "(999) 999-9999"'
                               data-mask inputmode="text"
                               value="@if($record->user){{$record->user->phone}}@endif">
                    </div>
                </div>
            @endif
            @isset($moreRecords)
                <div class="col-sm-12">
                    <h5>Так же записан</h5>
                    @foreach($moreRecords as $item)
                        <p>{{ Date::parse($item->start)->format('Дата: j.m.Y Время: H:i')}}</p>
                    @endforeach
                </div>
            @endisset
        @endisset

    </div>
    <!-- /.card-body -->
    @isset($record)
        <div class="card-footer">
            @switch($record->status)
                @case(1)
                <button type="submit" class="btn btn-info _add_user_on_record">Записать</button> @break
                @case(2)
                <button data-record-id="{{$record->id}}" type="button" class="btn btn-info _confirm_record">Подтвердить</button>
                <button data-record-id="{{$record->id}}" type="button" class="btn btn-info _close_record">Отменить</button> @break
                @case(3)
                <button data-record-id="{{$record->id}}" type="button" class="btn btn-info _close_record">Отменить</button> @break
            @endswitch
            <button data-record-id="{{$record->id}}" type="button" class="btn btn-danger float-right _delete_record">Удалить</button>
        </div>
    @endisset
<!-- /.card-footer -->
</form>

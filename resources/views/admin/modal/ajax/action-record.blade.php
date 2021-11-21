
<form class="form-horizontal _form_for_record" data-record-id="@isset($record){{$record->id}}@endisset">
    <div class="card-body">
        @isset($record)
            <p>Выбранный день: {{ Date::parse($record->start)->format('j.m.Y (D)')}}</p>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Время</label>
                @if($record->status == 4)
                    <div class="input-group col-sm-10 mb-3 ">
                        <input type="time" name="myself_time" class="form-control _input_form_for_record"
                               value="{{ Date::parse($record->start)->format('H:i')}}">
                        <input type="text" name="myself_time" class="form-control _input_form_for_record" value="{{ $record->title }}">
                    </div>
                @else
                    <div class="col-sm-10">
                        <input type="time" class="form-control _input_form_for_record" name="time"
                               value="{{ Date::parse($record->start)->format('H:i')}}">
                    </div>
                @endif


            </div>

            @if($record->status != 4)
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Услуга</label>
                    <div class="col-sm-10">
                        <select name="service" class="form-control _input_form_for_record">
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
                        <input  type="text" class="form-control add_name _input_form_for_record" name="name" autocomplete="off"
                               value="@if($record->user){{$record->user->surname}} {{$record->user->name}}@endif">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Телефон</label>
                    <div class="input-group mb-3 col-sm-10">
                        <input type="text" name="phone" class="form-control _paste_phone_auto _input_form_for_record" data-inputmask='"mask": "(999) 999-9999"'
                               data-mask inputmode="text"
                               value="@if($record->user){{$record->user->phone}}@endif">
                        @if($record->user)
                        <a href="whatsapp://send?phone=+7{{$record->user->phone}}" class="input-group-append">
                            <span class="input-group-text _messenger_click"><i class="fa fa-whatsapp" aria-hidden="true"></i></span>
                        </a>
                        <a href="tel:+7{{$record->user->phone}}" class="input-group-append ">
                            <span class="input-group-text _messenger_click"><i class="fa fa-volume-control-phone" aria-hidden="true"></i></span>
                        </a>
                        @endif
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
                <button style="display: none" data-record-id="{{$record->id}}" type="submit" class="btn btn-success float-center _save_change_record">Сохранить</button>
            <button data-record-id="{{$record->id}}" type="button" class="btn btn-danger float-right _delete_record">Удалить</button>
        </div>
    @endisset
<!-- /.card-footer -->
</form>

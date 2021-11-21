@if($eventList->isNotEmpty())
<table class="table">
    <thead>
    <tr>
        <th>Дата</th>
        <th>Имя</th>
        <th>Действие</th>
    </tr>
    </thead>
    <tbody>
    @foreach($eventList as $event)
        <tr>

            <td style="padding: 9px">{{ Date::parse($event->start)->format('j.m H:i (D)')}}</td>
            <td style="padding: 9px">@if($event->user)
                    {{$event->user->name}} {{$event->user->surname}}
                @endif
            </td>
            <td class="w-33" style="vertical-align: middle; padding: 9px">
                <a style="float:left; width: 50%" href="whatsapp://send?phone=+79149098288" class="input-group-append">
                    <span class="input-group-text _messenger_click"><i class="fa fa-whatsapp" aria-hidden="true"></i></span>
                </a>
                <a style="float:left; width: 50%    "  href="tel:+79149098288" class="input-group-append ">
                    <span class="input-group-text _messenger_click"><i class="fa fa-volume-control-phone" aria-hidden="true"></i></span>
                </a>
            </td>

        </tr>
    @endforeach
    </tbody>
</table>
@else
    <div class="form-group mt-2 mr-2 ml-2">
        Совпадений не найдено
    </div>
@endif

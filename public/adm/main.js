$(function () {

    const inputTimeRecord = "<div class=\"input-group mb-3 _time_record\">\n" +
        "                            <input type=\"time\" name=\"time\" class=\"form-control\" value=\"00:00\">\n" +
        "                            <div class=\"input-group-append\">\n" +
        "                                <span class=\"input-group-text\"><i class=\"fas fa-times\"></i></span>\n" +
        "                            </div>\n" +
        "                        </div>"

    const inputMyselfTimeRecord = " <div class=\"form-group _myself_time_record\">\n" +
        "                        <div class=\"input-group mb-3 \">\n" +
        "                            <input type=\"time\" name=\"myself_time\" class=\"form-control\" value=\"00:00\">\n" +
        "                            <input type=\"text\" name=\"myself_time\" class=\"form-control\">\n" +
        "                            <div class=\"input-group-append\">\n" +
        "                                <span class=\"input-group-text\"><i class=\"fas fa-times\"></i></span>\n" +
        "                            </div>\n" +
        "                        </div>\n" +
        "                    </div>"

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /* initialize the external events
     -----------------------------------------------------------------*/
    function ini_events(ele) {
        ele.each(function () {

            // create an Event Object (https://fullcalendar.io/docs/event-object)
            // it doesn't need to have a start or end
            var eventObject = {
                title: $.trim($(this).text()) // use the element's text as the event title
            }

            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject)

            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex        : 1070,
                revert        : true, // will cause the event to go back to its
                revertDuration: 0  //  original position after the drag
            })

        })
    }

    ini_events($('#external-events div.external-event'))

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()

    var Calendar = FullCalendar.Calendar;
    var Draggable = FullCalendar.Draggable;

    var containerEl = document.getElementById('external-events');
    var checkbox = document.getElementById('drop-remove');
    var calendarEl = document.getElementById('calendar');

    // initialize the external events
    // -----------------------------------------------------------------

    new Draggable(containerEl, {
        itemSelector: '.external-event',
        eventData: function(eventEl) {
            return {
                title: eventEl.innerText,
                backgroundColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
                borderColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
                textColor: window.getComputedStyle( eventEl ,null).getPropertyValue('color'),
            };
        }
    });

    var calendar = new Calendar(calendarEl, {
        headerToolbar: {
            left  : 'prev,next today',
            center: 'title',
            right : 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        firstDay: 1,
        locale:'ru',
        themeSystem: 'bootstrap',
        eventDisplay: 'block',
        //Random default events
        events: "/admin/calendar/records",
        eventTimeFormat: { // like '14:30:00'
            hour: '2-digit',
            minute: '2-digit',

            meridiem: false
        },
        editable  : true,
        droppable : true, // this allows things to be dropped onto the calendar !!!
        drop      : function(info) {
            // is the "remove after drop" checkbox checked?
            if (checkbox.checked) {
                // if so, remove the element from the "Draggable Events" list
                info.draggedEl.parentNode.removeChild(info.draggedEl);
            }
        },
        dateClick: function (date) {

            let clickDate = new Date(date.dateStr);
            clickDate = moment(clickDate).format("Y-MM-DD");

            $('._form_add-records').attr('data-click-date', clickDate)

            $('._time_record').remove()
            $('._myself_time_record').remove()
            $('._time_records').append(inputTimeRecord)
            $('._btn_save_records').attr('disabled', false)

            $('#_open_modal-add-records').click()
        },
        eventClick: function (event) {

            $.ajax({
                url: "/admin/calendar/show-action-record",
                type: "GET",
                data: {
                    recordId: event.event._def.publicId
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (data) => {

                    $('._form_action_record').html(data)
                    $('[data-mask]').inputmask()
                    $('#_open_modal-action-with-records').click()

                }

            })

        }
    });

    calendar.render();
    // $('#calendar').fullCalendar()

    /* ADDING EVENTS */
    var currColor = '#3c8dbc' //Red by default
    // Color chooser button
    $('#color-chooser > li > a').click(function (e) {
        e.preventDefault()
        // Save color
        currColor = $(this).css('color')
        // Add color effect to button
        $('#add-new-event').css({
            'background-color': currColor,
            'border-color'    : currColor
        })
    })
    $('#add-new-event').click(function (e) {
        e.preventDefault()
        // Get value and make sure it is not null
        var val = $('#new-event').val()
        if (val.length == 0) {
            return
        }

        // Create events
        var event = $('<div />')
        event.css({
            'background-color': currColor,
            'border-color'    : currColor,
            'color'           : '#fff'
        }).addClass('external-event')
        event.text(val)
        $('#external-events').prepend(event)

        // Add draggable funtionality
        ini_events(event)

        // Remove event from text input
        $('#new-event').val('')
    })

    //Добавление записей в БД
    $(document).on('submit', '._form_add-records', function (event){
        event.preventDefault()
        let timeRecords = $(this).serializeArray()

        //Объединение двух input в один со значение времени и названия
        let firstMyselfTime = false
        for (let i=0; i < timeRecords.length; i++ ){
            if(timeRecords[i]['name'] == 'myself_time' && firstMyselfTime == false){
                firstMyselfTime = true
                continue
            }
            if(firstMyselfTime){
                let indexFirstMyself = i - 1;
                timeRecords[indexFirstMyself]['title'] = timeRecords[i]['value']
                timeRecords[indexFirstMyself]['status'] = 4
                delete timeRecords[i];
                firstMyselfTime = false
            }
        }

        //Дата по которой клик был
        let date = $(this).attr('data-click-date')

        //Создание записей
        $.ajax({
            url: "/admin/calendar/create-records",
            data: {
                timeRecords: timeRecords,
                date: date,
            },
            type: "POST",
            success: function (data) {
                $('.close').click();
                calendar.refetchEvents()
            }
        });
    })

    //Добавить еще одно время для записи
    $(document).on('click', '._add_more_record', function (e){
        e.preventDefault()
        $('._time_records').append(inputTimeRecord)
        $('._btn_save_records').attr('disabled', false)
    })

    //Добавить еще одно время для записи
    $(document).on('click', '._add_myself_record', function (e){
        e.preventDefault()
        $('._time_records').append(inputMyselfTimeRecord)
        $('._btn_save_records').attr('disabled', false)
    })

    //Удалить время для записи
   $(document).on('click', '.input-group-append', function (){
       $(this).parent('.input-group').parent('._myself_time_record').remove()
       $(this).parent('._time_record').remove()

       if($('._time_record').length == 0 && $('._myself_time_record').length == 0){
            $('._btn_save_records').attr('disabled', '')
       }
   })

})





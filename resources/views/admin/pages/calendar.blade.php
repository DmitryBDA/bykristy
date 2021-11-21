@extends('admin.layouts.main')

@section('custom_css')
    <link rel="stylesheet" href="/plugins/fullcalendar/main.css">
    <style>
        .event {
        //shared event css
        }

        .greenEvent {
            background-color:#1d8b1d;
        }

        .yellowEvent {
            background-color:#a7a739;
        }

        .redEvent {
            background-color:#bf0d0d;
        }
        .greyEvent {
            background-color:grey;
        }

        .hiddenevent{
            font-size: 9px;
        }
        .fc-daygrid-block-event .fc-event-time{
            font-weight: 400!important;
        }

    </style>
@endsection

@section('custom_js')
    <script src="/plugins/fullcalendar/main.js"></script>

    <script>

    </script>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Calendar</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Calendar</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <div class="sticky-top mb-3">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Draggable Events</h4>
                                </div>
                                <div class="card-body">
                                    <!-- the events -->
                                    <div id="external-events"></div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                            <div class="card"></div>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                        <div class="card card-primary">
                            <div class="card-body p-0">
                                <!-- THE CALENDAR -->
                                <div id="calendar"></div>
                            </div>
                            <!-- /.card-body -->
                        </div>


                        <!-- /.card -->
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                                <div style="width: 100%;height: 49px;" class="btn-group-vertical">
                                    <button id="eventsList" type="button" class="btn btn-default">Список дат</button>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="card card-info collapsed-card">
                                    <div id="list_active_records" class="card-header">
                                        <h3 class="card-title">Активные записи</h3>

                                        <div class="card-tools _btn_collapse">
                                            <button class="btn btn-tool " data-card-widget="collapse" title="Collapse">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="card-body p-0">
                                        <div class="form-group mt-2 mr-2 ml-2">
                                            <input type="text" class="form-control _search_active_record"
                                                   placeholder="Введите чтобы начать поиск">
                                        </div>
                                        <div class="_users_active_list_wrapper">
                                            @include('admin.pages.calendar.ajax-elem.usersActiveList')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
{{--        <modal-action-record></modal-action-record>--}}
        <!-- /.content -->
        @include('admin.modal.add-records')

        @include('admin.modal.action-with-record')
    </div>
    <!-- /.content-wrapper -->
@endsection

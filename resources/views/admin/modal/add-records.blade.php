<div class="modal fade" id="modal-add-records">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Добавить запись</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form class="_form_add-records">
                <div class="card-body">
                    <div class="form-group _time_records">
                        <label>Время</label>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="button" class="btn btn-primary ml-0 _add_more_record">Добавить еще</button>
                    <button type="submit" class="btn btn-primary mr-0">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
<button style="display: none" id="_modal-add-records" type="button" class="btn btn-default" data-toggle="modal"
        data-target="#modal-add-records">open
</button>

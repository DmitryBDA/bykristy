<div class="modal fade" id="modal-add-records">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Добавить запись</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form>
                <div class="card-body">
                    <div class="form-group">
                        <label>Время</label>
                        <input type="time" class="form-control" value="00:00">
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary ml-0">Добавить еще</button>
                    <button type="submit" class="btn btn-primary mr-0">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
<button style="display: none" id="_modal-add-records" type="button" class="btn btn-default" data-toggle="modal"
        data-target="#modal-add-records">open
</button>

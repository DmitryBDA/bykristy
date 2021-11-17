<div class="modal fade" id="modal-action-with-records">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Выбор действия</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="_form_action_record">
                @include('admin.modal.ajax.action-record')
            </div>
        </div>
    </div>
</div>
<button style="display: none" id="_open_modal-action-with-records" type="button" class="btn btn-default" data-toggle="modal"
        data-target="#modal-action-with-records">open
</button>

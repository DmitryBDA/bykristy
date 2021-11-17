<template>
    <div>
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
                                <label v-on:click="greet" >Время</label>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="button" class="btn btn-primary ml-0 _add_more_record">Добавить</button>
                            <button type="button" class="btn btn-primary ml-0 _add_myself_record">Личное</button>
                            <button type="submit" class="btn btn-primary mr-0 _btn_save_records">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <button style="display: none" id="_open_modal-add-records" type="button" class="btn btn-default" data-toggle="modal"
                data-target="#modal-add-records">open
        </button>

    </div>
</template>

<script>
export default {
    data() {
        return {
            arr: [],
            test: 'hellp'
        }
    },
    methods: {
        greet: function (event) {
            const inputTimeRecord = "<div class=\"input-group mb-3 _time_record\">\n" +
                "                            <input type=\"time\" name=\"time\" class=\"form-control\" value=\"00:00\">\n" +
                "                            <div class=\"input-group-append\">\n" +
                "                                <span class=\"input-group-text\"><i class=\"fas fa-times\"></i></span>\n" +
                "                            </div>\n" +
                "                        </div>"

            $('._time_records').append(inputTimeRecord)
            $('._btn_save_records').attr('disabled', false)
        }
    }
}
</script>

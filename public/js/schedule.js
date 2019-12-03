$(function() {
    function addOptionToSelectType(option) {
        var newOptionAdd = new Option(option.text, option.id, false, false);
        $('.input-select-2-multiple-add').append(newOptionAdd).trigger('change');
        var newOptionEdit = new Option(option.text, option.id, false, false);
        $('.input-select-2-multiple-edit').append(newOptionEdit).trigger('change');
    }

    var select2ConfigAdd = {
        tags: true,
        dropdownParent: $("#addScheduleTask")
    };

    var select2ConfigEdit = {
        tags: true,
        dropdownParent: $("#editScheduleTask")
    };

    $('.input-select-2-multiple-add').select2(select2ConfigAdd);
    $('.input-select-2-multiple-edit').select2(select2ConfigEdit);

    var select2ConfigNotTagAdd = {
        dropdownParent: $("#addScheduleTask")
    };

    var select2ConfigNotTagEdit = {
        dropdownParent: $("#editScheduleTask")
    };

    $('.input-select-2-multiple-bind-users-add').select2(select2ConfigNotTagAdd);
    $('.input-select-2-multiple-bind-users-edit').select2(select2ConfigNotTagEdit);

    $('#addScheduleTask').on('shown.bs.modal', function (e) {
        $(".input-select-2-multiple-add").select2("destroy");
        $(".input-select-2-multiple-add").select2(select2ConfigAdd);
        $(".input-select-2-multiple-add").val(null);
        $(".input-select-2-multiple-bind-users-add").select2("destroy");
        $(".input-select-2-multiple-bind-users-add").select2(select2ConfigNotTagAdd);
    });

    $('#editScheduleTask').on('shown.bs.modal', function (e) {
        $(".input-select-2-multiple-edit").select2("destroy");
        $(".input-select-2-multiple-edit").select2(select2ConfigEdit);
        $(".input-select-2-multiple-bind-users-edit").select2("destroy");
        $(".input-select-2-multiple-bind-users-edit").select2(select2ConfigNotTagEdit);
    });

    $('.datepicker').datepicker({
        format: "dd MM yyyy",
        autoclose: true,
        todayHighlight: true
    });

    $('.colorpicker-input').colorpicker({ 
        format: 'hex'
    });

    $('#add-schedule').click(function() {
        var form = $(this).parents('form');
        var action = form.attr('action');
        var data = form.serializeArray();

        form.find('.text-danger').text('');

        preloaderStart();
    
        $.ajax({
            url: action,
            method: 'post',
            data: data,
            dataType: 'json'
        }).done(function(data) {
            preloaderStop();
            $('#addSchedule').modal('hide');
            form.trigger("reset");
            if (data.status == 'ok') {
                window.location.href = data.route;
                if (data.option) {
                    addOptionToSelectType(data.option);
                }
            }
        }).fail(function(xhr) {
            preloaderStop();
            if (xhr.status == 422) {
                var error = xhr.responseJSON.errors;
                for (key in error) {                    
                    form.find('label[for="'+key+'"]').parent().find('.text-danger').text(error[key].join(''));
                }
            }
        });
    });

    $('#add-task-to-schedule').click(function() {
        var form = $(this).parents('form');
        var action = form.attr('action');
        var data = form.serializeArray();

        form.find('.text-danger').text('');

        preloaderStart();
    
        $.ajax({
            url: action,
            method: 'post',
            data: data,
            dataType: 'json'
        }).done(function(data) {
            preloaderStop();
            if (data.status == 'ok') {
                $('.task-index table').replaceWith(data.html);
                if (typeof addTaskToCalendar === "function") addTaskToCalendar(data.event);
                if (data.option) {
                    addOptionToSelectType(data.option);
                }
            }
            $('#addScheduleTask').modal('hide');
            form.trigger("reset");
        }).fail(function(xhr) {
            preloaderStop();
            if (xhr.status == 422) {
                var error = xhr.responseJSON.errors;
                for (key in error) {                    
                    form.find('label[for="'+key+'"]').parent().find('.text-danger').text(error[key].join(''));
                }
            }
        });
    });

    $(document).on('click', '.delete-task-schedule', function( e ) {
        if (confirm('Do you really want to delete this entry?')) {
            var self = $(this);
            preloaderModalStart();

            $.ajax({
                url: self.data('action'),
                method: 'post',
                data: {_method: 'delete', _token: self.data('token')},
                dataType: 'json'
            }).done(function(data) {
                preloaderStop();
                if (data.status == 'ok') {
                    $(self).parents('tr').remove();
                    if (typeof removeTaskCalendar === "function") removeTaskCalendar(data.event);
                }
            });
            return false;
        } else {
            return false;
        }
    });

    $(document).on('click', '.edit-task-schedule', function(e) {
        var self = $(this);
        preloaderModalStart();

        $.ajax({
            url: self.data('action'),
            method: 'get',
            dataType: 'json'
        }).done(function(data) {
            preloaderStop();
            if (data.status == 'ok') {
                $('#form-edit-task').trigger("reset");
                $('#form-edit-task').attr('data-id', self.data('id'));
                $('#editScheduleTask .text-danger').text('');
                for (key in data.task) {                    
                    $('#editScheduleTask [name="'+key+'"]').val(data.task[key]);
                    if (key=='color') {
                        $('#editScheduleTask [name="'+key+'"]').parent().colorpicker('setValue', data.task[key])
                    }
                }
                $('.colorpicker-input').colorpicker('update');
                $(".datepicker").datepicker("update");
            }
            $('#editScheduleTask').modal('show');
        });
        return false;
    });

    $('#edit-task-to-schedule').click(function() {
        var form = $(this).parents('form');
        var action = form.attr('action');
        var data = form.serializeArray();
        var id = form.attr('data-id');

        form.find('.text-danger').text('');

        preloaderStart();
    
        $.ajax({
            url: action+'/'+id,
            method: 'post',
            data: data,
            dataType: 'json'
        }).done(function(data) {
            preloaderStop();
            if (data.status == 'ok') {
                $('.task-index table').replaceWith(data.html);
                if (typeof updateTaskCalendar === "function") updateTaskCalendar(data.event);
                if (data.option) {
                    addOptionToSelectType(data.option);
                }
            }
            $('#editScheduleTask').modal('hide');
            form.trigger("reset");
        }).fail(function(xhr) {
            preloaderStop();
            if (xhr.status == 422) {
                var error = xhr.responseJSON.errors;
                for (key in error) {                    
                    form.find('label[for="'+key+'"]').parent().find('.text-danger').text(error[key].join(''));
                }
            }
        });
    });

    $('#add-task-type').click(function() {
        var form = $(this).parents('form');
        var action = form.attr('action');
        var data = form.serializeArray();

        form.find('.text-danger').text('');

        preloaderStart();
    
        $.ajax({
            url: action,
            method: 'post',
            data: data,
            dataType: 'json'
        }).done(function(data) {
            preloaderStop();
            $('#addTaskType').modal('hide');
            form.trigger("reset");
            if (data.status == 'ok') {
                $('#task-type-add option:last, #task-type-edit option:last').before(new Option(data.type.name, data.type.id, true, true)).trigger('change');
            }
        }).fail(function(xhr) {
            preloaderStop();
            if (xhr.status == 422) {
                var error = xhr.responseJSON.errors;
                for (key in error) {                    
                    form.find('label[for="'+key+'"]').parent().find('.text-danger').text(error[key].join(''));
                }
            }
        });
    });

    $('#task-type-add, #task-type-edit').on('select2:selecting', function (e) {
        var data = e.params.args.data;
        if (data.id == 'add_new') {
            $('#addTaskType').modal('show');
            $('#task-type-add, #task-type-edit').select2("close");
            return false;
        }
    });

    $(document).on('click', '.button-edit-schedule', function() {
        if ($('.edit-schedule').is(':visible')) {
            $('.show-schedule').toggleClass('hidden');
            $('.edit-schedule').toggleClass('hidden');
            return false;
        }

        $('.show-schedule').toggleClass('hidden');
        $('.edit-schedule').toggleClass('hidden');
        return false;
    });

    $('#edit-schedule').click(function() {
        var form = $(this).parents('form');
        var action = form.attr('action');
        var dataForm = form.serializeArray();

        form.find('.text-danger').text('');

        $.ajax({
            url: action,
            method: 'post',
            data: dataForm,
            dataType: 'json'
        }).done(function(data) {
            if (data.status == 'ok') {
                $(dataForm).each(function(index, field){
                    switch (field.name) {
                        case "title":
                            $('.show-schedule-title').text(field.value);
                            break;
                        case "description":
                            $('.show-schedule').text(field.value);
                            break;
                    }
                });
                $('.show-schedule').toggleClass('hidden');
                $('.edit-schedule').toggleClass('hidden');
            }
        }).fail(function(xhr) {
            preloaderStop();
            if (xhr.status == 422) {
                var error = xhr.responseJSON.errors;
                for (key in error) {
                    form.find('[name="'+key+'"]').next('.text-danger').text(error[key].join(''));
                }
            }
        });
    });
});
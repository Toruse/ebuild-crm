$(function() {
    function addOptionToSelectType(option) {
        var newOptionAdd = new Option(option.text, option.id, false, false);
        $('.input-select-2-multiple-add').append(newOptionAdd).trigger('change');
        var newOptionEdit = new Option(option.text, option.id, false, false);
        $('.input-select-2-multiple-edit').append(newOptionEdit).trigger('change');
    }

    var select2ConfigAdd = {
        tags: true,
        dropdownParent: $("#addTask")
    };

    var select2ConfigEdit = {
        tags: true,
        dropdownParent: $("#editTask")
    };

    $('.input-select-2-multiple-add').select2(select2ConfigAdd);
    $('.input-select-2-multiple-edit').select2(select2ConfigEdit);

    var select2ConfigNotTagAdd = {
        dropdownParent: $("#addTask")
    };

    var select2ConfigNotTagEdit = {
        dropdownParent: $("#editTask")
    };

    $('.input-select-2-multiple-bind-users-add').select2(select2ConfigNotTagAdd);
    $('.input-select-2-multiple-bind-users-edit').select2(select2ConfigNotTagEdit);

    $('#price').mask('#,##0.00', {reverse: true});

    var PostalCodeMaskBehavior = function (val) {
        var masks = ['00000', '00000-0000'];
        return (val.length>4) ? masks[1] : masks[0];
    };

    $('.postal_code').mask(PostalCodeMaskBehavior, {
        onKeyPress: function(value, e, field, options) {
            var masks = ['00000', '00000-0000'];
            var mask = (value.length>4) ? masks[1] : masks[0];
            $('.postal_code').mask(mask, options);
        }
    });

    $('.datepicker').datepicker({
        format: "dd MM yyyy",
        autoclose: true,
        todayHighlight: true
    });

    $('.colorpicker-input').colorpicker({ 
        format: 'hex'
    });

    $('#addTask').on('shown.bs.modal', function (e) {
        $(".input-select-2-multiple-add").select2("destroy");
        $(".input-select-2-multiple-add").select2(select2ConfigAdd);
        $(".input-select-2-multiple-bind-users-add").select2("destroy");
        $(".input-select-2-multiple-bind-users-add").select2(select2ConfigNotTagAdd);
    });

    $('#editTask').on('shown.bs.modal', function (e) {
        $(".input-select-2-multiple-edit").select2("destroy");
        $(".input-select-2-multiple-edit").select2(select2ConfigEdit);
        $(".input-select-2-multiple-bind-users-edit").select2("destroy");
        $(".input-select-2-multiple-bind-users-edit").select2(select2ConfigNotTagEdit);
    });

    $('#add-task-to-project').click(function() {
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
                $('.task-index tbody').append(data.htmlChangeTask);
                $('.show-project').html(data.htmlInfoProject);
                if (typeof addTaskToCalendar === "function") addTaskToCalendar(data.event);
                if (data.option) {
                    addOptionToSelectType(data.option);
                }
            }
            $('#addTask').modal('hide');
            form.trigger("reset");
            $('#task_type-add').val(null);
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

    $(document).on('click', '.delete-task-project', function( e ) {
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
                    $('.show-project').html(data.htmlInfoProject);
                    if (typeof removeTaskCalendar === "function") removeTaskCalendar(data.event);
                }
            });
            return false;
        } else {
            return false;
        }
    });

    $(document).on('click', '.edit-task-project', function( e ) {
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
                $('#editTask .text-danger').text('');
                for (key in data.task) {                    
                    $('#editTask [name="'+key+'"]').val(data.task[key]);
                    if (key == 'color') {
                        $('#editTask [name="'+key+'"]').parent().colorpicker('setValue', data.task[key]);
                    }
                }
                $('.colorpicker-input').colorpicker('update');
                $(".datepicker").datepicker("update");
            }
            $('#editTask').modal('show');
        });
        return false;
    });

    $('#edit-task-to-project').click(function() {
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
                $('.task-index tbody input[value="'+id+'"]').parents('tr').replaceWith(data.htmlChangeTask);
                $('.show-project').html(data.htmlInfoProject);
                if (typeof updateTaskCalendar === "function") updateTaskCalendar(data.event);
                if (data.option) {
                    addOptionToSelectType(data.option);
                }
            }
            $('#editTask').modal('hide');
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

    $('.load-select-schedule').click(function() {
        var self = $(this);
        preloaderStart();
    
        $.ajax({
            url: self.data('action'),
            method: 'get',
            dataType: 'json'
        }).done(function(data) {
            preloaderStop();
            if (data.status == 'ok') {
                $('.list-schedule').html(data.html);
                $('#selectSchedule').modal('show');
            }
        });
    });

    $('#select-schedule').click(function() {
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
                $('.task-index tbody').append(data.htmlListNewTask);
                $('.show-project').html(data.htmlInfoProject);
                if (typeof addTasksToCalendar === "function") addTasksToCalendar(data.events);
            }
            $('#selectSchedule').modal('hide');
            form.trigger("reset");
            $('.input-select-schedule').hide();
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

    $(document).on('click', '.button-edit-project', function() {
        var self = $(this);

        if ($('.edit-project').is(':visible')) {
            $('.show-project').toggleClass('hidden');
            $('.edit-project').toggleClass('hidden');
            return false;
        }

        preloaderModalStart();

        $.ajax({
            url: self.data('action'),
            method: 'get',
            dataType: 'json'
        }).done(function(data) {
            preloaderStop();
            if (data.status == 'ok') {
                $('#form-edit-project').trigger("reset");
                for (key in data.project) {                    
                    $('#form-edit-project [name="'+key+'"]').val(data.project[key]);
                    if (key=='color') {
                        $('#form-edit-project [name="'+key+'"]').parent().colorpicker('setValue', data.project[key])
                    }
                }
                $('.colorpicker-input').colorpicker('update');
                $(".datepicker").datepicker("update");
            }
            $('.show-project').toggleClass('hidden');
            $('.edit-project').toggleClass('hidden');
        });
        return false;
    });

    $('#edit-project').click(function() {
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
                $('.show-project').html(data.html);
                $('.show-project').toggleClass('hidden');
                $('.edit-project').toggleClass('hidden');
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

    $('#customer').change(function() {
        var action = $(this).data('action')+'/'+$(this).val();
        $.ajax({
            url: action,
            method: 'get',
            dataType: 'json'
        }).done(function(data) {
            if (data.status == 'ok') {
                for (key in data.user) {
                    $('[name="'+key+'"]').val(data.user[key]);
                }
                
                $('[name="type"]').val(null);
                $('[name="project_manager"]').val(null);
                if (data.order) {
                    $('[name="type"]').val(data.order.project_type_id);
                    $('[name="project_manager"]').val(data.order.project_manager_id);
                }
            }
        });
    });

    $('#indexSchedule').on('shown.bs.modal', function (e) {
        $('#indexSchedule').find('iframe').attr('src', function () { 
            return $(this)[0].src; 
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

    $(document).on('click', '.model-edit-schedule, .model-show-schedule', function() {
        var action = $(this).attr('href');

        $('#iframeSchedule').find('iframe').attr('src', function () { 
            return action; 
        });
        $('#iframeSchedule').modal('show');  

        return false;
    });

    $('#iframeSchedule').on('hidden.bs.modal', function (e) {
        var button = $('.load-select-schedule');
        preloaderStart();
    
        $.ajax({
            url: button.data('action'),
            method: 'get',
            dataType: 'json'
        }).done(function(data) {
            preloaderStop();
            if (data.status == 'ok') {
                $('.list-schedule').html(data.html);
            }
        });
    })

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
                $('#iframeSchedule').find('iframe').attr('src', function () { 
                    return data.route; 
                });
                $('#iframeSchedule').modal('show');          
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

    $('.button-project-publish, .button-project-unpublished').click(function() {
        var self = $(this);
    
        $.ajax({
            url: self.data('action'),
            method: 'post',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                publish: self.val()
            }
        }).done(function(data) {
            if (data.status == 'ok') {
                $('.button-project-publish').toggleClass('hidden');
                $('.button-project-unpublished').toggleClass('hidden');
                $('.project-edit-hidden').toggleClass('hidden')
                $.notify(self.text().trim(), {
                    style: 'bootstrap',
                    className: 'success',
                });
            }
        });
    });

    if (publishProject == 1) {
        $('.project-edit-hidden').addClass('hidden');
    }
});
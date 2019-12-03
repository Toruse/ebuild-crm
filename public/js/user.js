$(function() {
    $('.input-select-2-multiple').select2();

    $('.input-select-2-multiple-skill-specialty').select2({
        placeholder: "Skill/Specialty"
    });

    $('.input-select-2-multiple-add').select2({
        tags: true,
    });

    $('#phone').mask('+1 (000) 000-0000', {placeholder: "+1 (###) ###-####"});

    var PostalCodeMaskBehavior = function (val) {
        var masks = ['00000', '00000-0000'];
        return (val.length>4) ? masks[1] : masks[0];
    };

    $('#postal_code').mask(PostalCodeMaskBehavior,{
        onKeyPress: function(value, e, field, options) {
            var masks = ['00000', '00000-0000'];
            var mask = (value.length>4) ? masks[1] : masks[0];
            $('#postal_code').mask(mask, options);
        }
    });

    $('#add-source').click(function() {
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
            $('#addSource').modal('hide');
            form.trigger("reset");
            if (data.status == 'ok') {
                $('#source option:last').before(new Option(data.source.name, data.source.id, true, true));
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

    $('#source').change(function() {
        if ($(this).val() == 'other')
            $('#addSource').modal('show');
    });

    $('#add-type').click(function() {
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
            $('#addProjectType').modal('hide');
            form.trigger("reset");
            if (data.status == 'ok') {
                $('#project_type option:last').before(new Option(data.type.name, data.type.id, true, true));
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

    $('#project_type').change(function() {
        if ($(this).val() == 'other')
            $('#addProjectType').modal('show');
    });

    $('#user_role').change(function() {
        switch ($(this).val()) {
            case 'customer':
                $('.user-vendor').addClass('hidden');
                $('.user-project-manager').addClass('hidden');
                $('.user-contractor').addClass('hidden');
                $('.user-customer').removeClass('hidden');
                $('.user-sales-associate').addClass('hidden');        
                break;
            case 'vendor':
                $('.user-project-manager').addClass('hidden');
                $('.user-customer').addClass('hidden');
                $('.user-contractor').addClass('hidden');
                $('.user-vendor').removeClass('hidden');
                $('.user-sales-associate').addClass('hidden');        
                break;
            case 'contractor':
                $('.user-vendor').addClass('hidden');
                $('.user-project-manager').addClass('hidden');
                $('.user-customer').addClass('hidden');
                $('.user-contractor').removeClass('hidden');
                $('.user-sales-associate').addClass('hidden');        
                break;
            case 'project-manager':
                $('.user-vendor').addClass('hidden');
                $('.user-customer').addClass('hidden');
                $('.user-contractor').addClass('hidden');
                $('.user-project-manager').removeClass('hidden');
                // $('.user-sales-associate').addClass('hidden');
                break;
            case 'sales-associate':
                $('.user-vendor').addClass('hidden');
                $('.user-customer').addClass('hidden');
                $('.user-contractor').addClass('hidden');
                // $('.user-project-manager').addClass('hidden');
                $('.user-sales-associate').removeClass('hidden');
                break;
            default:
                $('.user-vendor').addClass('hidden');
                $('.user-project-manager').addClass('hidden');
                $('.user-customer').addClass('hidden');
                $('.user-contractor').addClass('hidden');        
                $('.user-sales-associate').addClass('hidden');        
        }
    });

    $('.send-new-accesses').click(function() {
        var link = $(this);
        var action = link.attr('href');

        var configNotify = {
            position: 'right',
            style: 'bootstrap',
        }

        $.ajax({
            url: action,
            method: 'get',
            dataType: 'json'
        }).done(function(data) {
            if (data.status == 'ok') {
                configNotify.className = 'success',
                link.notify("Data sent.", configNotify);
            } else {
                configNotify.className = 'error',
                link.notify("Data not sent.", configNotify);                
            }
        }).fail(function(xhr) {
            configNotify.className = 'error',
            link.notify("Data not sent.", configNotify);
        });

        return false;
    });

    $('#user_role').trigger('change');

    $('#add-skill-specialty').click(function() {
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
            $('#addSkillSpecialty').modal('hide');
            form.trigger("reset");
            if (data.status == 'ok') {
                $('#skill_specialty option:last').before(new Option(data.skillSpecialty.name, data.skillSpecialty.id, true, true)).trigger('change');
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

    $('#skill_specialty').on('select2:selecting', function (e) {
        var data = e.params.args.data;
        if (data.id == 'add_new') {
            $('#addSkillSpecialty').modal('show');
            $('#skill_specialty').select2("close");
            return false;
        }
    });
});
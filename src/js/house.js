var Attach = {
    action: function(data_obj){
        $.ajax({
            url:'?num=view_houses',
            type: 'POST',
            data: data_obj,
            dataType: 'json',
            success: function (data){
                if(data.success){
                    if(data_obj.action == 'attach_service_to_house') {
                        $('#attach-success').slideDown('slow', function () {
                            setTimeout(function () {
                                $('#attach-success').slideUp('slow');
                            }, 2000);
                        });
                    }else{
                        $('#detach-success').slideDown('slow', function () {
                            setTimeout(function () {
                                $('#detach-success').slideUp('slow');
                            }, 2000);
                        });
                    }
                }else{
                    var warnings = data.warnings;
                    var count = warnings.length;
                    if(count){
                        var warning = '<div class="alert alert-warning">';
                        warning += '<button class="close" data-dismiss="alert">&times;</button>';
                        warning += '<strong>Warning!</strong>';
                        warning += '<ul>';
                        for (var i = 0; i < count; i++){
                            warning += '<li>'+warnings[i]+'</li>';
                        }
                        warning += '</div>';
                        $('.warnings').show().html(warning);
                        setTimeout(function(){
                            $('.warnings').fadeOut('slow');
                        },2000);
                    }else {
                        $('#attach-fail').slideDown('slow', function () {
                            setTimeout(function () {
                                $('#attach-fail').slideUp('slow');
                            }, 2000);
                        });
                    }
                }
            }
        });
    },
    checkTheAttached: function(house_data){
        // $('.')
        $.ajax({
            url: '?num=view_houses',
            type: 'POST',
            data: house_data,
            dataType: 'json',
            success: function(data){
                // loop through the house services
                var count = data.length;
                if(count){
                    var service_id = 0;
                    for(var i = 0; i < count; i++){
                        service_id = data[i];

                        $('input[value="'+service_id+'"').attr('checked', 'checked').parent().addClass('checked');
                    }
                }else{
                    $('input[type="checkbox"]').removeAttr('checked').parent().removeClass('checked');
                }
            }
        });
    }
}

$('#table1 > tbody > tr').live('click', function(event){
    if(event.ctrlKey) {
        $(this).toggleClass('info');
    }
    else {
        if ( $(this).hasClass('info') ) {
            $('#table1 > tbody > tr').removeClass('info');
        }
        else {
            $('#table1 > tbody > tr').removeClass('info');
            $(this).toggleClass('info');
        }
    }
});

//get the ailment id
$('#table1').on('click', 'tr', function() {
    var house_id = $(this).children('td:first').text();
    $('#attach_service').val(house_id);

    //prepare to show the dialog
    $('.attach_service').attr('data-toggle', 'modal');
    $('.edit_house').attr('data-toggle', 'modal');
    $('.delete-house').attr('data-toggle', 'modal');
    $('#edit').val(house_id);
    $('#del_id').val(house_id);

    var the_data = {'house_id': house_id,
                    'action': 'check_attached'
    };

    Attach.checkTheAttached(the_data);

    //get ailments details and place then on the edit modal

});


$('.edit_house').click(function(){

    var edit_id = $('#edit').val();
    if(edit_id == ''){
        alert('Please select a record to edit first');
    }
    var data = { 'edit_id' : edit_id }
    $('#edit_h').val(edit_id);

    if (edit_id != ''){
        $.ajax({
            url: '?num=view_houses',
            type: 'POST',
            data: data,
            dataType:'json',
            success: function (data) {
                $('#hse').val(data['house_number']);
                $('#plt').val(data['plot_id']);
            }
        })
    }

});

$('.delete-house').click(function(){
   var delete_id = $('#del_id').val();
    if (delete_id == ''){
        alert('Please select a record to delete first');
    }
    $('#delete_id').val(delete_id);
});

//event to listen when the attach services button is clicked
$('.attach_service').on('click',function(){
    var val = $('#attach_service').val();
    if (val == ''){
        alert('Please select a house first');
    }
});

$('#service_form :checkbox').change(function() {
    var $this = $(this);
    // $this will contain a reference to the checkbox
    var service_id = $(this).val();
    var house_id = $('#attach_service').val();
    if ($this.is(':checked')) {
        var data = {
            'service_id': service_id,
            'house_id': house_id,
            'action': 'attach_service_to_house'
        }
        Attach.action(data);
    } else {
        if(confirm('Are you sure you want to detach the service?')) {
            var data = {
                'service_id': service_id,
                'house_id': house_id,
                'action': 'detach_service_from_house'
            }
            Attach.action(data);
        }else{
            return false;
        }
    }
});
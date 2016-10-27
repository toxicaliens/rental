var AttachPropertyServices = {
    action: function(data_obj){
        $.ajax({
            url:'?num=3001',
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
    checkTheAttached: function(the_data){
        $.ajax({
            url: '?num=3001',
            type: 'POST',
            data: the_data,
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
    var prop_id = $(this).children('td:first').text();
    $('#edt').val(prop_id);
    $('#del-id').val(prop_id);

    //prepare to show the dialog
    $('.attach_service').attr('data-toggle', 'modal');
    $('.edit_prop').attr('data-toggle', 'modal');
    $('.del_prop').attr('data-toggle', 'modal');

    var the_data = {'prop_id': prop_id,
        'action': 'check_attached'
    };

    AttachPropertyServices.checkTheAttached(the_data);

    //get ailments details and place then on the edit modal

});

$('.edit_prop').on('click', function(){
    var edit_id = $('#edt').val();
    if (edit_id == ""){
        alert('Please select a record to edit first');
    }
    var data = { 'edit_id': edit_id };
    $('#edit_id').val(edit_id);

    if(edit_id != ''){
        $.ajax({
            url: '?num=3001',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(data){
                $('#property_type1').val(data['prop_type']);
                $('#name').val(data['plot_name']);
                $('#units').val(data['units']);
                $('#payment_code').val(data['payment_code']);
                $('#pay_bill').val(data['paybill_number']);
                $('#property_manager').val(data['pm_mfid']);
                $('#landlord').val(data['landlord_mfid']);
                $('#lr_no').val(data['lr_no']);
                $('#locatioin').val(data['location']);

            }
        });
    }
});

$('.del_prop').on('click', function(){

    var del_id = $('#del-id').val();
    if(del_id == ''){
        alert('Please select a record to delete first');
    }
    //alert(del_id);
    $('#delete_id').val(del_id);
});
// $('#option_type').on('click', function(){
//     var prop_type = $('#property_type').val();
//     alert('ok');
// })
$('#property_type').change(function(){

    $('#option_type').val('');
    var id = $(this).attr('value');
    var data ={'id' : id};
    if (id == 1){
        //alert(id);
        $.ajax({
            url: '?num=3001',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function (data){
                var html = '<option value="">--Choose Option--</option>';
                for (var i = 0; i < data.length; i++){
                    html += '<option value="'+data[i].option_id+'">'+data[i].option_name+'</option>';
                }
                $('#option_type').removeAttr('disabled').html(html);
            }
        });
    }else{
        var html = '<option value="">--Choose Option--</option>';
        $('#option_type').html('').attr('disabled','disabled');
    }

});

$('.attach_service').on('click',function(){
    var val = $('#attach_service').val();
    if (val == ''){
        alert('Please select a property first');
    }
});

$('#service_form :checkbox').change(function() {
    var $this = $(this);
    // $this will contain a reference to the checkbox
    var service_id = $(this).val();
    var prop_id = $('#attach_service').val();
    //alert(service_id);
    if ($this.is(':checked')) {
        var data = {
            'service_id': service_id,
            'prop_id': prop_id,
            'action': 'attach_service_to_property'
        }
        AttachPropertyServices.action(data);
    } else {
        if(confirm('Are you sure you want to detach the service?')) {
            var data = {
                'service_id': service_id,
                'prop_id': prop_id,
                'action': 'detach_service_from_property'
            }
            AttachPropertyServices.action(data);
        }else{
            return false;
        }
    }
});
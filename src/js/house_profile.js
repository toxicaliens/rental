$('.live_table > tbody > tr').live('click', function(event){
    if(event.ctrlKey) {
        $(this).toggleClass('info');
    }
    else {
        if ( $(this).hasClass('info') ) {
            $('.live_table > tbody > tr').removeClass('info');
        }
        else {
            $('.live_table > tbody > tr').removeClass('info');
            $(this).toggleClass('info');
        }
    }
});

//get the ailment id
$('.live_table').on('click', 'tr', function() {
    var house_id = $(this).children('td:first').text();
    $('#attach_service').val(house_id);
    var service_id = $(this).children('td:first').text();
    $('#h_detach-id').val(service_id);
    $('.detach_service_from_house').attr('data-toggle', 'modal');




    //get ailments details and place then on the edit moda

});
var AttachPropertyServices = {
    action: function(data_obj){
        $.ajax({
            url:'?num=900',
            type: 'POST',
            data: data_obj,
            dataType: 'json',
            success: function (data){
                if(data.success){
                    if(data_obj.action == 'attach_service_to_property') {
                        $('#attach-success').slideDown('slow', function () {
                            setTimeout(function () {
                                $('#attach-success').slideUp('slow');
                                location.reload();
                            }, 2000);
                        });
                    }else{
                        $('#detach-success').slideDown('slow', function () {
                            setTimeout(function () {
                                $('#detach-success').slideUp('slow');
                                location.reload();
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
            url: '?num=900',
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
// load services on keyup

$('.attach_service_to_house').on('click',function(){
    var house_id = $('#attach_service_id').val();
    // alert(prop_id);
    var the_data = {'house_id': house_id,
        'action': 'check_attached'
    };

    AttachPropertyServices.checkTheAttached(the_data);
});

$('#house-search-key').on('keyup', function(){
    var search_key = $(this).val();
    if(search_key != ''){
        $.ajax({
            url: '?num=900&action=search_services&search_key='+search_key,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var count = data.length;
                if (count <= 0) {
                    $('#service-container').html('<span>No records found</span>');
                } else {
                    var html = '';
                    for (var i = 0; i < count; i++) {
                        var service_channel_id = data[i].service_channel_id;
                        var service_option = data[i].service_option;
                        var option_code = data[i].option_code;
                        var new_count = i + 1;
                        var price = data[i].price;
                        html += '<div class="row-fluid" style="margin-left: 25px;">';
                        html += '<label for="service"></label>';
                        html += '<div class="checkbox checkbox-circle checkbox-success">';
                        html += '<input type="checkbox" id="checkbox' + new_count + '" name="" class="service" value="' + data[i].service_channel_id + '"/>';
                        html += '<label for="checkbox' + new_count + '">' + data[i].service_option + ' ' + data[i].option_code + ' Price: ' + price + '</label>'
                        html += '</div>';
                        html += '</div>';
                    }
                    $('#service-container').html(html);
                }
            }
        });
    }else{
        $('#service-container').html('');
    }
});

/* place code for attaching, editing or detaching unit attributes here*/
$('.edit-unit-attr').on('click',function(){
   var edit_id = $(this).attr('edit-id');
    var data = { 'action': 'edit-house-attr',
                    'edit_id': edit_id
    }
    $('#edit_id').val(edit_id);
    $.ajax({
        type: 'POST',
        url: '?num=900',
        data: data,
        dataType: 'json',
        success: function (data){
            $('#attribute_value1-e').val(data['attr_value']);
        }
    });
});

//action when detach button is clicked

$('.del-unit-attr').on('click',function () {
    var detach_id = $(this).attr('delete-id');
    $('#delete_id').val(detach_id);
});
/*  end */

$('.detach_service_from_house').on('click', function () {
    var s_id = $('#h_detach-id').val();
    if (s_id == ''){
        alert('Please select a service to detach first');
    }
})
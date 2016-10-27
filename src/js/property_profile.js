//function to attach property services
var HideServiceChargeRadio = {
    hide: function(data){
        if(data != 'per-sqr-ft' ){
            $('.hide-s').hide();
        }else{
            $('.hide-s').show();
        }
    }
};
var AttachPropertyServices = {
    action: function(data_obj){
        $.ajax({
            url:'?num=5001',
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
            url: '?num=5001',
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
$('.profile_table,.live_table').on('click', 'tr', function() {
    var house_id = $(this).children('td:first').text();
    $('#attach_service').val(house_id);
    var service_id = $(this).children('td:first').text();
    $('#detach-id').val(service_id);
    $('.detach_service_to_plot').attr('data-toggle', 'modal');
    //prepare to show the dialog
    $('.edit-house').attr('data-toggle', 'modal');
    $('.delete-house').attr('data-toggle', 'modal');
    $('#edit_ho').val(house_id);
    $('#del_id').val(house_id);


    //get ailments details and place then on the edit modal
    var data ={ 'action': 'edit-house-details',
        'house_id': house_id
    }
    $.ajax({
        type: 'POST',
        url: '?num=5001',
        data: data,
        dataType: 'json',
        success:  function (data){
            $('#unit-number').val(data['house_number']);
            if(data['rent_rate'] == 'per-sqr-ft'){
                $('.psqf').removeAttr('checked').parent().addClass('checked');
                $('.rnt-rate').slideDown('slow');
            }else if(data['rent_rate'] == 'flat-rate'){
                $('.ftrt').attr('checked','checked').parent().addClass('checked');
                $('.psqf').removeAttr('checked').parent().removeClass('checked');
                $('.rnt-rate').slideUp('slow');
            }
            $('#sqr-feet-e').val(data['square_footage']);
            if(data['service_charge'] == 'percentage_of_rent'){
                $('#p-r-e').val(data['service_charge_rate']*100);
                $('.scharge').removeAttr('checked').parent().addClass('checked');
                $('.s-charge-rate').slideUp('slow');
                $('.scpsqf').removeAttr('checked').parent().removeClass('checked');
                $('.percentage-rate').slideDown('slow');
                $('.t-s-charge').slideDown('slow');
            }else if(data['service_charge'] == 'charge_per_sqr_feet'){
                $('#rate-ps-e').val(data['service_charge_rate']);
                $('.none').removeAttr('checked').parent().removeClass('checked');
                $('.scharge').removeAttr('checked').parent().removeClass('checked');
                $('.scpsqf').parent().addClass('checked');
                $('.s-charge-rate').slideDown('slow');
                $('.t-s-charge').slideDown('slow');
                $('.percentage-rate').slideUp('slow');
            }else if(data['service_charge'] == 'none' || ''){
                $('.none').attr('checked','checked').parent().addClass('checked');
                $('.scpsqf').removeAttr('checked').parent().removeClass('checked');
                $('.scharge').removeAttr('checked').parent().removeClass('checked');

                $('.t-s-charge').slideUp('slow');
                $('.percentage-rate').slideUp('slow');
            }


            $('#rate-e').val(data['rate_per_square_footage']);
            $('#rent_amnt').val(data['rent_amount']);
            $('#service-charge-amount-e').val(data['total_service_charge']);
        }
    });

});

//listen to the click event for the attach button
$('.attach_service_to_plot').on('click',function(){
    var prop_id = $('#attach_service_id').val();
    // alert(prop_id);
    var the_data = {'prop_id': prop_id,
        'action': 'check_attached'
    };

    AttachPropertyServices.checkTheAttached(the_data);
});

$('body').on('change', 'input:checkbox', function(){
    // alert('clicked');
    var $this = $(this);
    // $this will contain a reference to the checkbox

    var service_id = $(this).val();
    var prop_id = $('#attach_service_id').val();
    // alert(service_id);
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

////to hide or display
$('.rent-r').on('change',function () {
    var rate = $(this).val();
    HideServiceChargeRadio.hide(rate);
    rated = rate;
    if (rate == 'per-sqr-ft'){
        $('#rnt-rate,.rnt-rate').slideDown('slow');
        $('#amount,.amount').slideDown('slow', function () {
            $('#rent_a,.rent_a').attr('required','required');
            $('#rent_a').attr('readonly','readonly');
        });
        $('.chris').attr('required','required');
    }else{
        $('#rent_a').attr('required','required');
        $('#rent_a').removeAttr('readonly','readonly');
        $('#rnt-rate,.rnt-rate').slideUp('slow');
        $('.chris').removeAttr('required','required');
        $('#amount,.amount').slideDown('slow');
    }
});

$('#rate').keyup(function () {
    var sqr_feets = $('.sqr-feet').val();
    var rate =$(this).val();
    var total = (sqr_feets * rate);
    // alert(total);
    $('.rent_a').val(total);
});
$('#rate-e').keyup(function () {
    var sqr_feets = $('#sqr-feet-e').val();
    var rate =$(this).val();
    var total = (sqr_feets * rate);
    // alert(total);
    $('#rent_amnt').val(total);
});

$('.service_charge,.s_charge').click(function(){
    var charge = $(this).val();
    if($(this).is(':checked')){
        switch (charge){
            case 'charge_per_sqr_feet':
                if($('input:radio.rent_r_default').is(':checked')){
                    // check if the rent rate per square feed is empty
                    var squre = 1;

                    if(squre == ''){
                        alert('Rent Rate must be per square feet first');
                    }else{
                        $('#s-charge-rate,.s-charge-rate').slideDown('slow');
                        $('#t-s-charge,.t-s-charge').slideDown('slow');
                        $('#percentage-rate,.percentage-rate').slideUp('slow');
                        $('#rate-ps,.rate-ps').attr('required','required');
                        $('#service-charge-amount,.service-charge-amount').attr('required','required');
                        $('#p-r,.p-r').removeAttr('required');
                    }
                }else{
                    alert('Rent Rate must be per square feet first');
                }

                $(this).parent().removeClass('checked').removeAttr('checked');
                break;

            case 'percentage_of_rent':
                $('#s-charge-rate,.s-charge-rate').slideUp('slow');
                $('#percentage-rate,.percentage-rate').slideDown('slow');
                $('#t-s-charge,.t-s-charge').slideDown('slow');
                $('#rate-ps,.rate-ps').attr('required');
                $('#p-r,.p-r').attr('required','required');
                $('#service-charge-amount,.service-charge-amount').attr('required','required');
                break;

            default:
                $('#rate-ps,.rate-ps').removeAttr('required');
                $('#p-r,.p-r').removeAttr('required');
                $('#service-charge-amount,.service-charge-amount').removeAttr('required');
                $('#s-charge-rate,.s-charge-rate').slideUp('slow');
                $('#t-s-charge,.t-s-charge').slideUp('slow');
                $('#percentage-rate,.percentage-rate').slideUp('slow');
                break;
        }
    }
});
$('#rate-ps-e').keyup(function () {
   // $('#service-charge-amount').val('');
    var squre_feet = $('#sqr-feet-e').val();
       // alert(squre_feet);
    if(squre_feet == ''){
        alert('please enter squire feet first');
        return true;
    }else{
        var rate = $(this).val();
        var charge = (squre_feet * rate);
        $('#service-charge-amount-e').val(charge);
    }
});
$('#p-r-e').on('keyup', function () {
    //$('#service-charge-amount').val('');
    var rent = $('#rent_amnt').val();
    var percent = $(this).val() * 0.01;
    $('#service-charge-amount-e').val(rent * percent);
})

$('.rate-ps').keyup(function () {
    // $('#service-charge-amount').val('');
    var squre_feet = $('.sqr-feet').val();
    // alert(squre_feet);
    if(squre_feet == ''){
        alert('please enter squire feet first');
        return true;
    }else{
        var rate = $(this).val();
        var charge = (squre_feet * rate);
        $('.service-charge-amount').val(charge);
    }
});
$('.p-r').on('keyup', function () {
    //$('#service-charge-amount').val('');
    var rent = $('.rent_a').val();
    var percent = $(this).val() * 0.01;
    $('.service-charge-amount').val(rent * percent);
})

// load services on keyup
$('#search-key').on('keyup', function(){
    var search_key = $(this).val();
    if(search_key != ''){
        $.ajax({
            url: '?num=5001&action=search_services&search_key='+search_key,
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
$('.edit-house').on('click',function () {
   var id = $('#edit_ho').val();
    if(id == ''){
        alert('Please select a record to edit first');
    }
});
$('.delete-house').on('click',function () {
    var id = $('#del_id').val();
    if(id == ''){
        alert('Please select a record to delete first');
    }
});

$('.edit_spec_btn').click(function() {
    var edit_id = $(this).attr('edit-id');
    // alert(edit_id);
    $('#edit_prop_attr_id').val(edit_id);

    var the_data = { 'action':'edit-property-attribute',
        'edit_id': edit_id};
    //get allocation details and place then on the edit modal
    $.ajax({
        type: 'POST',
        url: '?num=5001',
        data: the_data,
        dataType: 'json',
        success: function(data){
            $('#attribute_value').val(data[0]);
        }
    });

});


//validation(check if a row has been selected)
$('.del_spec_btn').click(function () {
    var del_id = $(this).attr('delete-id');
    //alert(del_id);
    $('#delete_id').val(del_id);
});

//event to listen for detaching a service
$('.detach_service_to_plot').on('click',function () {
    var id = $('#detach-id').val();
    if(id == ''){
        alert('please select a service to detach first');
    }
});
// $('.s_charge_check').on('click',function (e) {
//     e.preventDefault();
//         return true ;
// });

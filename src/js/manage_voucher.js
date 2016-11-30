$('.edit_voc').on('click', function(){
    var voucher_id = $(this).attr('voucher_id');
    $('#vouch_id').val(voucher_id);
    var the_data = {'edit_id': voucher_id};

    //get attribute details and place then on the edit modal
    $.ajax({
        type: 'POST',
        url: 'index.php?num=all_voucher',
        data: the_data,
        dataType: 'json',
        success: function(data){
            $('.complaint_id').val(data['complaint_id']);
            $('.category_id').val(data['category_id']);
            $('#maintenance_name').val(data['maintenance_name']);
        }
    });
});

$('.delete_voc').on('click', function(){
    var voucher_id = $(this).attr('voucher_id');

    $('#voucher_id').val(voucher_id);
});

$('.approve_voc').on('click', function(){
    var voucher_id = $(this).attr('voucher_id');

    if(voucher_id != ''){
        $('#app_voucher_id').val(voucher_id);
    }
});

$('#approve_voucher').click(function(){
    //alert('working');
    $('input[name="action"]').val('approve_maintenance_voucher');
});

$('#decline_voucher').click(function(){
    //alert('working');
    $('input[name="action"]').val('decline_maintenance_voucher');
});

$('#property_id').on('change',function () {
   var id = $(this).val();
    var data = {
        'action':'get-units',
        'id':id
    };
    var html = '';
    html += '<option value="">--Please select a unit--</option>';
    $('#unit_id').html(html);
    $.ajax({
        type: 'POST',
      url: '?num=pm_tickets',
        data:data,
        dataType: 'json',
        success: function (data) {
            if(data) {

                var length = data.length;

                for (var i = 0; i < length; i++) {
                    html += '<option value="' + data[i]['house_id'] + '">' + data[i]['house_number'] + '</option>';
                }
                $('#unit_id').html(html);
            }
        }
    })
});

$('.raise-quotation').on('click',function () {
    var voucher_id = $(this).attr('voucher_id');
    $('#maintenance_id').val(voucher_id);
});
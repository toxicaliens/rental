$('.settle_voucher_btn').on('click',function () {
    var voucher_id = $(this).attr('voucher-id');
    $('#payment_voucher_id').val(voucher_id);
    var data = {
        'action': 'get-voucher-details',
        'voucher_id': voucher_id
    }

    $.ajax({
        url: '?num=payment_vouchers',
        dataType: 'json',
        type: 'POST',
        data: data,
        success: function (data) {
            $('#initial_voucher_amount').val(data['bill_amount']);
            $('#voucher_balance').val(data['bill_balance']);
        }
    })
});

$('#settle-voucher-form').on('submit',function (e) {
    var amount_paid = $('#amount-paid').val();
    var bill_balance = parseFloat($('#voucher_balance').val());
    if(amount_paid != 0){
        var paid_amount = parseFloat(amount_paid);
        if((paid_amount)<=(bill_balance)){
            return true;
        }else{
            alert('Amount paid cannot be greater than the voucher balance');
            return false;
        }
    }else{
        alert('Please enter amount to pay');
        return false;
    }
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


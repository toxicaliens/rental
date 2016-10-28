/**
 * Created by erico on 8/8/16.
 */
$('#cash_received').on('keyup change input', function(){
    var count = 1;
    var cash_received = $(this).val();
    var paid_amount = 0;

    var bill_count = $('#bill_count').val();
    while(count <= bill_count){
        paid_amount = 0;
        var label = 'tag'+count;
        var x = parseFloat($('#'+label).attr('max'));
        // alert(x);

        if(cash_received < 1){
            $('#'+label).val(0);
        }else if(cash_received >= x){
            paid_amount = x;
            $('#'+label).val(paid_amount);
        }else{
            paid_amount = cash_received;
            $('#'+label).val(paid_amount);
        }

        cash_received = cash_received - paid_amount;
        count++;
    }
});

var sum = 0;
$('.cash_paid_per_bill').each(function(){
    sum += +parseFloat($(this).attr('max'));
});
$('#cash_received').attr('max', sum.toFixed(2));


$('.service_bill_selector').on('click', function(){
    var input_sbi = $(this).attr('input-sbi');

    if($(this).is(':checked')){
        // display all fields related to the checked sbi
        $('div[sbi="'+input_sbi+'"').fadeIn('slow').find('input').removeAttr('disabled');
    }else{
        $('div[sbi="'+input_sbi+'"').fadeOut('slow').find('input').attr('disabled', 'disabled');
    }
});


$('select.payment_mode').on('change', function(){
    var mode = $(this).val();
    if(mode == "MPESA" || mode == "CHEQUE"){
        $('.pay_mode').fadeIn('slow').find('input').attr('required', 'required');
    }else{
        $('.pay_mode').fadeOut('slow').find('input').removeAttr('required');
    }
});

$('.cash_paid_per_bill').on('keyup', function () {
    var that = $(this).val();

    // alert('summing....');
    var sum = 0;
    $('.cash_paid_per_bill').each(function(){
        var the_input = parseFloat(($(this).val() != '') ? $(this).val() : 0);
        console.log(the_input);
        sum += +parseFloat(the_input);
    });
    $('#cash_received').val(sum.toFixed(2));
    // alert('finishing...');
});
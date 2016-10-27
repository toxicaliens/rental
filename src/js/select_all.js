
    $('#selectall').click(function(event) { 
        var checked = $(this).is(":checked");

        if(checked){
            //here code if true
            $('.checkbox1').attr('checked', 'checked').parent().addClass('checked');
        }else{
            //code if false
            $('.checkbox1').removeAttr('checked').parent().removeClass('checked');
        }
    });

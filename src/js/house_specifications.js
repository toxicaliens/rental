
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


//validation(check if a row has been selected)
$('.edit_spec_btn').click(function() {
    var edit_id = $(this).attr('edit-id');
    //alert(edit_id);
    $('#edit_id').val(edit_id);

    var the_data = {'edit_id': edit_id};
    //get allocation details and place then on the edit modal
    $.ajax({
        type: 'POST',
        url: '?num=house_alloc',
        data: the_data,
        dataType: 'json',
        success: function(data){
            $('#attribute_value1').val(data['attr_value']);


        }
    });

});


//validation(check if a row has been selected)
    $('.del_spec_btn').click(function () {
        var del_id = $(this).attr('delete-id');
        //alert(del_id);
        $('#delete_id').val(del_id);
    })

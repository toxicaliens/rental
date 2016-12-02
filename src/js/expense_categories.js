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

$('#table1').on('click', 'tr', function() {
    edit_id = $(this).children('td:first').text();
    $('#edit_id').val(edit_id);
    $('#delete_id').val(edit_id);

    //prepare to show the dialog
    $('#edit_expense_btn').attr('data-toggle', 'modal');
    $('#del_expense_btn').attr('data-toggle', 'modal');

    var the_data = { 'action':'get-edit-ailments',
        'edit_id': edit_id};

    //get attribute details and place then on the edit modal
    $.ajax({
        type: 'POST',
        url: '?num=expense_items',
        data: the_data,
        dataType: 'json',
        success: function(data){
            $('#expense_name').val(data['expense_name']);
            $('#expense_code').val(data['code']);
        }
    });
});

//validation(check if a row has been selected)
$('#edit_expense_btn').click(function(){
    var edit_id = $('#edit_id').val();
    if(edit_id == ''){
        alert('Please select a record first');
    }
});

$('#del_expense_btn').click(function(){
    var del_id = $('#delete_id').val();
    if(del_id == ''){
        alert('Please select a record first');
    }
});
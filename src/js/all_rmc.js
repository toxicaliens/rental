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

//get the lease id
$('#table1').on('click', 'tr', function() {
    var edit_id = $(this).children('td:first').text();

    $('#delete_id').val(edit_id);
    $('#editid').val(edit_id);


    $('#edit-channel').attr('data-toggle', 'modal');
    var the_data = {'edit_id': edit_id,
                    'action': 'edit_channel'
    };

    //get lease details and place then on the edit modal
    $.ajax({
        type: 'POST',
        url: '?num=620',
        data: the_data,
        dataType: 'json',
        success: function(data){
                $('#rev_name').val(data['revenue_channel_name']);
                $('#rev_code').val(data['revenue_channel_code']);
        }
    });
});

//validation(check if a row has been selected)
$('#edit-channel').click(function(){
    var edit_id = $('#editid').val();
    if(edit_id == ''){
        alert('Please select a record first');
    }
});

$('#delete-channel').click(function(){
    var delete_id = $('#delete_id').val();
    if(delete_id == ''){
        alert('Please select a record first');
    }else{
        if (confirm('Are you sure you want do delete this revenue channel'))
        var data = { 'action':'delete_channel',
                        'delete_id': delete_id
        }
        $.ajax({
            type: 'POST',
            url: '?num=620',
            data: data,
            dataType: 'json',
            success: function(data){

            }
        })
    }
});
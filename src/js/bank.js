/**
 * Created by JOEL on 7/15/2016.
 */
$('.edit_bank').on('click', function(){
    var edit_id = $(this).attr('edit-id');
    var data = { 'edit_id': edit_id };
    $('#edit_id').val(edit_id);

    if(edit_id != ''){
        $.ajax({
            url: '?num=add_bank',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(data){
                $('#bank_name').val(data['bank_name']);
                $('.created_at').val(data['created_at']);
                if(data['status'] == 't') {
                    $('#status').val(1);
                }else{
                    $('#status').val(0);
                }
            }
        });
    }
});

$('.del_bank').on('click', function(){
    $('#delete_id').val($(this).attr('edit-id'));
});

// datetime picker
$('#datetimepicker2').datetimepicker({
    timepicker:false,
    format:'d/m/Y',
    formatDate:'d/m/Y',
});

// datetime picker2
$('#datetimepicker22').datetimepicker({
    timepicker:false,
    format:'d/m/Y',
    formatDate:'d/m/Y',
});
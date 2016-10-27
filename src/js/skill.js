/**
 * Created by SATELLITE on 8/18/2016.
 */
/**
 * Created by JOEL on 7/15/2016.
 */
$('.edit_skill').on('click', function(){
    var edit_id = $(this).attr('edit-id');
    var data = { 'edit_id': edit_id };
    $('#edit_id').val(edit_id);

    if(edit_id != ''){
        $.ajax({
            url: '?num=manage_skills',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(data){
                $('#skill_name').val(data['skill_name']);
                if(data['status'] == 't') {
                    $('#status').val(1);
                }else{
                    $('#status').val(0);
                }
            }
        });
    }
});

$('.del_skill').on('click', function(){
    $('#delete_id').val($(this).attr('edit-id'));
});
/**
 * Created by SATELLITE on 8/16/2016.
 */
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
    edit_id = $(this).children('td:first').text();
    $('#edit_id').val(edit_id);
    $('#terminate_id').val(edit_id);

    var the_data = {'edit_id': edit_id};

    //get lease details and place then on the edit modal
    $.ajax({
        type: 'POST',
        url: '?num=6010',
        data: the_data,
        dataType: 'json',
        success: function(data){
            $('#doc_name').attr('href',data['local_path']).text(data['doc_name']);
            $('#doc_id').val(data['doc_id']);
            $('#tenant').val(data['tenant']);
            $('#lease_type').val(data['lease']);
            $('#house_id').val(data['house_id']);
            $('#start_date').val(data['start_date']);
            $('#end_date').val(data['end_date']);
            $('#status').val(data['status']);
        }
    });
});

//validation(check if a row has been selected)
$('#edit_lease_btn').click(function(){
    var edit_id = $('#edit_id').val();
    if(edit_id == ''){
        alert('Please select a record first');
    }else{
        $('#edit_lease_btn').attr('data-toggle', 'modal');
    }
});

//js to terminate a lease
$('.terminate_lease').click(function () {
    var terminate_id = $(this).attr('terminate-id');
   // alert(terminate_id);
    $('#trminate_id').val(terminate_id);
});

//js to draw house data from the db
$('#select_plot').on('change',function(){
    var plot_id = $(this).val();
    //alert(plot_id);
    var data ={ 'plot_id' :plot_id,
                'action': 'get_houses'
    }
    $.ajax({
       type: 'POST',
        url: '?num=6010',
        data: data,
        dataType: 'json',
        success: function(data){
            var count = data.length;
            if(count){
                var html = '<option value="">--Choose House--</option>';
                for (var i = 0; i < count; i++){
                    html += '<option value="'+data[i].house_id+'">'+data[i].house_no+'</option>';
                }
                $('#select_house').html(html);
            }
        }
    });
});

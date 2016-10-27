var rev_id = $('#revenue_channel').val();
if(rev_id != ''){
    var data = { 'rev_id': rev_id };

    $.ajax({
        url: 'src/RMC_module/get_revenue_service_options.php',
        type: 'POST',
        data: data,
        dataType: 'json',
        success: function(data){
            var html = '';

            //empty the select list
            $('#service_option').empty();

            for (var i = 0; i <= data.length; i++) {
                html += "<option value=\""+data[i].service_channel_id+"\">"+data[i].service_option+"</option>";
                $('#service_option').append(html);
            };
        }
    });
}

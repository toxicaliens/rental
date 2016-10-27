var dt = $('#received_quotes').DataTable({
    ajax: "?num=received_quotes",
    "processing": true
});


$('#search_quotes').on('submit', function(e){
    e.preventDefault();
    var voucher_id = $('#voucher_id').val();

    dt.ajax.url('?num=received_quotes&filter='+voucher_id).load();
});

$('#refresh').on('click', function(){
    dt.ajax.reload();
});

// award
$('#received_quotes').on('click', '.award-btn', function(){
    if(confirm('Are you sure you want to award?')){
        var quote_id = $(this).attr('quote-id');
        var data = { 'quote_id': quote_id };
        
        $.ajax({
            url: '?num=received_quotes',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(data){
                dt.ajax.reload();
            }
        });
    }else{
        return false;
    }
});

// cancel
$('#received_quotes').on('click', '.cancel-btn', function(){
    if(confirm('Are you sure you want to cancel the award?')){
        var quote_id = $(this).attr('quote-id');
        var data = { 'cancel_quote_id': quote_id };

        $.ajax({
            url: '?num=received_quotes',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(data){
                dt.ajax.reload();
            }
        });
    }else{
        return false;
    }
});
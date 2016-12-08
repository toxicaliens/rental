function show_hide(data) {
    if(data == 'landlord'){
        $('#landlord').show();
        $('#property').hide();
        $('#property_id').val('');
    }else{
        $('#landlord').hide();
        $('#property').show();
        $('#landlord_id').val('');
    }
}
$('#filter_by').on('change',function () {
    var filter_by = $(this).val();
    show_hide(filter_by);
})
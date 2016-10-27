//get the values of the highlighted row for each td
$('.edit_modal').click(function(){
	$(this).parent().addClass('selected_td');
	$('td.selected_td').parent().addClass('highlighted_row');	

	$('#table1').find('tr.highlighted_row').each(function (i) {
        var $tds = $(this).find('td'),
        dept_id = $tds.eq(0).text(),
        afyapoa_id = $tds.eq(1).text(),
        dependant_name = $tds.eq(2).text(),
        dob = $tds.eq(3).text(),
        mcare_id = $tds.eq(4).text(),
        gender = $tds.eq(5).text(),
        status = $tds.eq(6).text();

        var choice = '';
        if(status == 'Active'){
                choice = 1;
        }else{
                choice = 0;
        }

        // alert(band_rate_id+' '+band_from+' '+band_to+' '+unit_rate);
        $('#dept_id').val(dept_id);
        $('#dependant_name').val(dependant_name);
        $('#dob').val(dob);
        $('#gender').val(gender);
        $('#status').val(status);
        $('#mcare_id').val(mcare_id);
        $('#afyapoa_id').val(afyapoa_id);
	});

	$('.selected_td').removeClass('selected_td');
	$('.highlighted_row').removeClass('highlighted_row');
});

$('.delete_modal').click(function(){
	$(this).parent().addClass('selected_td');
	$('td.selected_td').parent().addClass('highlighted_row');	

	$('#table1').find('tr.highlighted_row').each(function (i) {
        var $tds = $(this).find('td'),
        dept_id = $tds.eq(0).text();

        // alert(band_rate_id+' '+band_from+' '+band_to+' '+unit_rate);
        $('#dependant_id').val(dept_id);
	});

	$('.selected_td').removeClass('selected_td');
	$('.highlighted_row').removeClass('highlighted_row');
});
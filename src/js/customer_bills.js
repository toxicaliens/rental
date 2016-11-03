/**
 * Created by erico on 10/31/16.
 */
var CustomerBillsDt = $('#customer_bills').DataTable({
    processing: true,
    serverSide: true,
    ajax: "?num=146",
    order: [[0, 'desc']]
});

// refresh the grid
$('#refresh-dt').click(function() {
    CustomerBillsDt.ajax.reload();
});
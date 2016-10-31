/**
 * Created by erico on 10/31/16.
 */
var CustomerBillsDt = $('#customer_bills').DataTable({
    processing: true,
    serverSide: true,
    ajax: "?num=146"
});

$('#refresh-dt').click(function() {
    CustomerBillsDt.ajax.reload();
});
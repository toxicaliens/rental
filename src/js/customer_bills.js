/**
 * Created by erico on 10/31/16.
 */
var CustomerBillsDt = $('#customer_bills').DataTable({
    processing: true,
    serverSide: true,
    ajax: "?num=146"
});

// refresh the grid
$('#refresh-dt').click(function() {
    CustomerBillsDt.ajax.reload();
});

// filter the grid
CustomerBillsDt.ajax.url('?num=146&filter=1').load();
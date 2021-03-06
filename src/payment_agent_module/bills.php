<?php
if(App::isAjaxRequest()){
    // DB table to use
    $table = 'customer_bills_view';

    // Table's primary key
    $primaryKey = 'bill_id';

    // Array of database columns which should be read and sent back to DataTables.
    // The db parameter represents the column name in the database, while the dt
    // parameter represents the DataTables column identifier. In this case simple
    // indexes
    $columns = array(
        array('db' => 'bill_id', 'dt' => 0),
        array('db' => 'bill_due_date', 'dt' => 1),
        array('db' => 'full_name', 'dt' => 2),
        array('db' => 'bill_amount', 'dt' => 3),
        array('db' => 'service_account', 'dt' => 4),
        array('db' => 'bill_balance', 'dt' => 5)
    );
    require 'src/connection/config.php';
    //    var_dump($dbpass);exit;
    // SQL server connection information
    $sql_details = array(
        'user' => $dbuser,
        'pass' => $dbpass,
        'db' => $dbname,
        'host' => $dbhost,
        'port' => $dbport
    );


    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * If you just want to use the basic configuration for DataTables with PHP
     * server-side, there is no need to edit below this line.
     */

    require('src/models/ssp.class.php');
//    $role = $_SESSION['role_name'];
//    if($role == SystemAdmin){
//        $filter = NULL;
//    }else{
//        $filter =  "WHERE mf_id = '".$_SESSION['mf_id']."'";
//    }
    if($_SESSION['role_name'] != 'System Admin'){
//        $val = null;
        $val = "WHERE mf_id = '" . $_SESSION['mf_id'] . "' OR biller_mfid = '".$_SESSION['mf_id']."'  ";
    }else {
//        var_dump($val);
        $val = '';
    }
    echo json_encode(
        SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $val)
    );
}else{
    set_layout("dt-layout.php", array(
    'pageSubTitle' => 'Bills',
    'pageSubTitleText' => '',
    'pageBreadcrumbs' => array (
        array ( 'url'=>'index.php', 'text'=>'Home' ),
        array ( 'text'=>'Payments & Bills' ),
        array ( 'text'=>'Bills' )
    )
    ));
 ?>

<div class="widget">
  <div class="widget-title">
    <h4>Customer Details</h4>
      <span class="actions">
          <button id="refresh-dt" class="btn btn-info btn-small"><i class="icon-refresh"></i> Refresh</button>
      </span>
  </div>
  <div class="widget-body">
      <table id="customer_bills" class="table table-bordered">
          <thead>
               <tr>
                   <th>Bill#</th>
                   <th>B.Due date</th>
                   <th>Customer Name</th>
                   <th>B.Amount</th>
                   <th>Service Account</th>
                   <th>B.Balance</th>
               </tr>
          </thead>
      </table>
    <div class="clearfix"></div>
</div>
</div>
<?php
    set_js(array('src/js/customer_bills.js')); }
 ?>
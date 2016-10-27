<?php
set_layout("dt-layout.php", array(
  'pageSubTitle' => 'AFYAPOA LOAN REPAYMENTS',
  'pageSubTitleText' => '',
  'pageBreadcrumbs' => array (
    array ( 'url'=>'index.php', 'text'=>'Home' ),
    array ( 'text'=>'Reports' ),
    array ( 'text'=>'Loan Repayments' )
  )
  
));
?>
<div class="widget">
  <div class="widget-title"><h4><i class="icon-reorder"></i> Filters</h4>
    <span class="tools">
      <a href="javascript:;" class="icon-chevron-down"/></a>
    </span>
  </div>
  <div class="widget-body form">
    <form action="" method="post" class="form-horizontal">
      <div class="row-fluid">
        <div class="span6">
          <label for="date_range" class="control-label">Date Range:</label>
          <div class="controls">
            <div class="input-prepend span3">
                   <span class="add-on"><i class="icon-calendar"></i></span><input required title="Choose the date-range" for="date-range" name="date_range" type="text" class="date-range" />
              </div>
          </div>
        </div>
      </div>
      <div class="form-actions">
          <? viewActions($_GET['num'], $_SESSION['role_id']); ?>
        </div>
    </form>
  </div>
</div>
<div class="widget">
  <div class="widget-title"><h4><i class="icon-reorder"></i> All Loan Repayments</h4></div>
  <div class="widget-body form">
    <table id="table1" style="width: 100%" class="table table-bordered">
    <thead>
        <tr>
        <th>Repayment ID#</th>
        <th>Names</th>
        <th>Amount</th>
        <th>Loan</th>
        <th>Source Account</th>
        <th>Target Account</th>
        <th>Target Merchant</th>
        <th>Status</th>       
        </tr>                                                     
    </thead>
  <tbody>
 <?php
  //filter
  if(isset($_POST['date_range'])){
    $date_range = $_POST['date_range'];
    $date_array = explode(' - ', $date_range);
    // echo '<pre>',print_r($date_array), '</pre>';
    $from = strtotime($date_array[0]);
    $to = strtotime($date_array[1]);

    $filter = " WHERE date_started >= '".$from."' AND date_started <= '".$to."'";
  }else{
    $filter = "";
  }

   $distinctQuery = "SELECT lr.*, c.* "
           . "FROM loan_repayments lr "
           . "LEFT JOIN customers c "
           . "ON lr.customer_id = c.customer_id "
           . $filter
           . "Order by repayment_id DESC ";
        
   $resultId = run_query($distinctQuery); 
   $total_rows = get_num_rows($resultId);
  
   
  $con = 1;
  $total = 0;
  while($row = get_row_data($resultId))
  {
    $customer_id=$row['customer_id'];
    $repayment_id = $row['repayment_id'];
    $surname=$row['surname'];
    $status=$row['status'];
     $status = $row['status'];
        if($status == '0'){
      $status = 'Not Active';
    }else{
      $status = 'Active';
    }               
    $surname=$row['surname'];
    $firstname=$row['firstname'];
    $middle_name=$row['middlename'];
    $names = $surname . " ".$firstname;           
    $amount=$row['amount']; 
    $loan_id=$row['loan_id'];
    $source_account=$row['source_account'];
    $target_account=$row['target_account'];
    $target_merchant_id=$row['target_merchant_id'];
    
 ?>
      <tr>
      <td><?=$repayment_id; ?></td>
      <td><?=$names; ?></td>
      <td><?=$amount; ?></td>
      <td><?=$loan_id; ?> </td>
      <td><?=$source_account; ?> </td>
      <td><?=$target_account; ?> </td>    
      <td><?=$target_merchant_id; ?> </td> 
      <td><?=$status; ?></td>
       </tr>
     <?php
 
  }
     
  ?>
  
  </tbody>
</table>
<div class="clearfix"></div>
</div>
</div>


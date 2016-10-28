<?
 set_layout("dt-layout.php", array(
  'pageSubTitle' => 'Revenue Clerks Settlement',
  'pageSubTitleText' => 'Allows Revenue clerks to reconcile cash collected',
  'pageBreadcrumbs' => array (
    array ( 'url'=>'index.php', 'text'=>'Home' ),
    array ( 'text'=>'Payment and Bills' ),
    array ( 'text'=>'Cash Collected' )
  )
  
));

 ?>
 <div class="widget">
  <div class="widget-title"><h4><i class="icon-money"></i> Cash Collection</h4>
    <span class="tools">
      <a href="javascript:;" class="icon-chevron-down"></a>
    </span>
  </div>
  <div class="widget-body form">
  <?
   if(isset($_SESSION['done-deal'])){
  echo $_SESSION['done-deal'];
  unset($_SESSION['done-deal']);
  }
  ?>
<form action="" method="POST" class="form-inline">
  <div class="row-fluid">
    <div class="span6">
      <div class="control-group">
        <label class="control-label">Date: </label>
         <div class="controls">
            <div>
                <input class="m-wrap m-ctrl-medium date-picker" size="32" type="text" name="report_date" value="<?=(isset($_POST['report_date'])) ? $_POST['report_date']: ''; ?>" required/>
            </div>
         </div>
       </div>
    </div>
    <div class="span6">
        <div class="control-group">
            <label for="mf_id" class="control-label">Staff Name:</label>
            <div class="controls">
               <select name="mf_id" id="select2_sample2" class="span12" required>
                  <option value="">--Select Staff--</option>
                  <?php
                      $query_courses = "SELECT s.*, m.* from staff s
                      LEFT JOIN masterfile m ON m.mf_id = s.mf_id
                      order by m.surname ASC";
                      $result_crs = run_query($query_courses);
                      while($ents = get_row_data($result_crs))
                      {
                        $code = $ents['mf_id'];
                        $title = $ents['surname'] . " " .$ents['firstname'] . " " .$ents['middlename']." [".$ents['mf_id']."]";
                        print "<option value={$code}>{$title}</option>";
                      } 
                  ?>
              </select>
            </div>
        </div>
    </div>
  </div>
  <div class="row-fluid">
    <div class="span6">
          <div class="control-group">
              <label for="bank_name" class="control-label">Bank:</label>
              <div class="controls">
                <input type="text" name="bank_name" class="span12" required>
              </div>
          </div>
      </div> 
     <div class="span6">
          <div class="control-group">
              <label for="account_no" class="control-label">Account Number:</label>
              <div class="controls">
                <input type="number" name="account_no" class="span12" required>
              </div>
          </div>
      </div>
  </div>  
  <div class="row-fluid"> 
    <div class="span6">
      <div class="control-group">
        <label for="reference_no" class="control-label">Ref:</label>
        <div class="controls">
           <input type="text" name="reference_no" class="span12" required>
        </div>
      </div>
    </div>
     <div class="span6">
          <div class="control-group">
              <label for="cash_recieved" class="control-label">Amount Recieved:</label>
              <div class="controls">
                <input type="number" name="cash_recieved" class="span12" required>
              </div>
          </div>
      </div>
  </div>
 <div class="row-fluid">
   <div class="span6">
      <div class="control-group">
        <label for="details" class="control-label">Description:</label>
        <div class="controls">
          <textarea name="details" class="span12" readonly style="background-color: #ccc"> EOD SETTLEMENT <? echo date('Y-m-d'); ?></textarea>
        </div>
      </div>
    </div>
  </div>  
    <div class="form-actions">
    <input type="hidden" name="action" id="action" value="cash_collected">
    <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
  </div>
 </form> 
 </div>
</div>

<div class="widget">
  <div class="widget-title"><h4><i class="icon-money"></i> Cash Collected On <? echo date('l jS \of F Y');?></h4>
    <span class="tools">
      <a href="javascript:;" class="icon-refresh"></a>
    </span>
  </div>
  <div class="widget-body">
 <table id="table1" class="table table-bordered">
 <thead>
  <tr>
   <th style="width:50px;">ID#</th>
   <th>Staff Name</th>
   <th>Date</th>
   <th>Amount</th>
   <th>Bank</th>
   <th>Bank Account</th>
   <th>Ref No</th>
   <th>Recieved by</th>
  </tr>
 </thead>
 <tbody>
   <?
     $today = date('Y-m-d H:i:s');
     $distinctQuery = "SELECT cs.*, m.* from clerk_settlement cs
    LEFT JOIN masterfile m ON m.mf_id = cs.mf_id
                    where date_recieved ='$today' 
                    Order by clerk_settlement_id DESC";
     $resultId = run_query($distinctQuery); 
     $total_rows = get_num_rows($resultId); 
    
     
    $con = 1;
    $total = 0;
    while($row = get_row_data($resultId))
    {
      $trans_id = trim($row['clerk_settlement_id']);
      $ref_id = trim($row['mf_id']); 
      $fname = $row['firstname'];
      $sname = $row['surname'];
      $mname = $row['middlename'];
      $date = $row['date_recieved'];
      $recieved = $row['recieved_by'];
         if(isset ($recieved))
                    {
                $name=getFullName($recieved);
                    }
      $amount = $row['cash_recieved']; 
      $bank = $row['bank_name'];
      $account = $row['account_no'];
      $ref = $row['reference_no'];  
     ?>
      <tr>
       <td><?=$trans_id; ?></td>
       <td><?=$sname.' '.$fname.' '.$mname; ?></td>
       <td><?=$date; ?></td>
       <td><?=$amount; ?></td>
       <td><?=$bank; ?></td>
        <td><?=$account; ?></td>
        <td><?=$ref; ?></td>
       <td><?=$name; ?></td>
      </tr>
    <?  } ?>
  </tbody>
</table>
<div class="clearfix"></div>
</div>
</div>
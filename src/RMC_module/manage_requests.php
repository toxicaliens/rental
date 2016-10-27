<?php
 set_layout("dt-layout.php", array(
  'pageSubTitle' => 'MANAGEMENT OF REQUEST',
  'pageSubTitleText' => '',
  'pageBreadcrumbs' => array (
    array ( 'url'=>'index.php', 'text'=>'Home' ),
    array ( 'text'=>'Revenue Management' ),
    array ( 'text'=>'Requests Management' )
  )
));

  $distinctQuery2 = "SELECT count(request_type_id) as total_requests from request_types";
   $resultId2 = run_query($distinctQuery2);
   $arraa = get_row_data($resultId2);
   $total_rows2 = $arraa['total_requests'];
 ?>

   <div class="widget">
    <div class="widget-title">
      <h4>MANAGE REQUEST TYPES</h4>
      <span class="actions">
      </span>
    </div>
    <div class="widget-body">

                <div>
                    <div style="float:right; width:100%; text-align:left;">
                      <?php 
                          if(isset($_SESSION['RMC'])){
  echo $_SESSION['RMC'];
  unset($_SESSION['RMC']);
}
                      ?>
                 
                    </div>
                    <div style="clear:both;"> </div>

                </div>
<br/>

        <form method="post" action="" enctype="multipart/form-data" class="form-inline">
          <div class="control-group">
              <label for="request_type_name" class="control-label">Request Type Name:</label>
              <div class="controls">
                <input type="text" name="request_type_name" id="request_type_name" required/>
              </div><br/>
              <div class="controls">
                <input type="text" name="request_type_code" class="m-wrap popovers" placeholder="Request type code" data-trigger="hover" data-content="Please enter a unique code to help identify the request types easier. Don't forget to update the constants file." data-original-title="Note!" required/>
              </div><br/>
              <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
          </div>
          
          <input type="hidden" name="action" id="action" value="add_requests">
            
          
        </form>

<table id="table1" class="table table-bordered">
 <thead>
  <tr>
   <th>Request Type ID</th>
   <th>Request Type Name</th>
   <th>Request Type Code</th>
   <th>Edit</th>
  </tr>
 </thead>
 <tbody>


 <?
   $distinctQuery = "SELECT * FROM request_types 
           ORDER BY request_type_id DESC";       
   $resultId = run_query($distinctQuery);
   $total_rows = get_num_rows($resultId);

  $con = 1;
  $total = 0;
  while($row = get_row_data($resultId))
  {
    $request_type_id = trim($row['request_type_id']);
    $request_type_name = $row['request_type_name'];
    $request_type_code = $row['request_type_code'];

     ?>
      <tr>
        <td><?=$request_type_id; ?></td> 
        <td><?=$request_type_name; ?></td>
        <td><?=$request_type_code; ?></td>
         <td><a id="edit_link" class="btn btn-mini" href="index.php?num=645&edit_id=<?=$request_type_id; ?>">
                    <i class="icon-edit"></i> Edit</a></td>
            
          </tr>
     <?

  }

  ?>
  </tbody>
</table>

      <div class="clearfix"></div>
    </div>
  </div>
<?php
set_title('View Property Details');
set_layout("form-layout.php", array(
	'pageSubTitle' => 'View Property',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'#', 'text'=>'Home' ),
		array ( 'text'=>'Properties' ),
		array ( 'text'=>'All Properties' ),
		array ( 'text'=>'View Property Details' )
	),
	'pageWidgetTitle'=>'<i class="icon-reorder"></i>View Property'
));

set_css(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css'
));

set_js(array(
	'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js',
)); 

//get the value
$customer=$_GET['id'];
if (isset($customer))
{
    //get the row
    $query="SELECT * FROM property WHERE id = '$customer'";
    $data=run_query($query);
    $total_rows=get_num_rows($data);
}

$con=1;
$total=0;

$row=get_row_data($data);

    //the values
    $id=$row['id'];
		$property_name=$row['property_name'];
		$property_units=$row['property_units'];
		$property_desc=$row['property_desc'];
    $attached_to=$row['attached_to'];
    $units=$row['units'];
?>

<!-- BEGIN INLINE TABS PORTLET-->
<form enctype="multipart/form-data" class="form-horizontal" method="post" id= "" class="widget">
<div class="row-fluid">
    <div class="span12">
        <!--BEGIN TABS-->
        <div class="tabbable tabbable-custom">
           <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1_1" data-toggle="tab">PROPERTY_INFO</a></li>
              <!--<li><a href="#tab_1_2" data-toggle="tab">PRINCIPAL INFO</a></li>
              <li><a href="#tab_1_3" data-toggle="tab">DEPENDANTS</a></li>
              <li><a href="#tab_1_4" data-toggle="tab">SAVINGS</a></li>
              <li><a href="#tab_1_5" data-toggle="tab">RE-PAYMENTS</a></li>
              <li><a href="#tab_1_5" data-toggle="tab">HOSP. BILLING</a></li>-->
           </ul>
                                 
        <div class="tab-content">
          <div class="tab-pane row-fluid active" id="tab_1_1">
               <?php include "prop_info.php"; ?>
          </div>   
            
          <!-- <div class="tab-pane" id="tab_1_2">   
                <?php //include "profile_info.php"; ?>
           </div>

           <div class="tab-pane" id="tab_1_3">
                <?php //include "dependants.php"; ?>
           </div>
		
           <div class="tab-pane" id="tab_1_4">
                <?php //include "bills_info.php"; ?>
           </div>					

           <div class="tab-pane" id="tab_1_5">
                <?php //include "transfer_request.php"; ?>
           </div>
           <div class="tab-pane" id="tab_1_5">
                <?php //include "transfer_request.php"; ?>
           </div>-->
          
        </div>
        																
        </div>
        <!--END TABS-->
        <!-- END PAGE --> 
    </div>
</div>
</form>

                                 




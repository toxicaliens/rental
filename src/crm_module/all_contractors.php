<?php
/**
 * Created by PhpStorm.
 * User: joel
 * Date: 8/23/16
 * Time: 9:21 AM
 */

	include_once ('src/models/Masterfile.php');
	$mf = new Masterfile();
	set_title('All Contractors');
	set_layout("dt-layout.php", array(
        'pageSubTitle' => 'All Contractors',
        'pageSubTitleText' => '',
        'pageBreadcrumbs' => array (
            array ( 'url'=>'index.php', 'text'=>'Home' ),
            array ( 'text'=>'CRM' ),
            array ( 'text'=>'All Contractors' )
        )
    ));

?>
<div class="widget">
    <div class="widget-title"><h4><i class="icon-reorder"></i> All Contractors</h4></div>
    <div class="widget-body form">
        <table id="table1" style="width: 100%" class="table table-bordered">
            <thead>
            <tr>
                <th>MF#</th>
                <th>Start Date</th>
                <th>Full Name</th>
                <th>Id No#</th>
                <th>Gender</th>
                <th>Masterfile Type</th>
                <th>E-mail</th>
                <th>Core Activity</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $rows = $mf->getAllContractors();

            if(count($rows)){
                foreach ($rows as $row){
                    $mf_id = $row['mf_id'];
                    $regdate_stamp = $row['regdate_stamp'];
                    $full_name = $row['full_name'];
                    $id_passport = $row['id_passport'];
                    $gender = $row['gender'];
                    $customer_type_name = $row['customer_type_name'];
                    $email = $row['email'];
                    $skills = $row['skills'];
                    ?>
                    <tr>
                        <td><?php echo $mf_id; ?></td>
                        <td><?php echo $regdate_stamp; ?></td>
                        <td><?php echo $full_name; ?></td>
                        <td><?php echo $id_passport; ?></td>
                        <td><?php echo $gender; ?></td>
                        <td><?php echo $customer_type_name; ?></td>
                        <td><?php echo $email; ?></td>
                        <td><?php echo $skills; ?></td>
                    </tr>
                <?php }} ?>

            </tbody>
        </table>
        <div class="clearfix"></div>
    </div>
</div>


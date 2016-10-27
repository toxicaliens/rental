<?php
/**
 * Created by PhpStorm.
 * User: joel
 * Date: 8/23/16
 * Time: 12:15 PM
 */

	include_once ('src/models/Masterfile.php');
	$mf = new Masterfile();
	set_title('All Landlords');
	set_layout("dt-layout.php", array(
        'pageSubTitle' => 'All Landlords',
        'pageSubTitleText' => '',
        'pageBreadcrumbs' => array (
            array ( 'url'=>'index.php', 'text'=>'Home' ),
            array ( 'text'=>'CRM' ),
            array ( 'text'=>'All Landlords' )
        )
    ));

?>
<div class="widget">
    <div class="widget-title"><h4><i class="icon-reorder"></i> All Landlords</h4></div>
    <div class="widget-body form">
        <table id="table1" style="width: 100%" class="table table-bordered">
            <thead>
            <tr>
                <th>MF#</th>
                <th>Start Date</th>
                <th>Full Name</th>
                <th>Gender</th>
                <th>Id No#</th>
                <th>E-mail</th>
                <th>Masterfile Type</th>
                <th>Bank</th>
                <th>Branch</th>
                <th>Account No#</th>
                <th>Kra Pin#</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $rows = $mf->getAllLandlords();

            if(count($rows)){
                foreach ($rows as $row){
                    $mf_id = $row['mf_id'];
                    $regdate_stamp = $row['regdate_stamp'];
                    $full_name = $row['full_name'];
                    $id_passport = $row['id_passport'];
                    $gender = $row['gender'];
                    $customer_type_name = $row['customer_type_name'];
                    $email = $row['email'];
                    $bank_name = $row['bank_name'];
                    $branch_name = $row['branch_name'];
                    $account_no = $row['account_no'];
                    $pin_no = $row['pin_no'];
                    ?>
                    <tr>
                        <td><?php echo $mf_id; ?></td>
                        <td><?php echo $regdate_stamp; ?></td>
                        <td><?php echo $full_name; ?></td>
                        <td><?php echo $gender; ?></td>
                        <td><?php echo $id_passport; ?></td>
                        <td><?php echo $email; ?></td>
                        <td><?php echo $customer_type_name; ?></td>
                        <td><?php echo $bank_name; ?></td>
                        <td><?php echo $branch_name; ?></td>
                        <td><?php echo $account_no; ?></td>
                        <td><?php echo $pin_no; ?></td>
                    </tr>
                <?php }} ?>

            </tbody>
        </table>
        <div class="clearfix"></div>
    </div>
</div>


<?php
/**
 * Created by PhpStorm.
 * User: joelmuindi
 * Date: 7/27/16
 * Time: 2:40 PM
 */
    include_once ('src/models/House.php');
    $house = new House();

    set_title('My Properties');
    set_layout("dt-layout.php", array(
        'pageSubTitle' => 'My Properties',
        'pageSubTitleText' => '',
        'pageBreadcrumbs' => array (
            array ( 'url'=>'index.php', 'text'=>'Home' ),
            array ( 'text'=>'CRM' ),
            array ( 'text'=>'My Properties' )
        )
    ));
?>
<div class="widget">
    <div class="widget-title"><h4><i class="icon-reorder"></i> My Properties</h4></div>
    <div class="widget-body form">
        <table id="table1" style="width: 100%" class="table table-bordered">
            <thead>
            <tr>
                <th>MF#</th>
                <th>Full Name</th>
                <th>Date Created</th>
                <th>Plot Name</th>
                <th>Units</th>
                <th>Paybill No#</th>
                <th>Payment Code</th>
                <th>Lr No#</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $rows = $house->getAllPlotsUnderLandlord();
            if(count($rows)){
                foreach ($rows as $row){
                    $mf_id = $row['mf_id'];
                    $full_name = $row['full_name'];
                    $date_created = $row['date_created'];
                    $plot_name = $row['plot_name'];
                    $units = $row['units'];
                    $paybill_number = $row['paybill_number'];
                    $payment_code = $row['payment_code'];
                    $lr_no = $row['lr_no'];
                    ?>
                    <tr>
                        <td><?php echo $mf_id; ?></td>
                        <td><?php echo $full_name; ?></td>
                        <td><?php echo $date_created; ?></td>
                        <td><?php echo $plot_name; ?></td>
                        <td><?php echo $units; ?></td>
                        <td><?php echo $paybill_number; ?>
                        <td><?php echo $payment_code; ?>
                        <td><?php echo $lr_no; ?>
                    </tr>
                <?php }} ?>
            </tbody>
        </table>
        <div class="clearfix"></div>
    </div>
</div>


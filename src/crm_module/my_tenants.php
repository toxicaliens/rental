<?php
/**
 * Created by PhpStorm.
 * User: joelmuindi
 * Date: 7/26/16
 * Time: 9:44 AM
 */
    include_once ('src/models/House.php');
    $house = new House();

    set_title('My Tenants');
    set_layout("dt-layout.php", array(
        'pageSubTitle' => 'My Tenants',
        'pageSubTitleText' => '',
        'pageBreadcrumbs' => array (
            array ( 'url'=>'index.php', 'text'=>'Home' ),
            array ( 'text'=>'CRM' ),
            array ( 'text'=>'My Tenants' )
        )
    ));
?>
<div class="widget">
    <div class="widget-title"><h4><i class="icon-reorder"></i> My Tenants</h4></div>
    <div class="widget-body form">
        <table id="table1" style="width: 100%" class="table table-bordered">
            <thead>
            <tr>
                <th>MF#</th>
                <th>Start Date</th>
                <th>Full Name</th>
                <th>Plot Name</th>
                <th>House No#</th>
                <th>Id No#</th>
            </tr>
            </thead>
            <tbody>
                <?php
                    $rows = $house->getAllMyTenants();

                    if(count($rows)){
                        foreach ($rows as $row){
                            $mf_id = $row['mf_id'];
                            $start_date = $row['start_date'];
                            $full_name = $row['full_name'];
                            $plot_name = $row['plot_name'];
                            $house_number = $row['house_number'];
                            $id_passport = $row['id_passport'];
                            $b_role = $row['b_role'];
                    ?>
                    <tr>
                        <td><?php echo $mf_id; ?></td>
                        <td><?php echo $start_date; ?></td>
                        <td><?php echo $full_name; ?></td>
                        <td><?php echo $plot_name; ?></td>
                        <td><?php echo $house_number; ?></td>
                        <td><?php echo $id_passport; ?>
                    </tr>
                <?php }} ?>

            </tbody>
        </table>
        <div class="clearfix"></div>
    </div>
</div>




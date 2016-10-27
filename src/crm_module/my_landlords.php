<?php
/**
 * Created by PhpStorm.
 * User: joelmuindi
 * Date: 7/26/16
 * Time: 9:44 AM
 */
    include_once ('src/models/House.php');
    $house = new House();

    set_title('My Landlords');
    set_layout("dt-layout.php", array(
        'pageSubTitle' => 'My Landlords',
        'pageSubTitleText' => '',
        'pageBreadcrumbs' => array (
            array ( 'url'=>'index.php', 'text'=>'Home' ),
            array ( 'text'=>'CRM' ),
            array ( 'text'=>'My Landlords' )
        )
    ));
?>
<div class="widget">
    <div class="widget-title"><h4><i class="icon-reorder"></i> My Landlords</h4></div>
    <div class="widget-body form">
        <table id="table1" style="width: 100%" class="table table-bordered">
            <thead>
                <tr>
                    <th>MF#</th>
                    <th>Full Name</th>
                    <th>Gender</th>
                    <th>Units</th>
                    <th>Created Date</th>
                    <th>Id No#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $rows = $house->getAllMyLandlords();
                    if(count($rows)){
                        foreach ($rows as $row){
                            $mf_id = $row['mf_id'];
                            $date_created = $row['date_created'];
                            $full_name = $row['full_name'];
                            $gender = $row['gender'];
                            $units = $row['units'];
                            $id_passport = $row['id_passport'];
                            $b_role = $row['b_role'];
                            ?>
                            <tr>
                                <td><?php echo $mf_id; ?></td>
                                <td><?php echo $full_name; ?></td>
                                <td><?php echo $gender; ?></td>
                                <td><?php echo $units; ?></td>
                                <td><?php echo $date_created; ?></td>
                                <td><?php echo $id_passport; ?>
                            </tr>
                <?php }} ?>
            </tbody>
        </table>
        <div class="clearfix"></div>
    </div>
</div>




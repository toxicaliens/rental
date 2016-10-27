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
    'pageSubTitle' => 'My Contractors',
    'pageSubTitleText' => '',
    'pageBreadcrumbs' => array (
        array ( 'url'=>'index.php', 'text'=>'Home' ),
        array ( 'text'=>'CRM' ),
        array ( 'text'=>'My Contractors' )
    )
));
?>
<div class="widget">
    <div class="widget-title"><h4><i class="icon-reorder"></i> My Contractors</h4></div>
    <div class="widget-body form">
        <table id="table1" style="width: 100%" class="table table-bordered">
            <thead>
            <tr>
                <th>MF#</th>
                <th>Full Name</th>
                <th>Skills</th>
                <th>Ratings</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $rows = $house->getAllContractorsUnderPM();
            if(count($rows)){
                foreach ($rows as $row){
                    $mf_id = $row['mf_id'];
                    $full_name = $row['full_name'];
                    $skills = $row['skills'];
                    $ratings = $row['ratings'];
                    ?>
                    <tr>
                        <td><?php echo $mf_id; ?></td>
                        <td><?php echo $full_name; ?></td>
                        <td><?php echo $skills; ?></td>
                        <td><?php echo $ratings; ?></td>
                    </tr>
                <?php }} ?>
            </tbody>
        </table>
        <div class="clearfix"></div>
    </div>
</div>

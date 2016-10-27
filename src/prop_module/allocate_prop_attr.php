<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 19/07/16
 * Time: 14:02
 */
include_once 'src/models/Plots.php';
$prop = new Plots;
if(app::isAjaxRequest()){

}else{
    set_title('Allocate Attributes');
    set_layout("dt-layout.php", array(
        'pageSubTitle' => 'Property',
        'pageSubTitleText' => '',
        'pageBreadcrumbs' => array (
            array ( 'url'=>'#', 'text'=>'Home' ),
            array ( 'text'=>'Property Details' )
        ),
        'pageWidgetTitle'=>'<i class="icon-reorder"></i>View Property'
    ));
    ?>

    <div class="widget">
        <div class="widget-title"><h4><i class="icon-reorder"></i>Allocate Attributes</h4>

        </div>

        <div class="widget-body form">
            <?php
            if(isset($_SESSION['houses'])){
                echo $_SESSION['houses'];
                unset($_SESSION['houses']);
            }
            ?>
            <table id="table1" class="table table-bordered">
                <thead>

                <tr>
                    <th>Prop ID#</th>
                    <th>Property Name</th>
                    <th>Allocate/detach </th>
                </tr>
                </thead>
                <tbody>
                <?php

                $rows = $prop->getAllPlots();
                if($rows){
                    foreach($rows as $row){

                        ?>

                        <tr>
                            <td><?=$row['plot_id']; ?></td>
                            <td><?=$row['plot_name'];?></td>
                            <td><a href="?num=prop_alloc&&p_name=<?php echo $row['plot_name']?>&&plot_id=<?php echo $row['plot_id'];?>" class="btn btn-success btn-small"><i class="icon-plus-sign"></i> Allocate attributes</a> </td>
                        </tr>

                    <?php }}?>
                </tbody>
            </table>
            <div class="clearfix"></div>
        </div>
    </div>


    <?php set_js(array('src/js/house.js')); } ?>
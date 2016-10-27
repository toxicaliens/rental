<?php
/**
 * Created by PhpStorm.
 * User: joel
 * Date: 9/13/16
 * Time: 11:43 AM
 */

    include_once('src/models/Masterfile.php');
    $mf = new Masterfile();

    set_title('My Masterfilw');
    set_layout("dt-layout.php", array(
        'pageSubTitle' => 'Masterfile',
        'pageSubTitleText' => '',
        'pageBreadcrumbs' => array (
            array ( 'url'=>'index.php', 'text'=>'Home' ),
            array ( 'text'=>'MASTETRFILE' ),
            array ( 'text'=>'My Masterfile' )
        )

    ));
?>
<div class="widget">
    <div class="widget-title"><h4><i class="icon-reorder"></i> My Masterfile</h4></div>
    <div class="widget-body form">
        <?php
        // display all encountered errors
        $mf->splash('mf');
        (isset($_SESSION['mf_warnings'])) ? $mf->displayWarnings('mf_warnings') : '';
        ?>
        <table id="table1" style="width: 100%" class="table table-bordered">
            <thead>
            <tr>
                <th>MF#</th>
                <th>Start Date</th>
                <th>Surname</th>
                <th>First Name</th>
                <th>Customer Type</th>
                <th>Email</th>
                <th>B. Role</th>
                <th>Edit</th>
                <th>Profile</th>
            </tr>
            </thead>
            <tbody>
            <?php
                $rows = $mf->getAllMyMasterfile();

                if(count($rows)){
                    foreach ($rows as $row){
                        $mf_id = $row['mf_id'];
                        $regdate_stamp = $row['regdate_stamp'];
                        $surname = $row['surname'];
                        $firstname = $row['firstname'];
                        $email = $row['email'];
                        $customer_type_name = $row['customer_type_name'];
                        $b_role = $row['b_role'];
                        ?>
                    <tr>
                        <td><?php echo $mf_id; ?></td>
                        <td><?php echo $regdate_stamp; ?></td>
                        <td><?php echo $surname; ?></td>
                        <td><?php echo $firstname; ?></td>
                        <td><?php echo $customer_type_name; ?></td>
                        <td><?php echo $email; ?></td>
                        <td><?php echo $b_role; ?>
                        <td><a id="edit_link" href="index.php?num=721&mf_id=<?php echo $mf_id; ?>"
                               class="btn btn-mini"><i class="icon-edit"></i> Edit</a></td>
                        <td><a id="profile" href="index.php?num=724&mf_id=<?php echo $mf_id; ?>"
                               class="btn btn-mini"><i class="icon-user"></i> Profile</a></td>
                    </tr>
                <?php }} ?>
            </tbody>
        </table>
        <div class="clearfix"></div>
    </div>
</div>


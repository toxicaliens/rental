<?php
    include_once 'src/model/Reciepts.php';
    $rec = new Reciepts(1);

    set_title('All Receipts');
    set_layout('dt-layout.php', array(
        'pageSubTitle' => 'All Receipts',
        'pageSubTitleText' => '',
        'pageBreadcrumbs' => array(
            array(
                'url' => 'index.php',
                'text' => 'Home'
            ),
            array(
                'text' => 'Payments & Bills'
            ),
            array(
                'url' => '?num=receipts',
                'text' => 'All Receipts'
            )
        )
    ));
?>
<div class="widget">
    <div class="widget-title"><h4><i class="icon-reorder"></i> All Receipts</h4></div>
    <div class="widget-body form">
        <table id="table1" class="table table-bordered">
            <thead>
                <tr>
                    <th>Receipt#</th>
                    <th>Receipt Number</th>
                    <th>Receipt Date</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $receipts = $rec->selectQuery('receipts', '*');
                if(count($receipts)){
                    foreach ($receipts as $row) {
            ?>
                <tr>
                    <td><?php echo $row['receipt_id']; ?></td>
                    <td><?php echo $row['generated_code']; ?></td>
                    <td><?php echo date('Y-m-d H:i:s', strtotime($row['receipt_date'])); ?></td>
                    <td>
                        <?php
                            if($row['receipt_type'] == Pay_Bill){
                        ?>
                        <a href="?num=171&rec_no=<?php echo $row['generated_code']; ?>" class="btn btn-mini"><i class="icon-eye-open"></i> View Receipt</a>
                        <?php }else if($row['receipt_type'] == Buy_Service){ ?>
                        <a href="?num=170&order_id=<?php echo $row['order_id']; ?>" class="btn btn-mini"><i class="icon-eye-open"></i> View Receipt</a>
                        <?php }else{ ?>
                        Receipt Type not Found!
                        <?php } ?>
                    </td>
                </tr>
            <?php }} ?>
            </tbody>
        </table>
        <div class="clearfix"></div>
    </div>
</div>

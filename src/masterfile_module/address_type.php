<?php
    include_once ('src/models/Masterfile.php');
    $mf = new Masterfile();

    set_title('Address Types');
?>
<table id="table1" class="table table-bordered">
    <thead>
        <tr>
            <th>Address type Id</th>
            <th>Address type Name</th>
            <th>Address Status</th>
            <th>Edit</th>
        </tr>
    </thead>                      
    <tbody>
        <?php
        $rows = $mf->getAllAddressType();
        $rows = $rows['all'];

        if(count($rows)){
            foreach ($rows as $row){
                $address_type_id = $row['address_type_id'];
                $address_type_name = $row['address_type_name'];
                $status = $row['status'];
                ?>
		<tr>
		    <td><?php echo $address_type_id; ?></td>
			<td><?php echo $address_type_name; ?></td>
			<td>
			<?php if($status == '1'){
		        echo 'Active';
		      }else{
		        echo 'Inactive';
		      }?>
           </td>
            <td><a href="?num=728&address_type_id=<?php echo $address_type_id; ?>" class="btn btn-mini"><i class="icon-edit"></i> Edit</td>
        </tr>
		 <?php }} ?>
  </tbody>
</table>

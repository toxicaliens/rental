<?php
	include_once ('src/models/Masterfile.php');
	$mf = new Masterfile();
	set_title('All Clients');
	set_layout("dt-layout.php", array(
		'pageSubTitle' => 'All Tenants',
		'pageSubTitleText' => '',
		'pageBreadcrumbs' => array (
			array ( 'url'=>'index.php', 'text'=>'Home' ),
			array ( 'text'=>'CRM' ),
			array ( 'text'=>'All Tenants' )
		)
	));

?>
<div class="widget">
	<div class="widget-title"><h4><i class="icon-reorder"></i> All Tenants</h4></div>
	<div class="widget-body form">
    	<table id="table1" style="width: 100%" class="table table-bordered">
 		<thead>
			<tr>
			  	<th>MF#</th>
				<th>Start Date</th>
				<th>Surname</th>
				<th>First Name</th>
				<th>Id No#</th>
				<th>Edit</th>
				<th>Profile</th>			  
			</tr>
 		</thead>
		<tbody>
		<?php
			$rows = $mf->getAllTenants();

			if(count($rows)){
			foreach ($rows as $row){
				$mf_id = $row['mf_id'];
				$regdate_stamp = $row['regdate_stamp'];
				$surname = $row['surname'];
				$firstname = $row['firstname'];
				$email = $row['email'];
				$id_passport = $row['id_passport'];
				$b_role = $row['b_role'];
		?>
		<tr>
			<td><?php echo $mf_id; ?></td>
			<td><?php echo $regdate_stamp; ?></td>
			<td><?php echo $surname; ?></td>
			<td><?php echo $firstname; ?></td>
			<td><?php echo $id_passport; ?></td>
			<td><a id="edit_link" href="index.php?num=721&mf_id=<?=$mf_id; ?>" class="btn btn-mini"><i class="icon-edit"></i> Edit</a></td>
			<td><a id="edit_link" href="index.php?num=724&mf_id=<?=$mf_id; ?>" class="btn btn-mini"><i class="icon-eye-open"></i> Profile</a></td>
		</tr>
		<?php }} ?>
  
  </tbody>
</table>
		<div class="clearfix"></div>
	</div>
</div>


<?php
	if(isset($_SESSION['mes3'])){
    echo "<p style='color:#f00; font-size:16px;'>".$_SESSION['mes3']."</p>";
    unset($_SESSION['mes3']);
}
?>
<form action="" method="post" id="manage_menu">
	<table id="table1" class="table table-bordered">
		<!-- id="table1" class="table table-bordered" -->
		<thead>
			<th>MENU ID</th>
			<th>MENU ITEM</th>
			<th>SEQUENCE</th>
			<th>PARENT</th>
			<th>EDIT</th>
		</thead>
		<tbody>
			<?php manageMenu(null); ?>
		</tbody>
	</table> <div class="clearfix"></div>
	<div class="form-actions">
		<?php
			viewActions($_GET['num'], $_SESSION['role_id']);
		?>
	</div>
	<input name="action" type="hidden" value="manage_menu" />
</form>
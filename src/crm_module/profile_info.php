<!--begin form-->
<form action=""enctype="multipart/form-data" class="form-horizontal">
	<div class="row-fluid">
	    <div class="span2">
	        <div class="control-group">
				<img src="assets/crm_images/ID_<?=$ccn_customer_id; ?>.jpg" alt="" />
			</div>
		</div>
		<div class="span10">
           <div class="row-fluid">
                <div class="control-group">
                    <h1><?=$surname; ?></h1>
                    <h4><?=$address_name; ?></h4>
                    <hr/>
			    </div>
		    </div>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label class="control-label">ID NO./PASSPORT:</label>
				<div class="controls">
					<b><?=$national_id_number; ?></b>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label class="control-label">FIRST NAME:</label>
				<div class="controls">
					<b><?=$firstname; ?></b>
				</div>
			</div>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label  class="control-label">MIDDLE NAME: </label>
				<div class="controls">
					<b><?=$middlename; ?></b>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label  class="control-label">SURNAME:</label>
				<div class="controls">
					<b><?=$surname; ?></b>
				</div>
			</div>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label class="control-label">CUSTOMER TYPE:</label>
				<div class="controls">
					<b><?=$customer_type_id; ?></b>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label class="control-label">STATUS:</label>
				<div class="controls">
					<b><?=($status=="1")?"Active":"Inactive"; ?></b>
				</div>
			</div>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label  class="control-label">REGISTRATION DATE: </label>
				<div class="controls">
					<b><?=$regdate_stamp; ?></b>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label class="control-label">START DATE:</label>
				<div class="controls">
					<b><?=$start_date; ?></b>
				</div>
			</div>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label  class="control-label">PHONE: </label>
				<div class="controls">
					<b><?=$phone; ?></b>
				</div>
			</div>
		</div>
	    <div class="span6">
			<div class="control-group">
				<label  class="control-label">ADDRESS:</label>
				<div class="controls">
					<b><?=$address_name; ?></b>
				</div>
			</div>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label  class="control-label">USERNAME:</label>
				<div class="controls">
					<b><?=$username; ?></b>
				</div>
			</div>
		</div>
		<div class="span6">
		    <div class="control-group">
				<label class="control-label">BALANCE:</label>
				<div class="controls">
					<b><?=$balance; ?></b>
				</div>
			</div>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label  class="control-label">EMAIL: </label>
				<div class="controls">
			        <b><?=$email; ?></b>
				</div>
			</div>
		</div>
	</div>
		                       
</form>
<!-- END FORM -->
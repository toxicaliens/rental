<ul class="unstyled span10">
   <li><span>Customer Name:</span> <?=$row['customer_name']; ?></li>
   <li><span>Subject:</span> <?=$row['subject']; ?></li>
   <li><span>Reported By:</span> <?=$supp_tickets->getCustomerName($row['reported_by']); ?></li>
   <li><span>Status:</span> <?=($row['status'] == '0') ? 'Open' : 'Close'; ?> 
   <?php
   		if($row['status'] == '0'){
   ?>
   <button class="btn btn-mini btn-danger" id="close_ticket" recipient="<?=$row['reported_by']; ?>" customer_account_id="<?=$row['customer_account_id']; ?>" ticket_id="<?=$_GET['ticket_id']; ?>"><i class="icon-remove"></i> Close</button>
   <?php }else{ ?>
   <button class="btn btn-mini btn-success" id="open_ticket" recipient="<?=$row['reported_by']; ?>" ticket_id="<?=$_GET['ticket_id']; ?>"><i class="icon-remove"></i> Open</button>
   <?php } ?>
   </li>
   <li><span>Reported Time:</span> <?=date('Y-m-d H:m:s', strtotime($row['reported_time'])); ?></li>
   <li><span>Assigned To:</span> <?=$supp_tickets->getCustomerName($row['assigned_to']); ?></li>
</ul>
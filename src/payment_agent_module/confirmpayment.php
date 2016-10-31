<?php
if ($_GET['trns_id'] && $_GET['amount'] && $_GET['invno'] && $_GET['ebbtransid'])
{
    $transid = $_GET['trns_id'];
    $amount =  $_GET['amount'];
    $invoiceno = $_GET['invno'];
    $ebbtransid = $_GET['ebbtransid'];

  $resultset =  sourceoffund($transid,$amount,$invoiceno,$ebbtransid);

  $resultarry = explode(":",$resultset['response']);
 // print_r($datetime);
 }

 if($resultarry['0'] == "BILL SUCCESS RECPT")
 {
?>
<div id="cashagentreceipts">
    <div id="cashagentreceiptheader">
        <?=$resultarry['0'] ?>
    </div>
    <div id="cashagentreceiptcopy">
        <table>
            <tr>
                <td>Receipt Number:</td>
                <td><?=$resultarry['1'] ?></td>
            </tr>
            <tr>
                <td>Date:</td>
                <td><?=$resultarry['2'] ?></td>
            </tr>
        </table>
    </div>
    <div id="cashagentreceiptfooter">
        <a href="#"></a>
    </div>
</div>
<?
 }
 elseif($resultset['response'] == "ERROR: Option Code could not be mapped to a specific service...")
 {
    echo "Sorry : The service is not available for the moment ... consult system Admin for more details";
 }
 else{
     print_r($resultset['response']);
 }
?>
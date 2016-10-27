<?php

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 13/08/16
 * Time: 20:17
 */
include_once 'src/models/Library.php';
class Lease extends Library{
    public function getAllLeasesByRole(){
        //check whether user is a property manager or a tenant

        $role = $this->checkRole($_SESSION['mf_id']);
        if ($role == 66) {
            //user is a property manager
            $result =  $this->selectQuery('leases','*', " pm_mfid=  '" . $_SESSION['mf_id']. "' ");
        } else if ($role == 68) {
            //user is a landlord
            $result =  $this->selectQuery('leases','*', " landlord_mf_id=  '" . $_SESSION['mf_id']. "' ");
        } else if ($role == 3){
            //if role is admin
            $result = $this->selectQuery('leases', '*');
        }
        //var_dump($result);die;

        return $result;
    }
    public function getNameByMfId($mf_id){
        $result = $this->selectQuery('masterfile','surname,firstname,middlename', "mf_id ='".$mf_id."' ");

        echo $result[0]['surname'].'  '.$result[0]['firstname'].'  '.$result[0]['middlename'];
    }
}
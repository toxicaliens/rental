<?php

/**
 * Created by PhpStorm.
 * User: JOEL
 * Date: 7/14/2016
 * Time: 3:01 PM
 */
include_once ('src/models/Masterfile.php');

class Accounts extends Masterfile{

    public function addBank($post){
        //var_dump($_POST);exit;
        $this->validate($post, array(
            'bank_name' => array(
                'name' => 'Name',
                'required' => true,
                'unique' => 'banks'
            ),
            'created_at' => array(
                'name' => 'Date',
                'required' => true
            ),
            'status' => array(
                'name' => 'Status',
                'required' => true
            )
        ));

        if($this->getValidationStatus()) {
            $result = $this->insertQuery('banks',
                array(
                    'bank_name' => $post['bank_name'],
                    'created_at' => $post['created_at'],
                    'status' => $post['status']
                )
            );
            //var_dump($result);exit;
            if($result){
                $this->flashMessage('acc', 'success', 'A Bank has been added!');
            }else{
                $this->flashMessage('acc', 'error', 'Encountered an error!');
            }
        }
    }

    public function editBank($post){
        //var_dump($post);exit;
        $this->validate($post, array(
            'bank_name' => array(
                'name' => 'Name',
                'required' => true,
                'unique2' => array(
                    'table' => 'banks',
                    'skip_column' => 'bank_id',
                    'skip_value' => $post['edit_id'],
                )
            ),
            'created_at' => array(
                'name' => 'Date',
                'required' => true
            ),
            'status' => array(
                'name' => 'Status',
                'required' => true
            ),
        ));

        if($this->getValidationStatus()) {
            $result = $this->updateQuery2('banks',
                array(
                    'bank_name' => $post['bank_name'],
                    'created_at' => $post['created_at'],
                    'status' => $post['status']
                ),
                array(
                    'bank_id' => $post['edit_id']
                )
            );
            //var_dump($result);exit;
            if($result){
                $this->flashMessage('acc', 'success', 'Bank has been updated!');
            }else{
                $this->flashMessage('acc', 'error', 'Encountered an error!');
            }
        }
    }

    public function deleteBank($id){
        if($this->deleteQuery2('banks', array(
            'bank_id' => $id
        ))){
            $this->flashMessage('acc', 'success', 'Bank has been deleted');
        }else{
            $this->flashMessage('acc', 'warning', 'The Bank details is being used somewhere else in the system!');
        }
    }

    public function addBranch($post){
//        var_dump($_POST);exit;
        $this->validate($post, array(
            'bank_id' => array(
                'name' => 'Bank Name',
                'required' => true
            ),
            'branch_name' => array(
                'name' => 'Name',
                'required' => true,
                'unique' => 'bank_branch'
            ),
            'branch_code' => array(
                'required' => true,
                'unique' => 'bank_branch'
            ),
            'created_at' => array(
                'name' => 'Date',
                'required' => true
            ),
            'status' => array(
                'name' => 'Status',
                'required' => true
            )
        ));

        if($this->getValidationStatus()) {
            $result = $this->insertQuery('bank_branch',
                array(
                    'bank_id' => $post['bank_id'],
                    'branch_name' => $post['branch_name'],
                    'branch_code' => $post['branch_code'],
                    'created_at' => $post['created_at'],
                    'status' => $post['status']
                )
            );
            if($result){
                $this->flashMessage('acc', 'success', 'A new branch has been added!');
            }else{
                $this->flashMessage('acc', 'error', 'Encountered an error!');
            }
        }
    }

    public function editBranch($post){
//        var_dump($post);exit;
        $this->validate($post, array(
            'branch_name' => array(
                'name' => 'Name',
                'required' => true,
                'unique2' => array(
                    'table' => 'bank_branch',
                    'skip_column' => 'branch_id',
                    'skip_value' => $post['edit_id'],
                )
            ),
            'bank_id' => array(
                'name' => 'Bank Name',
                'required' => true
            ),
            'branch_code' => array(
                'name' => 'Branch Code',
                'required' => true,
                'unique2' => array(
                    'table' => 'bank_branch',
                    'skip_column' => 'branch_id',
                    'skip_value' => $post['edit_id']
                )
            )
        ));

        if($this->getValidationStatus()) {
            $result = $this->updateQuery2('bank_branch',
                array(
                    'bank_id' => $post['bank_id'],
                    'branch_name' => $post['branch_name'],
                    'branch_code' => $post['branch_code'],
                    'created_at' => $post['created_at'],
                    'status' => $post['status']
                ),
                array(
                    'branch_id' => $post['edit_id']
                )
            );

            if($result){
                $this->flashMessage('acc', 'success', 'Branch has been updated!');
            }else{
                $this->flashMessage('acc', 'error', 'Encountered an error!');
            }
        }
    }

    public function deleteBranch($id){
        if($this->deleteQuery2('bank_branch', array(
            'branch_id' => $id
        ))){
            $this->flashMessage('acc', 'success', 'Branch has been deleted');
        }else{
            $this->flashMessage('acc', 'warning', 'The Branch is being used somewhere else in the system!');
        }
    }

    public function getAllBank($condition = null){
        extract($_POST);
        $condition = (!is_null($condition)) ? $condition : '';
        $data = $this->selectQuery('banks', '*', $condition);
        return array(
            'all' => $data,
            'specific' => $data[0]
        );
    }

    public function getAllBranch($condition = null){
        $condition = (!is_null($condition)) ? $condition : '';
        $data = $this->selectQuery('bank_and_branches', '*', $condition);
        return array(
            'all' => $data,
            'specific' => $data[0]
        );
    }

    public function getAllBranches($condition = null){
        $condition = (!is_null($condition)) ? $condition : '';
        $data = $this->selectQuery('bank_branch', '*', $condition);
        return array(
            'all' => $data,
            'specific' => $data[0]
        );
    }

    public function getBranchByBranchId($id){
        $data = $this->selectQuery('bank_branch', '*', "branch_id = '".sanitizeVariable($id)."' ");
        echo json_encode($data[0]);
    }

    public function getBankByBankId($id){
        $data = $this->selectQuery('banks', '*', "bank_id = '".sanitizeVariable($id)."' ");
        echo json_encode($data[0]);
    }

    public function getBankBranchesByBankId($id){
        $data = $this->selectQuery('bank_branch', '*', "bank_id = '".$id."'");
        echo json_encode($data);
    }
}
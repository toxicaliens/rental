<?php

/**
 * Created by PhpStorm.
 * User: SATELLITE
 * Date: 8/18/2016
 * Time: 6:33 AM
 */
include_once ('src/models/Masterfile.php');
class Skills extends Masterfile
{
    public function getSkillsBySkillId($id){
        $data = $this->selectQuery('skill_types', '*', "skill_id = '".sanitizeVariable($id)."' ");
        echo json_encode($data[0]);
    }

    public function getSkillBySkillId($id){
        $data = $this->selectQuery('skill_types', '*', "skill_id = '".sanitizeVariable($id)."' ");
        echo json_encode($data[0]);
    }

    public function addSkill($post){
//        var_dump($_POST);exit;
        $this->validate($post, array(
            'skill_name' => array(
                'name' => 'Name',
                'required' => true,
                'unique' => 'skill_types'
            ),
            'status' => array(
                'name' => 'Status',
                'required' => true
            )
        ));

        if($this->getValidationStatus()) {
            $result = $this->insertQuery('skill_types',
                array(
                    'skill_name' => $post['skill_name'],
                    'status' => $post['status']
                )
            );
            if($result){
                $this->flashMessage('skill', 'success', 'A New Skill has Been Added!');
            }else{
                $this->flashMessage('skill', 'error', 'Encountered an error!');
            }
        }
    }

    public function editSkill($post){
//        var_dump($post);exit;
        $this->validate($post, array(
            'skill_name' => array(
                'name' => 'Skill Name',
                'required' => true,
                'unique2' => array(
                    'table' => 'skill_types',
                    'skip_column' => 'skill_name',
                    'skip_value' => $post['edit_id'],
                )
            ),
            'status' => array(
                'name' => 'Skill Status',
                'required' => true
            )
        ));

        if($this->getValidationStatus()) {
            $result = $this->updateQuery2('skill_types',
                array(
                    'skill_name' => $post['skill_name'],
                    'status' => $post['status']
                ),
                array(
                    'skill_id' => $post['edit_id']
                )
            );

            if($result){
                $this->flashMessage('skill', 'success', 'Skill has been updated!');
            }else{
                $this->flashMessage('skill', 'error', 'Encountered an error!');
            }
        }
    }

    public function deleteSkill($id){
        if($this->deleteQuery2('skill_types', array(
            'skill_id' => $id
        ))){
            $this->flashMessage('skill', 'success', 'Skill has been deleted');
        }else{
            $this->flashMessage('skill', 'warning', 'The Skill Detail is being used somewhere else in the system!');
        }
    }
}
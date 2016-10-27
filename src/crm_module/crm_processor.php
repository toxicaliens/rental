<?php
include_once('src/models/Skills.php');
$skill = new Skills();

switch($_POST['action']){
    case add_skill:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $skill->addSkill($_POST);
        $_SESSION['warnings'] = $skill->getWarnings();
        break;

    case edit_skill:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $skill->editSkill($_POST);
        $_SESSION['warnings'] = $skill->getWarnings();
        break;

    case delete_skill:
        logAction($_POST['action'], $_SESSION['sess_id'], $_SESSION['mf_id']);
        $skill->deleteSkill($_POST['delete_id']);
        break;
}

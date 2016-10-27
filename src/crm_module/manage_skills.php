<?php
/**
 * Created by PhpStorm.
 * User: SATELLITE
 * Date: 8/18/2016
 * Time: 6:30 AM
 */

require_once 'src/models/Skills.php';
$skill = new Skills();

if(App::isAjaxRequest()) {
    $skill->getSkillsBySkillId($_POST['edit_id']);
}else{
    set_title('Manage Skills');
    /**
     * Set the page layout that will be used
     */
    set_title('Manage Skills');
    set_layout("dt-layout.php", array(
        'pageSubTitle' => 'Skills Details',
        'pageSubTitleText' => 'Allows one to manage skills details',
        'pageBreadcrumbs' => array(
            array('url' => 'index.php', 'text' => 'Home'),
            array('text' => 'CRM'),
            array('text' => 'Manage Skills')
        ),
        'pageWidgetTitle' => 'Skills Details'
    ));

    ?>
    <div class="widget">
        <div class="widget-title"><h4><i class="icon-reorder"></i> Skills Details</h4>
		<span class="actions">
			<a href="#add_skill" class="btn btn-small btn-primary" data-toggle="modal"><i class="icon-plus"></i> Add Skill</a>
		</span>
        </div>
        <div class="widget-body">
            <?php
                $skill->splash('skill');
                (isset($_SESSION['warnings'])) ? $skill->displayWarnings('warnings') : '';
            ?>
            <table id="table1" class="table table-bordered">
                <thead>
                <tr>
                    <th>Skill#</th>
                    <th>Skill Name</th>
                    <th>Status</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $rows = $skill->getAllSkills();

                if(count($rows)){
                    foreach ($rows as $row){;
                        ?>
                        <tr>
                            <td><?php echo $row['skill_id']; ?></td>
                            <td><?php echo $row['skill_name']; ?></td>
                            <td><?php echo ($row['status'] == 't') ? 'Active': 'Inactive'; ?></td>
                            <td><a href="#update_skill" class="btn btn-mini btn-warning edit_skill" edit-id="<?php echo $row['skill_id']; ?>" data-toggle="modal"><i class="icon-edit"></i> Edit</a> </td>
                            <td><a href="#del_skill" class="btn btn-mini btn-danger del_skill" edit-id="<?php echo $row['skill_id']; ?>" data-toggle="modal"><i class="icon-trash"></i> Delete</a></td>
                        </tr>
                    <?php }} ?>
                </tbody>
            </table>
            <div class="clearfix"></div>
        </div>
    </div>

    <!-- The Modals -->
    <form action="" method="post">
        <div id="add_skill" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Add Skill Details </h3>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    <label for="skill_name">Name:</label>
                    <input type="text" name="skill_name" class="span12" value="<?php echo $skill->get('skill_name'); ?>"/>
                </div>

                <div class="row-fluid">
                    <label for="status">Status:</label>
                    <select name="status" class="span12">
                        <option value="">--Choose Status--</option>
                        <option value="1"<?php if(isset($_POST['status']) && $_POST['status'] == 1) echo 'selected'; ?>>Active</option>
                        <option value="0"<?php if(isset($_POST['status']) && $_POST['status'] == 0) echo 'selected'; ?>>Inactive</option>
                    </select>
                </div>

            </div>
            <!-- the hidden fields -->
            <input type="hidden" name="action" value="add_skill"/>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                <button class="btn btn-primary" >Save</button>
            </div>
        </div>
    </form>

    <form action="" method="post">
        <div id="update_skill" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Update Skill Details </h3>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    <label for="skill_name">Name:</label>
                    <input type="text" name="skill_name" id="skill_name" class="span12" value="<?php echo $skill->get('skill_name'); ?>"/>
                </div>

                <div class="row-fluid">
                    <label for="status">Status:</label>
                    <select name="status" class="span12" id="status">
                        <option value="">--Choose Status--</option>
                        <option value="1"<?php if(isset($_POST['status']) && $_POST['status'] == 1) echo 'selected'; ?>>Active</option>
                        <option value="0"<?php if(isset($_POST['status']) && $_POST['status'] == 0) echo 'selected'; ?>>Inactive</option>
                    </select>
                </div>
            </div>
            <!-- the hidden fields -->
            <input type="hidden" name="action" value="edit_skill"/>
            <input type="hidden" name="edit_id" id="edit_id"/>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                <button class="btn btn-primary" >Save</button>
            </div>
        </div>
    </form>

    <form action="" method="post">
        <div id="del_skill" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel1">Delete Skill Details </h3>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the selected Skill?</p>
            </div>
            <!-- the hidden fields -->
            <input type="hidden" name="action" value="delete_skill"/>
            <input type="hidden" name="delete_id" id="delete_id"/>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">No</button>
                <button class="btn btn-primary" >Yes</button>
            </div>
        </div>
    </form>
    <?php set_js(array('src/js/skill.js')); } ?>
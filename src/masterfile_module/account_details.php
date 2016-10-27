<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <label for="bank_name" class="control-label">Bank</label>
            <div class="controls">
                <select name="bank_name" class="span12 live_search" id="bank_name">
                    <option value="">--Choose Bank--</option>
                    <?php
                    $banks = $acc->getAllBank();
                    $banks = $banks['all'];
                    if(count($banks)){
                        foreach ($banks as $bank){
                            ?>
                            <option value="<?php echo $bank['bank_id']; ?>" <?php echo ($mf->get('bank_name') == $bank['bank_id']) ? 'selected': ''; ?>><?php echo $bank['bank_name']; ?></option>
                        <?php }} ?>
                </select>
            </div>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <label for="branch_name" class="control-label">Branches</label>
            <div class="controls">
                <select name="branch_name" class="span12 live_search" id="branch_name">
                    <option value="">--Choose Branches--</option>
                </select>
            </div>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <label for="account_no" class="control-label">Account No</label>
            <div class="controls">
                <input type="text" name="account_no" class="span12" id="account_no" value="<?php echo $mf->get('account_no'); ?>" placeholder="Account No" />
            </div>
        </div>
    </div>
</div>
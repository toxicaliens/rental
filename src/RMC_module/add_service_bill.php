<form action="" id="add_sb" method="post" class="form-horizontal">
	                                          	
    <div class="row-fluid">
      <div class="span6">
          <div class="control-group">
              <label for="bill_name" class="control-label">Bill Name:</label>
              <div class="controls">
              	<input class="span12" type="text" name="bill_name"  required>
              </div>
          </div>
      </div>
      <div class="span6">
          <div class="control-group">
              <label for="bill_description" class="control-label">Bill Description:</label>
              <div class="controls">
                <input class="span12" type="text" name="bill_description"  required>
              </div>
          </div>
      </div>
  </div>

    <div class="row-fluid">
      <div class="span6">
          <div class="control-group">
              <label for="bill_category" class="control-label">Bill Category:</label>
              <div class="controls">
                <select class="span12" name="bill_category" id="bill_category" required>
                  <option value="">--Select Category--</option>
                  <option value="Applied">Applied Fee/Customized</option>
                  <option value="Penalty">Penalty Fee</option>
                  <option value="Processing">Processing Fee</option>
                </select>
              </div>
          </div>
      </div>
      <div class="span6">
          <div class="control-group">
              <label for="bill_code" class="control-label">Bill Code:</label>
              <div class="controls">
                <input class="span12" type="text" name="bill_code"  required>
              </div>
          </div>
      </div>
  </div>

    <div class="row-fluid">
        <div class="span6">
            <div class="control-group">
                <label for="bill_type" class="control-label">Bill Type:</label>
                <div class="controls">
                    <select class="span12" id="bill_type" name="bill_type" required>
                        <option value="">--Select Bill Type--</option>
                        <option value="Onceoff">One off</option>
                        <option value="Regular">Regular</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="span6">
            <div class="control-group">
                <label for="bill_interval" class="control-label">Interval:</label>
                <div class="controls">
                    <select class="span12" id="interval" name="bill_interval" disabled>
                        <option value="">--Select Interval--</option>
                        <option value="Daily">Daily</option>
                        <option value="Weekly">Weekly</option>
                        <option value="Monthly">Monthly</option>
                        <option value="Quarterly">Quarterly</option>
                        <option value="Semi-Annually">Semi-Annually</option>
                        <option value="Annually">Annually</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span6">
            <div class="control-group">
                <label for="amount_type" class="control-label">Amount Type:</label>
                <div class="controls">
                    <select class="span12" name="amount_type" id="amount_type" required>
                        <option value="">--Select Amount Type--</option>
                        <option value="Fixed">Fixed</option>
                        <option value="Custom">Custom</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="span6">
            <div class="control-group">
                <label for="bill_due_time" class="control-label">Bill Due Time:</label>
                <div class="controls">
                    <select class="span12" name="bill_due_time" required>
                        <option value="">--Select Bill Due Time--</option>
                        <option value="Asap">ASAP</option>
                        <option value="7days">7 DAYS</option>
                        <option value="14days">14 DAYS</option>
                        <option value="1month">1 MONTH</option>
                        <option value="3months">3 MONTHS</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span6">
            <div class="control-group">
                <label for="revenue_channel" class="control-label">Revenue Channel:</label>
                <div class="controls">
                    <select class="span12" name="revenue_channel_id" id="revenue_channel" >
                        <option value="">--Choose Revenue Channel--</option>
                        <?php
                            $query = "SELECT * FROM revenue_channel";
                            $result = run_query($query);
                            while($row = get_row_data($result)){
                            $rev_chan_id = $row['revenue_channel_id'];
                            $rev_chan_name = $row['revenue_channel_name'];

                            echo "<option value=\"$rev_chan_id\">$rev_chan_name</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>

      <div class="span6">
          <div class="control-group">
              <label for="service_option" class="control-label">Service Option:</label>
              <div class="controls">
                <select class="span12 live_search" name="service_option" id="service_option" disabled="disabled">
                  <option value="">--Attach a service option--</option>
                  <div id="options"></div>
                </select>
              </div>
          </div>
      </div>
    </div>

    <div class="row-fluid">
      <div class="span6">
          <div class="control-group">
              <label for="amount" class="control-label">Amount:</label>
              <div class="controls">
                <input class="span12" type="number" id="amount" name="amount" value="0"  required>
              </div>
          </div>
      </div>
  </div>


<input class="span12" type="hidden" name="action" id="action" value="addservicebill" class="packinput">
    <div class="form-actions">
       <!--  <?php //viewActions($_GET['num'], $_SESSION['role_id']); ?> -->
        <input type="submit" name="button" class="btn btn-primary"  id="button" value="Submit" />
        <input type="reset" name="button" id="button" value="Reset" />
    </div>
</form>         
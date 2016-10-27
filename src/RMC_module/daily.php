          <?php
              if(isset($_SESSION['RMC'])){
                  echo "<p style='color:#f00; font-size:16px;'>".$_SESSION['RMC']."</p>";
                  unset($_SESSION['RMC']);
              }
            ?>
             <div class="row-fluid">
                <div class="span12">
                   <!--BEGIN TABS-->
                   <div class="tabbable tabbable-custom">
                      <ul class="nav nav-tabs">
                        <?php
                          $tab1 = '';
                          $tab2 = '';
                          if(isset($_POST['tab1'])){
                            $tab1 = 'active';
                          }elseif(isset($_POST['tab2'])){
                            $tab2 = 'active';
                          }else{
                            $tab1 = 'active';
                          }
                        ?>
                         <li class="<?=$tab1; ?>"><a href="#tab_2_1_1" data-toggle="tab">By Region </a></li>
                         <li class="<?=$tab2; ?>"><a href="#tab_2_1_2" data-toggle="tab">By Sub-county</a></li>
                      </ul>
                      <div class="tab-content">
                         <div class="tab-pane <?=$tab1; ?>" id="tab_2_1_1">
                              <? include "forecasting_by_region.php"; ?>
                         </div>

                        <div class="tab-pane <?=$tab2; ?>" id="tab_2_1_2">
                             <? include "forecasting_by_subcounty.php"; ?>
                        </div>

                      </div>
                    </div>
                    <!-- END PAGE --> 
                  </div>
                </div>
 
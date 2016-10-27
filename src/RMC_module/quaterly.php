
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
                         <li class="<?=$tab1; ?>"><a href="#tab_2_3_1" data-toggle="tab">By Region </a></li>
                         <li class="<?=$tab2; ?>"><a href="#tab_2_3_2" data-toggle="tab">By Sub-county</a></li>
                      </ul>
                      <div class="tab-content">
                         <div class="tab-pane <?=$tab1; ?>" id="tab_2_3_1">
                              <? include "quaterly_forecast_by_reg.php"; ?>
                         </div>

                        <div class="tab-pane <?=$tab2; ?>" id="tab_2_3_2">
                             <? include "quaterly_forecast_by_sub.php"; ?>
                        </div>

                      </div>
                    </div>
                    <!-- END PAGE --> 
                  </div>
                </div>
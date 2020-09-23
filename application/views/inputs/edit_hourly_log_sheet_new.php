
                            <div class="card" >
                               <div class="card-header">
                                <h4>Edit Hourly Reading</h4>
                               </div>
                               <div class="card-body">
                                <!-- <h5 class="box-title mr-b-0">Horizontal Form</h5>
                                <p class="text-muted">All bootstrap element classies</p> -->
                                    <?php echo validation_errors('<div class="alert alert-danger mb-2">','</div>'); ?>
                                
                        
                        <fieldset id="form-section" class="scheduler-border" >
   <legend class="scheduler-border">Filter</legend>



                          <form  action="" method="POST">
                                                  <?php 
    if ($user->role_id==8) {
      # user is dso
      ?>
      <div class="row">
      <div class="col-md-4 iss_log_div" id="" style="">
<label>Injection Substation</label>
<select class="form-control" style="width: 100%" name="substation_id" id="iss_name">
    <option value="">Injection Substation</option>
    <option value="<?= $station->id ?>"><?= $station->iss_names ?></option>
   
</select>
</div>
<input type="hidden" name="asset_type" value="ISS">
<?php
    }elseif ($user->role_id==35) {
      # user is a transmission dso
      ?>
      <input type="hidden" name="asset_type" value="TS">
      <div class="row">
             <div class="col-md-4 ts_div_log" id="">

            <label> Transmission station</label>
                <select class="form-control" name="transmission_id" id="trans_st">
                 <option value=""> Transmission Station</option>
                 <option value="<?= $station->id ?>"><?= $station->tsname ?></option>
                 
                  </select>

                  </div>
                  <?php
                }else{
                  ?>
          <div class="d-flex justify-content-start">   
                                             
                   <div class="radiobox radio-info">
                <label class="custom-switch">
                    <input type="radio"  class="feeder_type_log custom-switch-input" name="asset_type" value="TS"> 
                    <span class="custom-switch-indicator"></span>
                    <span class="custom-switch-description"> 33KV FEEDER</span>
                </label>
                </div>
              
              
                  <div class="radiobox radio-info">
                <label class="custom-switch">
                    <input type="radio" class="feeder_type_log custom-switch-input" name="asset_type" value="ISS">
                    <span class="custom-switch-indicator"></span>
                     <span class="custom-switch-description"> 11KV FEEDER</span>
                </label>
                </div>
              </div>


               <div class="row">
             <div class="col-md-4 ts_div_log" id="">

            <label> Transmission Station</label>
                <select class="form-control" name="transmission_id" id="">
                 <option value=""> Transmission </option>
                   <?php
                        foreach ($transmision as $key => $value) {
                            ?>
                            <option 
                            value="<?= $value->id ?>"
                            
                                ><?= $value->tsname ?></option>
                            <?php
                        }
                    ?>
                  </select>
              </div>

              <div class="col-md-4 iss_log_div" id="" style="display: none">
<label>Injection Substation</label>
<select class="form-control" style="width: 100%" name="substation_id" id="iss_name">
    <option value="">Injection Substation</option>
    <?php
        foreach ($iss_data as $key => $value) {
            ?>
            <option 
            value="<?= $value->ISS_ID ?>"
            
                ><?= $value->ISS ?></option>
            <?php
        }
    ?>
</select>
</div>
<?php } ?>
  

                                        <!-- <div class="col-md-1"></div> -->
                       <div class="col-md-3">
                                             
                                            <label class=" col-form-label" for="year_input"> Choose Type</label>
                                        <div class="">
                                              
     <select class="form-control" name="log_type" id="type">
         <option value="">Choose type</option>
         
        <option value="current_reading">Current</option>
       <option value="pf">Power Factor</option>
       <option value="frequency">Frequency</option>
       <option value="voltage">Voltage</option>
       
      <!--  <option value="load_reading">Load(MW)</option>
        <option value="load_mvr">Load(KVAR)</option> -->
    </select>
                                                                                            
                                            </div>
                                       
                  </div>
               <div class="col-md-3">
               
              <label class="col-form-label" for="date_picker"> Choose Date</label>
              <div class="" style="position: relative !important;">
                  <input placeholder="Choose date" class="form-control" style="color: #333" type="text" name="captured_date"  autocomplete="off" id="captured_date" />
               
              
              </div>
            </div>
            <div class="col-md-2 my-2">
                                            
                <div class="form-group">
              <label>.</label>
              <div class=" ml-md-auto btn-list">
               <button  class="btn btn-primary form-control" id="show_report_click" type="submit">Show Log</button>
                                                        
              </div>
                                                
                </div>
                </div>
                                       
                </div>
                                   
                                  
                  </form>
                         

                    
            
                    </fieldset>
                            
                      <?php
                         if (isset($transformers)) { 
                         //var_dump($controller); 
                                            
                           // echo "<pre>";
                           // print_r($max);
                           // echo "</pre>";
                          //var_dump($summary);
                          
                          // var_dump($summary);
                          // if (count((array)$summary)<1) {
                          //     echo "<div class='alert alert-danger'>No record Yet</div>";
                          // }

                          ?>
                                    <div id="report-container" >
                                        <h6 style="font-weight: bold" id="summary_title"><?= $title ?></h6>
                                     
                                        <div  id="table-scroll" class="table-scroll">
                                        <table  class="table table-bordered table-striped table-responsive main-table" data-toggle="datatables" data-plugin-options='{"searching": true}'>
                                        <thead style="background-color:#278acd;">
                                        <tr>
                                            <th style="background-color:#278acd;color: #fff" class="fixed-side" scope="col" >FEEDER</th>
                                           <?php
                                            for ($hour=0; $hour <=23 ; $hour++) {
                                               ?>
                                               <th><?= $hour.'.00'; ?></th>
                                               <?php
                                            }
                                           ?> 
                                           <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                           
                                                        
                    <?php 
                    foreach ($transformers as $report) {
                       ?>
                       <tr>
                        <td class='fixed-side' style="white-space:nowrap; " >
                          <?php
                          
                            echo "<span class='font-weight-bold text-info'>". $report->names_trans."</span>";
                            ?>
                            <table style="border-color: #fff !important">
                            <?php
                          foreach ($controller->get_feeder_transformer($report->id) as $key => $feeder) {
                            echo "<tr/>";
                            ?>
                            <td class='fixed-side'>
                              <?= $feeder->feeder_name ?>
                            </td>
                            <?php
                            echo "<tr/>";
                          }
                          ?>
                        </table>
                        </td>
                    
                    <?php
                   for ($hour=0; $hour <=23 ; $hour++) {
                    ?>
                    <td>
                    <?php
                      
                     $reading_incommer= $controller->getReadingByFeeder(["captured_at"=>$captured_at,"isIncommer"=>1,"feeder_id"=>$report->id,"log_type"=>$log_type,"hour"=>$hour]);
                      if(isset($reading_incommer)){
                        ?>
                         <button data-toggle="modal" class="btn btn-sm btn-outline-default btn-td" data-target="#modal<?= $reading_incommer->id ?>"><strong class="text-info" id="data<?= $reading_incommer->id ?>">
                        
                        <?= ($reading_incommer->status=='on')?$reading_incommer->$log_type:'<span class="text-danger">'.$reading_incommer->status.'</span>'  ?>
                      </strong>
                    </button>
                       <!-- Edit incommer -->
                          <div class="modal fade" id="modal<?= $reading_incommer->id ?>" tabindex="-1" role="dialog" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);z-index: 1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form class="update-reading" id="<?= $reading_incommer->id ?>">
                 <input type="hidden" value="<?= $report->names_trans ?>" name="feeder_name">
                <input type="hidden" value="<?= $reading_incommer->id ?>" name="reading_id">
                <input type="hidden" value="<?= $log_type ?>" name="type">
                <input type="hidden" value="1" name="isIncommer">
                  
                  <div class="row">
                  <div class="col-md-12">
                      <label style="display: block;">Status</label>
                      <select class="form-control status_feeder" style="width: 100%;display: block;" name="status">
                        
                         <option <?= ($reading_incommer->status=="on")?" selected ":"" ?>  value="on">ON</option>

                        <?php
                        foreach ($status as $key => $feeder_status) {
                          ?>

                            <option value="<?= $feeder_status->abbr ?>" <?= ($reading_incommer->status==$feeder_status->abbr)?" selected ":"" ?> ><?= $feeder_status->abbr ?></option>
                          <?php
                        }
                      

                        ?>
                      </select>
                  </div>
                </div>
                
              <div class="row div_edit">
                    <div class="col-md-12">
                        
                        <label class="col-form-label" for="reading"> <?= strtoupper(str_replace('_', ' ', $log_type)) ?></label>
                        <?php 
                            // $log_type=strtolower($log_type);
                            // $type=$log_type=='load'?'reading':$log_type;
                            //echo $type;
                        ?>
                        <input required placeholder='0.00' class="reading_edit <?php echo ($log_type=='pf')?'pf_input':'reading_input' ?> form-control" name="reading" id="reading" value="<?= $reading_incommer->$log_type ?>">
                        
                    
                    </div>
                </div>
                
                    <br/>
                    <div class="row">
                      <div class="col-md-12">
                      <button id="btn<?= $reading_incommer->id ?>" class="btn btn-primary btn-rounded mr-5" type="submit">Edit</button>
                      <?php
                      if ($user->role_id==1 ||$user->role_id==22 || $user->role_id==17) {
                        # user is admin or coordinator dispatch
                      ?>
                      <button type="button" id="btnn<?= $reading_incommer->id ?>" data-type="<?= $log_type ?>" data-id="<?= $reading_incommer->id ?>" class="btn btn-warning btn-rounded delete_reading" type="submit">Delete</button>
                    <?php } ?>
                    </div>
                    </div>
                        
                    
          
        </form>
          </div>
          <div class="modal-footer">
            <button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>
           
          </div>
        </div>
      </div>
    </div>
                        <?php
                      }else{
                        //add new record for incomer
                        ?>
                      -
    <!-- end of new icommer add-->
                        <?php
                      }
                      ?>
                      <table>
                        <?php
                      foreach ($controller->get_feeder_transformer($report->id) as $key => $feeder) {
                            echo "<tr/>";
                            $reading_feeder= $controller->getReadingByFeeder(["hour"=>$hour,"isIncommer"=>0,"captured_at"=>$captured_at,"feeder_id"=>$feeder->id,"log_type"=>$log_type]);
                            echo "<td>";
                      if(isset($reading_feeder)){
                        ?>
                         <button data-toggle="modal" class="btn btn-sm btn-outline-default btn-td" data-target="#modal<?= $reading_feeder->id ?>"><strong class="" id="data<?= $reading_feeder->id ?>">
                        
                         <?= ($reading_feeder->status=='on')?$reading_feeder->$log_type:'<span class="text-danger">'.$reading_feeder->status.'</span>'  ?>
                      </strong>
                    </button>


                    <!-- Edit feeder -->
                          <div class="modal fade" id="modal<?= $reading_feeder->id ?>" tabindex="-1" role="dialog" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);z-index: 1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form class="update-reading" id="<?= $reading_feeder->id ?>">
                 <input type="hidden" value="<?= $feeder->feeder_name ?>" name="feeder_name">
                <input type="hidden" value="<?= $reading_feeder->id ?>" name="reading_id">
                <input type="hidden" value="<?= $log_type ?>" name="type">
                <input type="hidden" value="0" name="isIncommer">
                
                
                  <div class="row">
                  <div class="col-md-12">
                      <label style="display: block;">Status</label>
                      <select class="form-control status_feeder" style="width: 100%;display: block;" name="status">
                        
                         <option <?= ($reading_feeder->status=="on")?" selected ":"" ?>  value="on">ON</option>

                        <?php
                        foreach ($status as $key => $feeder_status) {
                          ?>

                            <option value="<?= $feeder_status->abbr ?>" <?= ($reading_feeder->status==$feeder_status->abbr)?" selected ":"" ?> ><?= $feeder_status->abbr ?></option>
                          <?php
                        }
                      
                        ?>
                      </select>
                  </div>
                </div>
              <div class="row div_edit">
                    <div class="col-md-12">
                        
                        <label class="col-form-label" for="reading"> <?= strtoupper(str_replace('_', ' ', $log_type)) ?></label>
                        <?php 
                            // $log_type=strtolower($log_type);
                            // $type=$log_type=='load'?'reading':$log_type;
                            //echo $type;
                        ?>
                        <input required placeholder='0.00' class="reading_edit <?php echo ($log_type=='pf')?'pf_input':'reading_input' ?> form-control" name="reading" id="reading" value="<?= $reading_feeder->$log_type ?>">
                        
                    
                    </div>
                </div>
                
                    <br/>
                    <div class="row">
                      <div class="col-md-12">
                      <button id="btn<?= $reading_feeder->id ?>" class="btn btn-primary btn-rounded mr-5" type="submit">Edit</button>

                      <?php
                      if ($user->role_id==1 ||$user->role_id==22 || $user->role_id==17) {
                        # user is admin or coordinator dispatch
                      ?>
                      <button type="button" id="btnn<?= $reading_feeder->id ?>" data-type="<?= $log_type ?>" data-id="<?= $reading_feeder->id ?>" class="btn btn-warning btn-rounded delete_reading" type="submit">Delete</button>

                    <?php } ?>
                    </div>
                    </div>
                        
                    
          
        </form>
          </div>
          <div class="modal-footer">
            <button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>
           
          </div>
        </div>
      </div>
    </div>

                        <?php
                      }
                            ?>
                          </td>
                            <?php
                            echo "<tr/>";
                          }
                    ?>
                  </table>
                    </td>
                      <?php
                          }
                      ?>
                      
                  </tr>
                  <?php } ?>
                                        </tbody>
                                      
                                    </table>
                                    </div>
                                    </div>
                                <?php } ?>
                            <!-- this is section for summary -->
                            </div>
                            <!-- /.widget-body -->
                        </div>
                      
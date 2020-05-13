
                            <div class="card" >
                               <div class="card-header">
                                <h4>Edit Log Sheet</h4>
                               </div>
                               <div class="card-body">
                                <!-- <h5 class="box-title mr-b-0">Horizontal Form</h5>
                                <p class="text-muted">All bootstrap element classies</p> -->
                                    <?php echo validation_errors('<div class="alert alert-danger mb-2">','</div>'); ?>
                                
                                        <?php 
                        if (isset($summary)) {
                          ?>
                          <button class="btn btn-sm btn-outline-primary" id="btn-show-section">Show Search Section</button>
                          <br/>
                          <br/>
                        <?php } ?>
                        <fieldset id="form-section" class="scheduler-border" style="<?= isset($search_params)?'display: none;':''; ?>">
   <legend class="scheduler-border">Filter</legend>

                          <form  action="" method="POST">

                            <?php 
    if ($user->role_id==8) {
      # user is dso
      ?>
      <div class="row">
            
      <div class="col-md-4 iss_log_div" id="" style="">
<label>Injection Substation</label>
<select class="form-control" name="iss_name" id="iss_name">
    <option value="">Injection Substation</option>
    <option value="<?= $station->id ?>"><?= $station->iss_names ?></option>
   
</select>
</div>
<div class="col-md-4 iss_log_div" id="" style="">

    <label>Power Transformer</label>
    <select class="form-control" name="transformer_iss" id="transformer_iss">
    <option value="">No Transformer data</option>
                
    </select>

                                                
</div>

      <?php
    } else {
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
                <br/>
               <div class="row">
             <div class="col-md-4 ts_div_log" id="">

            <label> Transmission station</label>
                <select class="form-control" name="trans_st" id="trans_st">
                 <option value=""> Transmission Station</option>
                    <?php
                        foreach ($ts_data as $key => $value) {
                            ?>
                            <option 
                            value="<?= $value->tsid ?>"
                            
                                ><?= $value->tsname ?></option>
                            <?php
                        }
                    ?>
                        </select>

                     


                                            </div>
                        <div class="col-md-4 ts_div_log" id="">

                <label>Power Transformer</label>
                <select class="form-control" name="transformer" id="transformer_33">
                <option value="">No Transformer data</option>
                
                 </select>

                                                
                </div>
            
    <div class="col-md-4 iss_log_div" id="" style="display: none">
<label>Injection Substation</label>
<select class="form-control" name="iss_name" id="iss_name">
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
<div class="col-md-4 iss_log_div" id="" style="display: none">

    <label>Power Transformer</label>
    <select class="form-control" name="transformer_iss" id="transformer_iss">
    <option value="">No Transformer data</option>
                
    </select>

                                                
</div>
<?php } ?>
<div class="col-md-4">
              
              <label class="col-form-label" for="year_input"> Choose Feeder</label>
              <select class="form-control" name="feeders" id="feeder_name">
                                                    
             <option value="">Choose feeder</option>
              </select>
                                        </div>
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
       <option value="energy">Energy</option>
       <option value="load_reading">Load(MW)</option>
        <option value="load_mvr">Load(KVAR)</option>
    </select>
                                                                                            
                                            </div>
                                       
                                    </div>
               <div class="col-md-4">
               
              <label class="col-form-label" for="date_picker"> Choose Date</label>
              <div class="" style="position: relative !important;">
                  <input placeholder="Choose date" class="form-control date_picker" style="color: #333" type="text" name="captured_date"  autocomplete="off" id="date_picker" />
               
              
              </div>
            </div>
            <div class="col-md-4 my-2">
                                            
                <div class="form-group">
              <label>.</label>
              <div class=" ml-md-auto btn-list">
               <button  class="btn btn-primary form-control" type="submit">Show Log</button>
                                                        
              </div>
                                                
                </div>
                </div>
                                       
                </div>
                                   
                                  
                  </form>
                         

                    
            
                    </fieldset>
                            
                      <?php
                         if (isset($summary)) {  
                                            
                           // echo "<pre>";
                           // print_r($max);
                           // echo "</pre>";
                          //var_dump($summary);
                          $date=day_date($dt,$month,$year);
                          // var_dump($summary);
                          // if (count((array)$summary)<1) {
                          //     echo "<div class='alert alert-danger'>No record Yet</div>";
                          // }

                          ?>
                                    <div id="report-container" >
                                        <h6 style="font-weight: bold" id="summary_title"><?= $title ?></h6>
                                     
                                        <div style="overflow-x: auto;" id="doublescroll">
                                        <table class="table table-bordered table-striped table-responsive" data-toggle="datatables" data-plugin-options='{"searching": true}'>
                                        <thead>
                                        <tr>
                                            <th>Hour</th>
                                           <?php
                                            foreach ($date as $key => $day) {
                                               ?>
                                               <th><?= $day; ?></th>
                                               <?php
                                            }
                                           ?> 
                                           <th>Hour</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                for ($hour=0; $hour <=23 ; $hour++) { 
                                                    ?>
                                                    <tr>
                                                        <td style="background: #556080;color: #ffffff">
                                                            <strong>
                                                                <?=  $hour==0?'00':$hour; ?>      
                                                            </strong>
                                                        </td>
                    <?php
                    foreach ($date as $key =>  $day) {
                       $day_key=($key<9)?'0'.($key+1):$key+1;
                       ?>
                    <td>
                    <?php
                   foreach ($summary as $report) {
                    
                    if ($report->hour==$hour && date("j",strtotime($report->captured_at))==(int)$key+1) {
                       //echo  $report->hour.' '.date("j",strtotime($report->captured_at)).' '.$hour.' d '.((int)$key+1);
                        if($log_type=='load_reading' && !empty($report->load_reading)){

                            ?>

                            <button  class="btn btn-sm btn-outline-default btn-td" ><strong id="data<?= $report->id ?>">
                                <?= ($report->status=='on')?$report->load_reading:'<span class="text-danger">'.$report->status.'</span>'  ?>
                            </strong>
                            </button>
                            <?php
                        }elseif ($log_type=='current_reading' && !empty($report->current_reading)) {
                         
                            ?>
                             <button data-toggle="modal" class="btn btn-sm btn-outline-default btn-td" data-target="#modal<?= $report->id ?>"><strong id="data<?= $report->id ?>">
                                <?= ($report->status=='on')?$report->current_reading:'<span class="text-danger">'.$report->status.'</span>'  ?>
                            </strong>
                            </button>
                            <?php

                        }elseif ($log_type=='pf' && !empty($report->pf)) {
                            ?>
                             <button data-toggle="modal" class="btn btn-sm btn-outline-default btn-td" data-target="#modal<?= $report->id ?>"><strong id="data<?= $report->id ?>">
                                <?= ($report->status=='on')?$report->pf:'<span class="text-danger">'.$report->status.'</span>'  ?>
                            </strong>
                            </button>
                            <?php
                        }elseif ($log_type=='frequency' && !empty($report->frequency)) {
                            ?>
                             <button data-toggle="modal" class="btn btn-sm btn-outline-default btn-td" data-target="#modal<?= $report->id ?>"><strong id="data<?= $report->id ?>">
                                <?= ($report->status=='on')?$report->frequency:'<span class="text-danger">'.$report->status.'</span>'  ?>
                            </strong>
                            </button>
                            <?php
                        }elseif ($log_type=='energy' && !empty($report->energy)) {
                            ?>
                             <button data-toggle="modal" class="btn btn-sm btn-outline-default btn-td" data-target="#modal<?= $report->id ?>"><strong id="data<?= $report->id ?>">
                                <?= $report->energy  ?>
                            </strong>
                            </button>
                            <?php
                        }elseif ($log_type=='voltage' && !empty($report->voltage)) {
                            ?>
                             <button data-toggle="modal" class="btn btn-sm btn-outline-default btn-td" data-target="#modal<?= $report->id ?>"><strong id="data<?= $report->id ?>">
                                <?= ($report->status=='on')?$report->voltage:'<span class="text-danger">'.$report->status.'</span>'  ?>
                            </strong>
                            </button>
                            <?php
                        }
                        elseif ($log_type=='load_mvr' && !empty($report->load_mvr)) {
                            ?>
                             <button  class="btn btn-sm btn-outline-default btn-td" ><strong id="data<?= $report->id ?>">
                                <?= ($report->status=='on')?$report->load_mvr:'<span class="text-danger">'.$report->status.'</span>'  ?>
                            </strong>
                            </button>
                            <?php
                        }

                        ?>

                        
                        <!-- Edit modal -->
                          <div class="modal fade" id="modal<?= $report->id ?>" tabindex="-1" role="dialog" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);z-index: 1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form class="update-reading" id="<?= $report->id ?>">
                 <input type="hidden" value="<?= $feeder_name ?>" name="feeder_name">
                <input type="hidden" value="<?= $report->id ?>" name="reading_id">
                <input type="hidden" value="<?= $log_type ?>" name="type">
                 <input type="hidden" value="0" name="isIncommer">
                <input type="hidden" value="<?= $day_key ?>" name="day">
                <div class="row">
                  <div class="col-md-12">
                      <label>Status</label>
                      <select class="form-control status_feeder" name="status">
                        <?php
                        if ($report->status=="on") {
                          ?>
                         <option  value="on">ON</option>

                        <?php
                      }
                        foreach ($status as $key => $feeder_status) {
                          ?>

                            <option value="<?= $feeder_status->abbr ?>" <?= ($report->status==$feeder_status->abbr)?" selected ":"" ?> ><?= $feeder_status->abbr ?></option>
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
                        <input required placeholder='0.00' class="reading_edit <?php echo ($log_type=='pf')?'pf_input':'reading_input' ?> form-control" name="reading" id="reading" value="<?= $report->$log_type ?>">
                        
                    
                    </div>
                </div>
                
                    <br/>
                    <div class="row">
                      <div class="col-md-12">
                      <button id="btn<?= $report->id ?>" class="btn btn-primary btn-rounded" type="submit">Edit</button>
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
                        break;
                    }  
                   }
                    
                   ?>
                 
                                                               </td>
                                                        <?php
                                                            }
                                                        ?>
                                                        <td style="background: #556080;color: #ffffff">
                                                            <strong>
                                                                <?=  $hour==0?'00':$hour; ?>      
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            ?>
                                        </tbody>
                                       <tfoot>
                                        <tr>
                                            <th>Hour</th>
                                           <?php
                                            foreach ($date as $key => $day) {
                                               ?>
                                               <th><?= $day; ?></th>
                                               <?php
                                            }
                                           ?> 
                                        </tr>
                                        </tfoot>
                                    </table>
                                    </div>
                                    </div>
                                <?php } ?>
                            <!-- this is section for summary -->
                            </div>
                            <!-- /.widget-body -->
                        </div>
                      
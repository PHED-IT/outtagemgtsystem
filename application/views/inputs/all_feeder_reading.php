
                            <div class="card" >
                               <div class="card-header">
                                <h4>Show Reading for all feeders</h4>
                               </div>
                               <div class="card-body">
                                <!-- <h5 class="box-title mr-b-0">Horizontal Form</h5>
                                <p class="text-muted">All bootstrap element classies</p> -->
                                    <?php echo validation_errors('<div class="alert alert-danger mb-2">','</div>'); ?>
                                
                        
                        <fieldset id="form-section" class="scheduler-border" >
   <legend class="scheduler-border">Filter</legend>

                          <form  action="" method="POST">

        
               <div class="row">
             <div class="col-md-4" id="">

            <label> Voltage Level</label>
                <select class="form-control" name="voltage_level">
                 <option> 33kv </option>
                 <option > 11kv </option>
                  
                  </select>
              </div>
              <div class="col-md-4" id="">

            <label> Report type</label>
                <select class="form-control" name="report_type">
                 <option value="current_reading"> Current(Amp) </option>
                 <option value="load_reading"> Load(MVR) </option>
                 <option value="energy"> Energy </option>
                  
                  </select>
              </div>
  
               <div class="col-md-3">
               
              <label class="col-form-label" for="date_picker"> Choose Date</label>
              <div class="" style="position: relative !important;">
                  <input placeholder="Choose date" class="form-control " style="color: #333" type="text" name="date"  autocomplete="off" id="captured_date" />
               
              
              </div>
            </div>
            <div class="col-md-2 my-2">
                                            
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
           // var_dump($station_id);
              if (isset($feeders) ) {
                ?>
                <center><h6 style="font-weight: bold;text-decoration: underline;color:#000" id="summary_title"><?= $title ?></h6></center>
                <div style="overflow:auto;padding: 7px">
                <table id="activity_table" class=" table-bordered table-striped">
                  <thead>
                    <th style="background: #556080;color: #ffffff">Hour/Feeder</th>
                    <?php
                      foreach ($feeders as $key => $feeder) {
                        ?>
                        <th><?= $feeder->feeder_name ?></th>
                        <?php
                      }
                    ?>
                    <th>Total</th>
                  </thead>
                  <tbody>
                    <?php
                       for ($hour=0; $hour <=24 ; $hour++) { 
                        ?>
                        <tr>
                          <td style="background: #556080;color: #ffffff">
                            <?php
                              if ($hour==24) {
                                # code...
                              }else{
                                echo $hour==0?'00':$hour;
                              }
                            ?>
                            </td>
                          <?php
                            foreach ($feeders as $key => $feeder) {
                              ?>
                              <td>
                                <?php
                              $reading= $controller->getReadingByFeeder(["captured_at"=>$date,"feeder_id"=>$feeder->id,"log_type"=>$report_type,"hour"=>$hour,"date_type"=>"day","isIncommer"=>0]);
                                if (isset($reading) ) {
                                  if ($report_type=="energy") {
                                    echo $reading->$report_type;
                                  } else {
                                    echo ($reading->status=="on")?$reading->$report_type:$reading->status;
                                  }
                                  
                                  
                                  ?>
                                  <input type="hidden" value="<?= $reading->$report_type ?>">
                                  <?php
                                }else{
                                  ?>
                                  <input type="" style="border: none;background-color: transparent;color: blue;font-weight: bold;" name="">
                                  <?php
                                }
                                ?></td>
                              <?php
                            }
                          ?>
                          <td><input type="" style="border: none;background-color: transparent;color: blue;font-weight: bold;" name=""></td>
                        </tr>
                        <?php
                       }
                    ?>
                  </tbody>
                </table>
              </div>
                <?php
              }
            ?>
                     
                            <!-- this is section for summary -->
                            </div>
                            <!-- /.widget-body -->
                        </div>
                      
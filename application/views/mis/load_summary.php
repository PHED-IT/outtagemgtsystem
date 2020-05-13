
                            <div class="card">
                               <div class="card-header"><h4>LOAD(M/W) SUMMARY REPORT</h4></div>
                               <div class="card-body">

                                <form  action="" method="POST">

        
               <div class="row">
             <div class="col-md-4 ts_div_log" id="">

            <label> Transmission Station</label>
                <select class="form-control" name="station_id" id="">
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
  

                                        <!-- <div class="col-md-1"></div> -->
                       <div class="col-md-3">
                                             
                    <label class=" col-form-label" for="type"> Choose Report Type</label>
                                        
                                              
     <select class="form-control" name="report_type" id="type">
        <option value="load_maximum">Load maximum</option>
        <option value="coincidental">Load Coincindental</option>
        <option value="summary">Coincidental Peak Load Summary</option>
    </select>
                                        
    </div>
               <div class="col-md-3">
               
              <label class="col-form-label" for="date_picker"> Choose Date</label>
              <div class="" style="position: relative !important;">
                  <input placeholder="Choose date" class="form-control date_picker" style="color: #333" type="text" name="date"  autocomplete="off" id="date_picker" />
               
              
              </div>
            </div>
            <div class="col-md-2 my-2">
                                            
                <div class="form-group">
              <label>.</label>
              <div class=" ml-md-auto btn-list">
               <button  class="btn btn-primary form-control" type="submit">Show Report</button>
                                                        
              </div>
                                                
                </div>
                </div>
                                       
                </div>
                                   
                <?php 
                 if (isset($summary) && isset($report_type)) {
                  ?>
                <!-- if report is coincendetal summary -->
                <input type="hidden" id="date" value="<?= $date ?>">
                <input type="hidden" id="dt" value="<?= $dt ?>">
                <input type="hidden" id="month" value="<?= $month ?>">
                <input type="hidden" id="year" value="<?= $year ?>">
                <input type="hidden" id="page" value="chart_coinc">

                <!--end -->
              <?php } ?>
                  </form>
                         
                  </div>
                    <div id="content-section" style="overflow: auto;padding: 7px">
            <?php 
            
            if (isset($summary)) {


                                      //var_dump(sizeof((array)$summary));
           if (sizeof((array)$summary)<1) {
            echo "<div class='alert alert-danger'>No record Yet</div>";
              }
             ?>
            <center><h6 style="font-weight: bold;text-decoration: underline;color:#000" id="summary_title"><?= $title ?></h6></center>
                     
           <?php
              }
            ?>
            <div id="coincendetal_peak_chart" ></div>
            <hr>

            <center>
             <table  class=" table-bordered table-striped " data-toggle="datatables" data-plugin-options='{"searching": true}'>
                  <?php  echo isset($summary)?$summary:""; ?>
                        </table>   
                        </center> 
                </div>
              </div>
                            <!-- /.widget-body -->
                       
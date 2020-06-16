
                            <div class="card">
                               <div class="card-header"><h4>LOAD(M/W) REPORT</h4></div>
                               <div class="card-body">
                                  <?php 
                        if (isset($summary)) {
                          ?>
                          <button class="btn btn-outline-primary btn-sm" id="btn-show-section">Show Search Section</button>
                          <br/><br/>
                          <?php
                        }
                          ?>
                          <fieldset id="form-section" class="scheduler-border" style="<?= isset($summary)?'display: none;':''; ?>">
   <legend class="scheduler-border">Filter</legend>
                          <form id="showLoadReportForm"  action="" method="POST">
                             <input type="hidden" value="load_reading" id="type">
                             <?php
                             if (isset($feeder_wise) && $feeder_wise) {
                              ?>
              <input type="hidden" value="mis" id="page"> 
            <?php } ?>

                                    <?php echo validation_errors('<div class="alert alert-danger mb-2">','</div>'); ?>
                      <?php $this->load->view('partials/mis_feeder_search'); ?>
                    </form>
                  </fieldset>
                  </div>
                    <div id="content-section">
            <?php 
            
            if (isset($summary)) {
                                      //var_dump(sizeof((array)$summary));
           if (sizeof((array)$summary)<1) {
            echo "<div class='alert alert-danger'>No record Yet</div>";
              }
             ?>
            <center><h6 style="font-weight: bold;text-decoration: underline;color:#000" id="summary_title"><?= $title ?></h6></center>
             <?php
             //var_dump($asset_type);
             // if ($dt=="month" && $asset_type=="TS") {
                ?>   
           
        <?php //} ?>
            <br/><br/><br/>
            <?php
              }
            ?>
            <div id="lineCharts" ></div>
            <div id="month_hourly" ></div><br/>
            <!-- <div id="sumChart"></div>
            <br/> -->
            <div id="peakChart"></div>
            <br/>
            <div id="minChart"></div>
            <br/>
            <div id="avgChart"></div>
            
            <div id="report-container" >
             <?php
             if (isset($max->load_reading) && $feeder_wise) {
             ?>
             
            <h6 style="padding: 5px">
            <strong>
           <span class="mr-2 "> <span class="text-info">Avg:</span><?= (isset($average))?round($average->load_reading,2):"0" ?>MW</span> 
           <span class="mr-2"> <span class="text-success">Min. Load: </span><?= $min->load_reading;?>MW <?= ($dt=="month")? (" <span class='text-info'> Day: </span> ".date("d/m/Y",strtotime($min->captured_at)).' Hour: '.$min->hour.':00'):" <span class='text-info'>Hour:</span> ".$min->hour.'.00' ?> </span> 
              <span class="mr-2"><span class="text-danger">Max. Load: </span><?= $max->load_reading;?>MW <?= ($dt=="month")? (" <span class='text-info'> Day: </span> ".date("d/m/Y",strtotime($max->captured_at)).' Hour: '.$max->hour.':00'):" <span class='text-info'>Hour:</span> ".$max->hour.':00' ?> </span><br/>
              <?php
              if ($dt=="month") {
                   
              if (isset($dayPeak->load_reading)) {
              
                ?>       
                <br/>
              <span class="text-success">Day Peak 0:00-17:00: </span><?= $dayPeak->load_reading; ?>MW <span class='text-info'> Day:</span> <?= date("d/m/Y",strtotime($dayPeak->captured_at)) ?> <span class='text-info'>Hour:</span> <?= $dayPeak->hour.':00'; ?>  | 
              <?php 
            }
              if (isset($nightPeak->load_reading)) {
                ?>              
              <span class="text-danger">Night Peak 18:00-23:00: </span><?= $nightPeak->load_reading; ?>MW <span class='text-info'> Day:</span> <?= date("d/m/Y",strtotime($nightPeak->captured_at)) ?> <span class='text-info'>Hour:</span> <?= $nightPeak->hour.':00'; ?>  |
              <span class="text-success">Day Average 0:00-17:00: </span><?= round($dayAverage['avg'],2); ?>MW | 
              <span class="text-danger">Night Average 18:00-23:00: </span><?= round($nightAverage['avg'],2); ?>MW 
              <?php }  } ?> 
              </strong>
              </h6>
             <?php } ?>
             <div style="" id="">
      
            <?php
           // var_dump($station_id);
              if (isset($summary) && !$feeder_wise) {
                ?>
                <div style="overflow:auto;padding: 7px">
                <table id="activity_table" class="table table-bordered table-striped">
                  <thead>
                    <th style="background: #556080;color: #ffffff">Hour/Feeder</th>
                    <?php
                      foreach ($summary as $key => $feeder) {
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
                            foreach ($summary as $key => $feeder) {
                              ?>
                              <td>
                                <?php
                              $reading= $controller->getReadingByFeeder(["captured_at"=>$date,"feeder_id"=>$feeder->id,"log_type"=>"load_reading","hour"=>$hour]);
                                if (isset($reading) ) {

                                  echo ($reading->status=="on")?$reading->load_reading:$reading->status;
                                  ?>
                                  <input type="hidden" value="<?= $reading->load_reading ?>">
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
              }else{
                echo isset($summary)?$summary:"";
              }
            ?>
              
                                  
             </div>
             </div>
                                
              <!-- this is section for summary -->
              <?php
                if (isset($summary) && $feeder_wise) {
                  //count($summary->status);
                 echo $feeder_status;
                }
              ?>
                            
                            
                </div>
              </div>
                            <!-- /.widget-body -->
                       
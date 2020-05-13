
                            <div class="card">
                               <div class="card-header"><h4>CURRENT(AMP) REPORT</h4></div>
                               <div class="card-body">
                                <?php 
                        if (isset($search_params)) {
                          ?>
                          <button class="btn btn-outline-primary btn-sm" id="btn-show-section">Show Search Section</button>
                          <br/><br/>
                          <?php
                        }
                          ?>
<fieldset id="form-section" class="scheduler-border" style="<?= isset($search_params)?'display: none;':''; ?>">
   <legend class="scheduler-border">Filter</legend>

                          <form   action="" method="POST">
                             <input type="hidden" value="current_reading" id="type">
              <input type="hidden" value="mis" id="page">
                                    <?php echo validation_errors('<div class="alert alert-danger mb-2">','</div>'); ?>
                      <?php $this->load->view('partials/mis_feeder_search'); ?>
                    </form>
                  </fieldset>
                    <div id="content-section">
            <?php 
            
            if (isset($summary)) {
                                      //var_dump(sizeof((array)$summary));
           if (sizeof((array)$summary)<1) {
            echo "<div class='alert alert-danger'>No record Yet</div>";
              }
             ?>
            <center><h6 style="font-weight: bold;text-decoration: underline;color:#000" id="summary_title"><?= $title ?></h6></center>
             
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
             if (isset($max->current_reading)) {
             ?>
            <h6>
            <strong>
            <span class="text-info">Avg:</span><?= (isset($average))?round($average->current_reading,2):"0" ?> | 
            <span class="text-info">Min. Current(AMP): </span><?= $min->current_reading;?><?= ($dt=="month")? (" <span class='text-info'> Day: </span> ".date("d/m/Y",strtotime($min->captured_at)).' Hour: '.$min->hour.':00'):" <span class='text-info'>Hour:</span> ".$min->hour.'.00' ?>  |
              <span class="text-info">Max. Current(AMP): </span><?= $max->current_reading;?><?= ($dt=="month")? (" <span class='text-info'> Day: </span> ".date("d/m/Y",strtotime($max->captured_at)).' Hour: '.$max->hour.':00'):" <span class='text-info'>Hour:</span> ".$max->hour.':00' ?> <br/>
              <?php
              if ($dt=="month") {
                   
              if (isset($nightPeak->current_reading)) {
              
                ?>       
              <span class="text-success">Day Peak 0:00-17:00: </span><?= $dayPeak->current_reading; ?> <span class='text-info'> Day:</span> <?= date("d/m/Y",strtotime($dayPeak->captured_at)) ?> <span class='text-info'>Hour:</span> <?= $dayPeak->hour.':00'; ?>  | 
              <?php 
            }
              if (isset($nightPeak->current_reading)) {
                ?>              
              <span class="text-danger">Night Peak 18:00-23:00: </span><?= $nightPeak->current_reading; ?> <span class='text-info'> Day:</span> <?= date("d/m/Y",strtotime($nightPeak->captured_at)) ?> <span class='text-info'>Hour:</span> <?= $nightPeak->hour.':00'; ?>  |
              <span class="text-success">Day Average 0:00-17:00: </span><?= round($dayAverage['avg'],2); ?> | 
              <span class="text-danger">Night Average 18:00-23:00: </span><?= round($nightAverage['avg'],2); ?> 
              <?php }  } ?> 
              </strong>
              </h6>
             <?php } ?>
             <div style="" id="">
      
           <?php  echo isset($summary)?$summary:""; ?>
              
                                  
             </div>
             </div>
                                
              <!-- this is section for summary -->
              <?php
                if (isset($summary)) {
                  //count($summary->status);
                  echo $feeder_status;
                }
              ?>
                            
                            
                </div>
              </div>
                            <!-- /.widget-body -->
                       
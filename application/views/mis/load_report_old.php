
                            <div class="card">
                               <div class="card-header"><h4>LOAD(M/W) REPORT</h4></div>
                               <div class="card-body">
                                    <?php echo validation_errors('<div class="alert alert-danger mb-2">','</div>'); ?>
                      <?php $this->load->view('partials/mis_feeder_search'); ?>
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
            <?php
            if (isset($summary)) {  
                                             // echo "<pre>";
                                             // print_r($search_params);
                                             // echo "</pre>";

             //$date=day_date($dt,$month,$year);

              ?>
            <div id="report-container" >
             <?php
             if (isset($max->load_reading)) {
             ?>
            <h6>
            <strong>
            <span class="text-info">Avg:</span><?= (isset($average))?$average->load_reading:"0" ?> | 
            <span class="text-info">Min. Load(MW): </span><?= $min->load_reading;?><?= ($dt=="month")? " <span class='text-info'> Day: </span> ".date("d/m/Y",strtotime($min->captured_at)):" <span class='text-info'>Hour:</span> ".$min->hour ?>  |
              <span class="text-info">Max. Load(MW): </span><?= $max->load_reading;?><?= ($dt=="month")? " <span class='text-info'> Day: </span> ".date("d/m/Y",strtotime($max->captured_at)):" <span class='text-info'>Hour:</span> ".$max->hour ?>   
              </strong>
              </h6>
             <?php } ?>
             <div style="" id="">
            <table id="myTable" class="table table-bordered table-striped table-responsive" data-toggle="datatables" data-plugin-options='{"searching": true}'>
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
            <th>Hourly Peak</th>
            <th>Hourly Average</th>
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
            ?>
             <td>
            <?php
              foreach ($summary as $report) {
                   
              if ($dt=="month") {
                        //if is monthly
               if ($report->hour==$hour && date("d",strtotime($report->captured_at))==$key+1) {
                        ?>
                        <?= ($report->status=="on")?$report->load_reading:"<span class='text-info'>".$report->status."</span>" ?></strong> 
                      
                       <?php 
                    } 
                    } else {
                        //is a day
                       if ($report->hour==$hour && date("d",strtotime($report->captured_at))==substr($day, 4)) {
                        ?>
                        <?= ($report->status=="on")?$report->load_reading:"<span class='text-info font-weight-bold'>".$report->status."</span>" ?></strong> 
                      
                       <?php 
                    } 
                    }  
                     
                   }
                    
                   ?>
                 
                </td>
                <?php
                } 
                ?>
                 <td style="background: #556080;color: #ffffff">
              
                <?php
              foreach ($summary as $report) {
                   
              if ($dt=="month") {
                        //if is monthly
               if ($report->hour==$hour && date("d",strtotime($report->captured_at))==$key+1) {
                        ?>
                        <?= "<span class='text-success'>".$report->peak."</span>" ?>
                      
                       <?php 
                    } 
                    } else {
                        //is a day
                      echo "-";         
                    } 
                    }  
                   ?>
                 
                </td>
                <td style="background: #556080;color: #ffffff">
              
                <?php
              foreach ($summary as $report) {
                   
              if ($dt=="month") {
                        //if is monthly
               if ($report->hour==$hour && date("d",strtotime($report->captured_at))==$key+1) {
                        ?>
                        <?= "<span class='text-primary'>".$report->average."</span>" ?>
                      
                       <?php 
                    } 
                    } else {
                        //is a day
                      echo "-";         
                    } 
                    }  
                   ?>
                 
                </td>
                   </tr>
                <?php
                  }
                 ?>
                </tbody>
              
                                    </table>
                                    </div>
                                    </div>
                                <?php } ?>
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
                       
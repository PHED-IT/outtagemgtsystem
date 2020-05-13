

            <div class="card">
                               <div class="card-header"><h4>FREQUENCY REPORT</h4></div>
                               <div class="card-body">
                                    <?php echo validation_errors('<div class="alert alert-danger mb-2">','</div>'); ?>
                      <?php $this->load->view('partials/mis_feeder_search'); ?>
                                     <?php 
                                    if (isset($summary)) {
                                      if (sizeof((array)$summary)<1) {
                                                echo "<div class='alert alert-danger'>No record Yet</div>";
                                            }
                                      ?>
                                      <center><h6 style="font-weight: bold;text-decoration: underline;color: #000" id="summary_title"><?= $title ?></h6></center>
                                      <br/>
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
                                             // print_r($summary);
                                             // echo "</pre>";
                                            $date=day_date($dt,$month,$year);

                                    ?>
                                    <div id="report-container" >
                                        
                                         <?php
                                        if (isset($max->frequency)) {
                                        ?>
                                         <h6>
                                            <strong>
                                            <span class="text-info">Avg:</span><?= (isset($average))?$average->frequency:"0" ?> | 
                                            <span class="text-info">Min. Frequency: </span><?= $min->frequency;?><?= ($dt=="month")? " <span class='text-info'> Day: </span> ".date("d/m/Y",strtotime($min->captured_at)):" <span class='text-info'>Hour:</span> ".$min->hour ?>  |
                                            <span class="text-info">Max. Frequency: </span><?= $max->frequency;?><?= ($dt=="month")? " <span class='text-info'> Day: </span> ".date("d/m/Y",strtotime($max->captured_at)):" <span class='text-info'>Hour:</span> ".$max->hour ?>   | 
                                            <span class="text-info">Mode: </span><?= ((isset($mode)))?$mode->mode:'0' ?>
                                            </strong>
                                        </h6>
                                        <?php } ?>
                                        
                                       

                                        <div style="overflow-x: auto;" id="doublescroll">
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
                                                               ?>
                                                               <td>
                    <?php
                   foreach ($summary as $report) {
                    if ($dt=="month") {
                        //if is monthly
                        if ($report->hour==$hour && date("d",strtotime($report->captured_at))==$key+1) {
                        ?>
                        <?= $report->frequency ?></strong> 
                      
                       <?php 
                    } 
                    } else {
                        //is a day
                       if ($report->hour==$hour && date("d",strtotime($report->captured_at))==substr($day, 4)) {
                        ?>
                        <?= $report->frequency ?></strong> 
                      
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
                      
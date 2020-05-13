<div class="card">
                               <div class="card-header"><h4>ENERGY REPORT</h4></div>
                               <div class="card-body">
                                    <?php echo validation_errors('<div class="alert alert-danger mb-2">','</div>'); ?>
                      <?php $this->load->view('partials/mis_feeder_search_energy'); ?>
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
                                    <div id="consumptionChart">
                                      <span class="fa fa-spin fa-2x"></span>
                                    </div>
                            <br/><br/>

                                    <?php
                                        if (isset($summary)) {  
                                             // echo "<pre>";
                                             // print_r($summary);
                                             // echo "</pre>";
                                            $date=day_date($dt,$month,$year);

                                    ?>
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                          aria-controls="home" aria-selected="true">Readings</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                          aria-controls="profile" aria-selected="false">Consumptions</a>
                      </li>
                     
                    </ul>
                     <div class="tab-content" id="myTabContent">
                       <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                    <div id="report-container" >
                                        <?php
                                        if (isset($max->energy)) {
                                        ?>
                                          <h6>
                                            <strong>
                                            <span class="text-info">Avg:</span><?= (isset($average))?round($average->energy,2):"0" ?> | 
                                            <span class="text-info">Min. Reading: </span><?= $min->energy;?><?= ($dt=="month")? " <span class='text-info'> Day: </span> ".date("d/m/Y",strtotime($min->captured_at)) .' Hour: '.$min->hour:" <span class='text-info'>Hour:</span> ".$min->hour ?>  |
                                            <span class="text-info">Max. Reading: </span><?= $max->energy;?><?= ($dt=="month")? " <span class='text-info'> Day: </span> ".date("d/m/Y",strtotime($max->captured_at)) .' Hour: '.$max->hour:" <span class='text-info'>Hour:</span> ".$max->hour ?>   | 
                                            
                                            </strong>
                                        </h6>
                                        <?php } ?>
                                        
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
                        <?= $report->energy ?></strong> 
                      
                       <?php 
                    } 
                    } else {
                        //is a day
                       if ($report->hour==$hour && date("d",strtotime($report->captured_at))==substr($day, 4)) {
                        ?>
                        <?= $report->energy ?></strong> 
                      
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
                                  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                      <!--consumption -->
                       <?php
                                        if (isset($max->hourly_comsumption)) {
                                        ?>
                                          <h6>
                                            <strong>
                                            
                                            <span class="text-info">Min. Consumption: </span><?= $min->hourly_comsumption;?><?= ($dt=="month")? " <span class='text-info'> Day: </span> ".date("d/m/Y",strtotime($min->captured_at)) .' Hour: '.$min->hour:" <span class='text-info'>Hour:</span> ".$min->hour ?>  |
                                            <span class="text-info">Max. Consumption: </span><?= $max->hourly_comsumption;?><?= ($dt=="month")? " <span class='text-info'> Day: </span> ".date("d/m/Y",strtotime($max->captured_at)) .' Hour: '.$max->hour:" <span class='text-info'>Hour:</span> ".$max->hour ?>   | 
                                            
                                            </strong>
                                        </h6>
                                        <?php } ?>
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
                   foreach ($summary as $consumption) {
                    if ($dt=="month") {
                        //if is monthly
                        if ($consumption->hour==$hour && date("d",strtotime($consumption->captured_at))==$key+1) {
                        ?>
                        <?= $consumption->hourly_comsumption ?></strong> 
                      
                       <?php 
                    } 
                    } else {
                        //is a day
                       if ($consumption->hour==$hour && date("d",strtotime($consumption->captured_at))==substr($day, 4)) {
                        ?>
                        <?= $consumption->hourly_comsumption ?></strong> 
                      
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
                          
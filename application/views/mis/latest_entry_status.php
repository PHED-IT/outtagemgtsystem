<div class="row">

<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Latest 33kv Date and hour </h5>
                          <h2 class="mb-3 font-18"><?= date("d-M-Y H:i",strtotime($latest_hour_33->created_at)) .' |  '. $latest_hour_33->hour.':00'?></h2>
                          
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <div class="banner-img">
                          <img src="<?php echo asset_url();?>img/banner/3.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                           <h5 class="font-15">Latest 11kv Date and hour </h5>
                           <?php 
                           if (isset($latest_hour_11)) { ?>
                          <h2 class="mb-3 font-18"><?= date("d-M-Y H:i",strtotime($latest_hour_11->created_at)) .' |  '. $latest_hour_11->hour.':00'?></h2>
                          <?php } ?>
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <div class="banner-img">
                          <img src="<?php echo asset_url();?>img/banner/3.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15"> Total</h5>
                          <h2 class="mb-3 font-18">1,287</h2>
                          
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <div class="banner-img">
                          <img src="<?php echo asset_url();?>img/banner/4.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
 -->
<!-- <div class="col-md-12">
 <div class="card card-primary">
  <div class="card-header">
    <h4>Hi <?= $user->last_name ?>! You are a/an <?= $user->role_name ?> </h4>
  </div>
   <div class="card-body">
     <h3>Welcome to Network Operation Management System</h3>
   </div>
 </div>
</div> -->
        </div>


                        <div class="card">
                            <!-- <div class="widget-heading clearfix">
                                <h5>jQuery DataTables</h5>
                            </div>
 -->                            <!-- /.widget-heading -->
 <div class="card-header">
     <h4>Feeder wise latest entry status</h4>
    
 </div>
                            <div class="card-body">
                                 
                                <table id="" class="table table-striped table-responsive" data-toggle="datatables" data-plugin-options='{"searching": true}'>
                                    <thead>
                                        <tr>
                                            <th>Voltage Level</th>
                                            <th>Transmission/ISS Station</th>
                                            <th>Transformer</th>
                                            <th>Feeder</th>
                                            <th>Captured date</th>
                                            <th>Entered by</th>
                                            <th>Entered on</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    //var_dump($users);
                                        foreach ($reports as $report) {
                                            ?>
                                            <tr >
                                                <td><?= $report->voltage_level; ?></td>
                                                <td><?= $report->voltage_level=="33kv"?$report->tsname:$report->iss; ?></td>
                                                <td><?= $report->transformer; ?></td>
                                                <td><?= $report->feeder; ?></td>
                                                <td><?= date("d-M-Y",strtotime($report->captured_at)); ?></td>
                                                <td><?= $report->first_name.' '.$report->last_name; ?></td>
                                                <td><?= date("d-M-Y H:i a",strtotime($report->created_at)); ?></td>
                                                
                                                
                                            </tr>
                                            <?php
                                        }
                                    ?>
                                    </tbody>
                                   
                                </table>



                            </div>
                            <!-- /.widget-body -->
                        </div>
                        <!-- /.widget-bg -->
                 
            <!-- /.widget-list -->

        
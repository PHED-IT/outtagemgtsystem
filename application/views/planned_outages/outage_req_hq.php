<div class="row page-title clearfix">
               
                <!-- /.page-title-left -->
                <div class="page-title-right d-none d-sm-inline-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Outage Request By HQ</li>
                    </ol>
                </div>
                <!-- /.page-title-right -->
            </div>

           
            <div class="widget-list">
              <div class="row">
              <div class="col-md-12 widget-holder">
                <div class="d-flex justify-content-between">
                  <div>
                    
                  </div>
                  <div>
                    <a class="btn btn-sm btn-outline-primary " href="<?= base_url('planned/outage_request_form') ?>?req_officer=hq"><i class="fa fa-plus"></i> Request</a>
                  </div>
                </div>
                      
    
                 <table id="simpleTable" class="table table-striped table-bordered table-responsive" data-toggle="datatables" data-plugin-options='{"searching": true}'>
                     <thead>
                      <tr>
                      <th>Feeder</th>
                      <th>Outage ID</th>
                      <th>Status</th>
                      <th>Outage schedule date</th>
                      <th></th>
                      <th></th>                             
                      <th></th>                             
                  </tr>
                    </thead>
                    <tbody>
      <?php
          foreach ($outages as $outage) {
              ?>
              <tr>
                  <td><?= $outage->feeder_name; ?></td>
                  <td><?= $outage->outage_id; ?></td>
                  <td><?= $outage->status_message; ?></td>
                  <td><?= date("d-M-Y h:i a",strtotime($outage->outage_request_date)); ?></td>
                   <td>
                    <?php
                    if ($outage->status==0 ||$outage->status==10||$outage->status==11) {
                      ?>
                      <span data-toggle="tooltip" data-placement="bottom"
                title="Outage denied" class="fa fa-remove text-danger"></span>
                      <?php
                    }elseif ($outage->status>=1&&$outage->status<=4 ) {
                     ?>
                     <span data-toggle="tooltip" data-placement="bottom"
                title="Outage is pending" class="fa fa-spinner fa-spin text-warning"></span>
                     <?php
                    }elseif ($outage->status==5 || $outage->status==6) {
                     ?>
                     <span data-toggle="tooltip" data-placement="bottom"
                title="Outage is approved" class="fa fa-spinner fa-pulse text-primary"></span>
                     <?php
                    }elseif ($outage->status==7 ) {
                     ?>
                     <span data-toggle="tooltip" data-placement="bottom"
                title="work is ongoing" class="fa fa-spinner fa-pulse text-info"></span>
                     <?php
                    }elseif ($outage->status==8 ) {
                     ?>
                     <span data-toggle="tooltip" data-placement="bottom"
                title="outage taken" class="fa fa-check text-success"></span>
                     <?php
                    }
                    ?>
                    
                  </td>
                 
                  <td>
                    <?php
                    if ($outage->status>=5) {
                      ?>
                     <button class="" target="popup" 
  onclick="window.open('<?= base_url('planned/view_outage/'.$outage->outage_id) ?>','popup','width=600,height=600'); return false;" data-toggle="tooltip" data-placement="bottom"
                title="View more"><span class="fa fa-eye text-primary"></span></button>
              <?php } ?>
                  </td>   
                  <td></td>                      
              </tr>
              <?php
          }
      ?>
              </tbody>
                                   
            </table>
                
              </div>
            </div>
            </div>
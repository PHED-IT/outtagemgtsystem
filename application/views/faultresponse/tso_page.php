<div class="row page-title clearfix">
               
                <!-- /.page-title-left -->
                <div class="page-title-right d-none d-sm-inline-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Fault/Rapid Response TSO</li>
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
                    
                  </div>
                </div>
                      
     <table id="simpleTable1" class="table tables  table-bordered table-responsive" data-toggle="datatables" data-plugin-options='{"searching": true}'>
                     <thead>
                      <tr>
                       <th> Id</th>
                      <th>Equipment</th>
                      <th>Category</th>
                      <th>Voltage Level</th>
                      <th>Response</th>
                      
                      <th>Status</th>
                      <th>Reason</th>
                      <th>Entry Date</th>
                      <th>Planned Date</th>
                      <th>Date/Time Occurred</th>
                      <th>Est. Duration</th>
                      <th></th>                             
                  </tr>
                    </thead>
                    <tbody>
      <?php
          foreach ($outages as $outage) {
              ?>
              <tr>
                 <td><?= $outage->outage_id; ?></td>
                  <td style="font-size: 11px">
                    <?php
                      if ($outage->category=="Transmission station") {
                        echo $outage->transmission;
                      }elseif ($outage->category=="Injection substation") {
                        echo $outage->iss_name;
                      }elseif ($outage->category=="Transformer") {
                        if ($outage->voltage_level=="33kv") {
                           echo $outage->transmissionN." > <span class='text-info'>".$outage->transformer."</span>";
                        }else{
                          echo $outage->iss_nameN." > <span class='text-info'>".$outage->transformer."</span>";
                        }
                       
                      }elseif ($outage->category=="Feeder") {
                        if ($outage->voltage_level=="33kv") {
                           echo $outage->transmissionN." > ".$outage->transformerN." >  <span class='text-info'>".$outage->feeder_name."</span>";
                        }else{
                           echo $outage->iss_nameN." > ".$outage->transformerN." >  <span class='text-info'>".$outage->feeder_name."</span>";
                        }
                      }
                    ?>
                  </td>
                  <td><?= $outage->category; ?></td>
                  <td><?= $outage->voltage_level; ?></td>
                  <td><?= $outage->type_response==1?'Fault':'Rapid'; ?></td>
                  
                   <td>
                    <?php 
                      if($outage->status==0){
                        ?>
                        <i class="fa fa-ban text-danger"></i>
                        <?php
                      }else{
                        ?>
                        <i class="fa fa-handshake-o text-success"></i>
                       <span id="text<?= $outage->outage_id ?>"> <?= $outage->status_message; ?></span>
                        <?php
                      }
                    ?>
                  </td>
                  <td><?= $outage->indicator; ?></td>
                  <td class="td"><?= date("d-M-Y h:i a",strtotime($outage->created_at)); ?></td>
                  <td class="td"><?= date("d-M-Y h:i a",strtotime($outage->outage_date)); ?></td>
                  <td><?= $outage->duration; ?> min.</td>
                              
                  <td>
                    <?php
                      if ($outage->status==1) {
                        ?>
                        <button data-type="<?= $outage->type_response ?>" id="<?= $outage->outage_id ?>" class="acknowled_fault_resp_tso" data-toggle="tooltip" data-placement="bottom"
                title="Acknowledge request"><span class="fa fa-flash"></span></button>
                        <?php
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
            </div>
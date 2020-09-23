

           
            <div class="card">
              
                <div class="card-header">
                 
                      <h4>Planned Outages</h4>
                    
                      <div class="card-header-action">
                       <a class="btn btn-sm btn-outline-primary justify-content-end" style="" href="<?= base_url('planned/outage_request_form') ?>?req_officer=ibc"><i class="fa fa-plus"></i> New Request</a>
                    </div>
                    
               
                  
                    
                  
                </div>
                      
              <div class="card-body">
                  <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                          aria-controls="home" aria-selected="true" style="color: #000">33kv Feeder</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab" style="color: #000" data-toggle="tab" href="#profile" role="tab"
                          aria-controls="profile" aria-selected="false">11kv Feeder</a>
                      </li>
                     
                    </ul>
                    <div class="tab-content" id="myTabContent">
                       <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                 <table id="simpleTable3" width="" class="table tables table-responsive table-bordered myclass" style="overflow: auto;" data-toggle="datatables" data-plugin-options='{"searching": true}'>
                     <thead>
                      <tr>
                      <th> S/n</th>
                      <th> Id</th>
                      <th>Equipment</th>
                      <th>Category</th>
                      <th>Voltage Level</th>
                      
                      <th>Status</th>
                      <th>Reason</th>
                      <th>Entry Date</th>
                      <th>Planned Date</th>
                      <th>Duration</th>
                      <th>End Date</th>
                      <th></th>                             
                      <th></th>                             
                                                  
                  </tr>
                    </thead>
                    <tbody>
      <?php
          foreach ($outages as $key=> $outage) {
              ?>
              <tr>
                  <td><?= $key+1; ?></td>
                  <td><?= $outage->outage_id; ?></td>
                  <td style="font-size: 11px">
                    <?php
                      if ($outage->category=="Transmission station") {
                        echo $outage->transmission;
                      }elseif ($outage->category=="Transformer") {
                        if ($outage->voltage_level=="33kv") {
                           echo $outage->transmissionN." > <span class='text-info'>".$outage->transformer."</span>";
                        }
                        // else{
                        //   echo $outage->iss_nameN." > <span class='text-info'>".$outage->transformer."</span>";
                        // }
                       
                      }elseif ($outage->category=="Feeder") {
                        if ($outage->voltage_level=="33kv") {
                           echo $outage->transmissionN." > ".$outage->transformerN." >  <span class='text-info'>".$outage->feeder_name."</span>";
                        }
                      }
                    ?>
                  </td>
                  <td><?= $outage->category; ?></td>
                  <td><?= $outage->voltage_level; ?></td>
                  
                  <td><?= $outage->status_message; ?></td>
                  <td><?= $outage->reason; ?></td>
                  <td class="td"><?= date("d-M-Y h:i a",strtotime($outage->created_at)); ?></td>
                  <td class="td"><?= date("d-M-Y h:i a",strtotime($outage->outage_request_date)); ?></td>
                  <td><?= $outage->duration; ?> min.</td>
                  <td class="td"><?= date("d-M-Y h:i a",strtotime($outage->end_date)); ?></td>
                 
                  <td>
                     <?php
                    if ($outage->status>=5) {
                      ?>
                     <button class=" btn-primary" target="popup" 
  onclick="window.open('<?= base_url('planned/view_outage/'.$outage->outage_id) ?>','popup','width=600,height=600'); return false;" data-toggle="tooltip" data-placement="bottom"
                title="View more"><span class="fa fa-eye text-primary"></span></button>
              <?php } ?>
                  </td>   
                     <td>
                         <button  class=" btn-success" data-toggle="modal" data-target="#modal<?= $outage->id ?>" data-placement="bottom"
                title=" Acknowledge"><span class="fa fa-flash"></span></button>



                  <!-- acknowledge modal -->
                          <div class="modal fade" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);z-index: 1" id="modal<?= $outage->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document" >
        <div class="modal-content">
         
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">View more</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body" >
            <p class="text" style="font-size: 11px">Equipment:
            <?php

                      if ($outage->category=="Transmission station") {
                        echo $outage->transmission;
                      }elseif ($outage->category=="Transformer") {
                        if ($outage->voltage_level=="33kv") {
                           echo $outage->transmissionN." > <span class='text-info'>".$outage->transformer."</span>";
                        }
                       
                      }elseif ($outage->category=="Feeder") {
                        if ($outage->voltage_level=="33kv") {
                           echo $outage->transmissionN." > ".$outage->transformerN." >  <span class='text-info'>".$outage->feeder_name."</span>";
                        }
                      }
                    ?>
                  </p>
            <p>Planned date: <?= date("d-M-Y h:i a",strtotime($outage->outage_request_date)); ?></p>
            <p>Duration: <?= $outage->duration ?> minutes</p>
            <p>End date: <?= date("d-M-Y h:i a",strtotime($outage->end_date)); ?></p>
            <p>Location: <?= $outage->location ?></p>
            <p>Permit Type: <?= $outage->ptw_type ?></p>
          
            <p>Remark : <?= $outage->remark ?></p>
            <?php
              if ($outage->status==0) {
              ?>
              <hr/>
              <div class="card card-danger">
                <div class="card-header">
                  <h5>Outage deniend</h5>
                </div>
                <div class="card-body">
                  <p>Rejected by: <?= $outage->reject_by ?></p>
                   <p >Rejection date: <?= date("d-M-Y h:i a",strtotime($outage->rejection_date)); ?></p>
              <p>Reason:  <?= $outage->reason ?></p>
                </div>
              </div>
              
             
              <?php
              }
            ?>
          </div>
          <div class="modal-footer">
            
            <button class="btn btn-sm btn-outline-danger" type="button" data-dismiss="modal">Cancel</button>
           
          </div>
          
        </div>
      </div>
    </div>
                     </td>                 
              </tr>
              <?php
          }
      ?>
              </tbody>
                                   
            </table>
          </div>
          <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <!-- 11kv -->

             <table id="simpleTable2" width="" class="table tables table-responsive table-bordered myclass" style="overflow: auto;" data-toggle="datatables" data-plugin-options='{"searching": true}'>
                     <thead>
                      <tr>
                      <th> S/n</th>
                      <th> Id</th>
                      <th>Equipment</th>
                      <th>Category</th>
                      <th>Voltage Level</th>
                      
                      <th>Status</th>
                      <th>Reason</th>
                      <th>Entry Date</th>
                      <th>Planned Date</th>
                      <th>Duration</th>
                      <th>End Date</th>
                      <th></th>                             
                      <th></th>                             
                                                  
                  </tr>
                    </thead>
                    <tbody>
      <?php
          foreach ($outages_11kv as $key=> $outage) {
              ?>
              <tr>
                  <td><?= $key+1; ?></td>
                  <td><?= $outage->outage_id; ?></td>
                  <td style="font-size: 11px">
                    <?php
                      if ($outage->category=="Injection substation") {
                        echo $outage->iss_name;
                      }elseif ($outage->category=="Transformer") {
                        
                        
                          echo $outage->iss_nameN." > <span class='text-info'>".$outage->transformer."</span>";
                        
                       
                      }elseif ($outage->category=="Feeder") {
                        
                           echo $outage->iss_nameN." > ".$outage->transformerN." >  <span class='text-info'>".$outage->feeder_name."</span>";
                        
                      }
                    ?>
                  </td>
                  <td><?= $outage->category; ?></td>
                  <td><?= $outage->voltage_level; ?></td>
                  
                  <td><?= $outage->status_message; ?></td>
                  <td><?= $outage->reason; ?></td>
                  <td class="td"><?= date("d-M-Y h:i a",strtotime($outage->created_at)); ?></td>
                  <td class="td"><?= date("d-M-Y h:i a",strtotime($outage->outage_request_date)); ?></td>
                  <td><?= $outage->duration; ?> min.</td>
                  <td class="td"><?= date("d-M-Y h:i a",strtotime($outage->end_date)); ?></td>
                 
                  <td>
                     <?php
                    if ($outage->status>=5) {
                      ?>
                     <button class=" btn-primary" target="popup" 
  onclick="window.open('<?= base_url('planned/view_outage/'.$outage->outage_id) ?>','popup','width=600,height=600'); return false;" data-toggle="tooltip" data-placement="bottom"
                title="View more"><span class="fa fa-eye text-primary"></span></button>
              <?php } ?>
                  </td>   
                     <td>
                         <button  class=" btn-success" data-toggle="modal" data-target="#emodal<?= $outage->id ?>" data-placement="bottom"
                title=" Acknowledge"><span class="fa fa-flash"></span></button>



                  <!-- acknowledge modal -->
                          <div class="modal fade" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);z-index: 1" id="emodal<?= $outage->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document" >
        <div class="modal-content">
         
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">View more</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body" >
            <p class="text" style="font-size: 11px">Equipment:
            <?php

                      if ($outage->category=="Injection substation") {
                        echo $outage->iss_name;
                      }elseif ($outage->category=="Transformer") {
                       
                          echo $outage->iss_nameN." > <span class='text-info'>".$outage->transformer."</span>";
                      
                       
                      }elseif ($outage->category=="Feeder") {
                        
                           echo $outage->iss_nameN." > ".$outage->transformerN." >  <span class='text-info'>".$outage->feeder_name."</span>";
                        
                      }
                    ?>
                  </p>
            <p>Planned date: <?= date("d-M-Y h:i a",strtotime($outage->outage_request_date)); ?></p>
            <p>Duration: <?= $outage->duration ?> minutes</p>
            <p>End date: <?= date("d-M-Y h:i a",strtotime($outage->end_date)); ?></p>
            <p>Location: <?= $outage->location ?></p>
            <p>Permit Type: <?= $outage->ptw_type ?></p>
          
            <p>Remark : <?= $outage->remark ?></p>
            <?php
              if ($outage->status==0) {
              ?>
              <hr/>
              <div class="card card-danger">
                <div class="card-header">
                  <h5>Outage deniend</h5>
                </div>
                <div class="card-body">
                  <p>Rejected by: <?= $outage->reject_by ?></p>
                   <p >Rejection date: <?= date("d-M-Y h:i a",strtotime($outage->rejection_date)); ?></p>
              <p>Reason:  <?= $outage->reason ?></p>
                </div>
              </div>
              
             
              <?php
              }
            ?>
          </div>
          <div class="modal-footer">
            
            <button class="btn btn-sm btn-outline-danger" type="button" data-dismiss="modal">Cancel</button>
           
          </div>
          
        </div>
      </div>
    </div>
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
            
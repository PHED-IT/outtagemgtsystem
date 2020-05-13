
              <div class="card">
                <div class="card-header">
                  <h4>DSO</h4>
                </div>
                      
                <div class="card-body">
                 <table id="simpleTable1" class="table tables  table-bordered table-responsive" data-toggle="datatables" data-plugin-options='{"searching": true}'>
                     <thead>
                      <tr>
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
                  <td><?= $outage->reason; ?></td>
                  <td class="td"><?= date("d-M-Y h:i a",strtotime($outage->created_at)); ?></td>
                  <td class="td"><?= date("d-M-Y h:i a",strtotime($outage->outage_request_date)); ?></td>
                  <td><?= $outage->duration; ?> min.</td>
                  <td class="td"><?= date("d-M-Y h:i a",strtotime($outage->end_date)); ?></td>
                 
                  <td>
                    <?php
                    if ($outage->status>=5) {
                      ?>
                     <button class="btn-success" target="popup" 
  onclick="window.open('<?= base_url('planned/view_outage/'.$outage->outage_id) ?>','popup','width=600,height=600'); return false;" data-toggle="tooltip" data-placement="bottom"
                title="View more"><span class="fa fa-eye text-primary"></span></button>
              <?php } ?>
                  </td>  
                  <td>

                      <button  class="  btn-primary" data-toggle="modal" data-target="#modal<?= $outage->outage_id ?>" data-placement="bottom"
                title=" Acknowledge"><span class="fa fa-flash"></span></button>



                        <!-- acknowledge modal -->
                          <div class="modal fade" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);z-index: 1" id="modal<?= $outage->outage_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document" >
        <div class="modal-content">
         
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">View more</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">

            <?php
              if ($outage->status==6 && $outage->voltage_level=="11kv") {
                ?>
                <h4>Closure</h4>
                <form class="confirm_work_done_plan" id="div<?= $outage->outage_id ?>" data-id="<?= $outage->outage_id ?>">
                    <input type="hidden" name="outage_id" value="<?= $outage->outage_id ?>">
                   <div class="row">
                    
                    <div class="" style="overflow-x: auto;">
                    <div class="col-md-12">
                        
                        <label class="col-form-label" for="reading"> Write Comprehensive report of work done</label>
                        
                        <input id="content" type="hidden" name="content">
  <trix-editor input="content" required style="max-height: 250px !important;height:250px !important;overflow-y: auto !important; " ></trix-editor>
                        
                    
                    </div>
                </div>
                <br/>
                <button class="btn btn-sm btn-outline-success" type="submit" id="sub<?= $outage->outage_id ?>">Submit</button>
                </div>
              </form>
               <hr/>
                <?php
              }
            ?>
            <p style="font-weight: 11px">Equipment
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
                  </p>
            <p>Duration: <?= $outage->duration ?></p>
            <p>End date: <?= $outage->end_date ?></p>
            <p>Location: <?= $outage->location ?></p>
          
            <p>Remark : <?= $outage->remark ?></p>
            <p>Permit Type: <?= $outage->ptw_type ?></p>
            <p>Permit Holder: <?= $outage->ph_l .' '.$outage->ph_f ?></p>
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
              <p>Reason:  <?= $outage->rejection_reason ?></p>
                </div>
              </div>
              
             
              <?php
              }
            ?>
              <?php
                if ($outage->status==5  && $outage->voltage_level=="11kv") {
              ?>
              <hr/>
              <input type="text" class="form-control"  name="ptw_number" id="ptw_number" placeholder="Enter PTW number">
              
                    <div class="pretty p-default mb-2 my-3">
                      <input type="checkbox" id="two" />
                      <div class="state p-success">
                        <label>Station guarantee issued</label>
                      </div>
                    </div>
                    <div class="pretty p-default">
                      <input type="checkbox" id="three" />
                      <div class="state p-success">
                        <label>Isolate the requested feeder/equipment, de-energised, ground</label>
                      </div>
                    </div>
                   
              <?php } ?> 
        
          </div>
          <div class="modal-footer">
             <?php
                if ($outage->status==5 && $outage->voltage_level=="11kv") {
              ?>
                <div class="modal-footer" id="div<?= $outage->outage_id ?>">
                <button id="<?= $outage->outage_id ?>" class="btn btn-sm btn-outline-success approve_plan_out_tso"  type="button" >Approve</button>
                <button type="button" data-toggle="modal" data-target="#reject<?= $outage->id ?>" class="btn btn-sm btn-outline-danger ">Reject</button>
                         
                        </div>

                                 
            <?php
                }
            ?>
          </div>
          
        </div>
      </div>
    </div>

    <!-- end -->

    <!-- Reject modal -->
                          <div class="modal fade" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);z-index: 1"  id="reject<?= $outage->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form class="reject_plan_out_dso" data-id="<?= $outage->outage_id ?>">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Reject request</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="outage_id" value="<?= $outage->outage_id ?>">
                 
              <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                        <label class="col-md-5 col-form-label" for="reading"> Enter reason for rejection</label>
                        
                        <textarea required name="reason_rejection" value="" class="form-control">
                        </textarea>
                        
                    </div>
                    </div>
                </div>
               
        
          </div>
          <div class="modal-footer">
            <button class="btn btn-sm btn-outline-success" type="submit" id="sub<?= $outage->outage_id ?>">Submit</button>
            <button class="btn btn-sm btn-outline-danger" type="button" data-dismiss="modal">Cancel</button>
           
          </div>
          </form>
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
         
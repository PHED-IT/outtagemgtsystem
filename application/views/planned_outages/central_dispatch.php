
       
              <div class="card">
                <div class="card-header">
                  <h4>Central Dispatch(Planned Outage)</h4>
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
                  <table id="simpleTable3" class="table tables  table-bordered table-responsive" data-toggle="datatables" data-plugin-options='{"searching": true}'>
                     <thead>
                      <tr>
                       <th> S/N</th>
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
                  <td class="td">
                    <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalFF<?= $outage->id ?>"><span class="fa fa-image"></span></button>
                      <div class="modal fade" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);z-index: 1" id="modalFF<?= $outage->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document" >
        <div class="modal-content">
         
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Supporting Document</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body" >
            <?php
              if (empty($outage->support_docx)) {
                ?>
                <center><h4 class="text-danger">Suporting document was not uploaded</h4></center>
                <?php
              } else {
                ?>
                <div style="width: 100%;height: 300px;">
                <img class="img-responsive" width="100%" height="100%" src="<?php echo asset_url();?>uploads/<?= $outage->support_docx ?>" />

                
              </div>
                <?php
              }
              
            ?>
          </div>
          <div class="modal-footer">
            <?php
            if (!empty($outage->support_docx)) {
             ?>
            <a href="<?php echo asset_url();?>uploads/<?= $outage->support_docx ?>" class="btn btn-sm btn-success" download="">Download document</a>
          <?php } ?>
            <button class="btn btn-sm btn-outline-danger" type="button" data-dismiss="modal">Cancel</button>
           
          </div>
          
        </div>
      </div>
    </div>
                  </td>
                  <td>
                     <?php
                    if ($outage->status>=3) {
                      ?>
                     <button class="btn-success text-primary" target="popup" 
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
              if ($outage->status>=5 && $outage->voltage_level=="33kv") {
                ?>
                <h6>Closure</h6>
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
                <button class="btn btn-outline-success my-4" type="submit" id="sub<?= $outage->outage_id ?>">Submit</button>
                </div>
              </form>
               <hr/>
                <?php
              }
            ?>


               <?php
                if ($outage->status==5  && $outage->voltage_level=="33kv") {
              ?>
              <div id="div<?= $outage->outage_id ?>">
              <input type="text" class="form-control" name="ptw_number" id="ptw_number" placeholder="Enter PTW number">
             
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

                    <button id="<?= $outage->outage_id ?>" class="btn btn-sm btn-outline-success approve_plan_out_tso my-3"  type="button" >Start outage</button>
                   <hr/>
                 </div>
              <?php } ?> 
            <p class="text" style="font-size: 11px">Equipment:
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
            <p>Planned date: <?= date("d-M-Y h:i a",strtotime($outage->outage_request_date)); ?></p>
  <p>Duration: <?= $outage->duration ?>minutes</p>
            <p>End date: <?= $outage->end_date ?></p>
            <p>Location: <?= $outage->location ?></p>
            <p>Permit Type: <?= $outage->ptw_type ?></p>
          
            <p>Remark : <?= $outage->remark ?></p>
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
          </div>
          <div class="modal-footer" id="d<?= $outage->outage_id ?>">
           <?php
                if ($outage->status==3) {
              ?>
            <button  id="<?= $outage->outage_id ?>" class="btn btn-sm btn-outline-success approve_plan_out_cd " data-toggle="tooltip" data-placement="bottom"
                title="Approve request" type="button" >Approve</button>
            
            <button class="btn btn-sm btn-outline-danger" type="button" data-toggle="modal" data-target="#reject<?= $outage->id ?>">Reject</button>


             <!-- Reject modal -->
                          <div class="modal fade" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);z-index: 1" id="reject<?= $outage->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form class="cd_reject_plan_out" data-id="<?= $outage->outage_id ?>">
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
                        
                        <label class="col-form-label" for="reading"> Enter reason for rejection</label>
                        
                        <textarea required name="rejection_reason" class="form-control">
                          
                        </textarea>
                        
                    
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


           <?php
                }
            ?>
          </div>
          
        </div>
      </div>
    </div>

    <!-- end -->

                  </td>                      
              </tr>
              <?php
          }
      ?>
                      </tbody>
                                   
            </table>

          </div>


          <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
               <table id="simpleTable2" class="table tables  table-bordered table-responsive" data-toggle="datatables" data-plugin-options='{"searching": true}'>
                     <thead>
                      <tr>
                       <th> S/N</th>
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
                  <td class="td">
                    <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalFF<?= $outage->id ?>"><span class="fa fa-image"></span></button>
                      <div class="modal fade" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);z-index: 1" id="modalFF<?= $outage->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document" >
        <div class="modal-content">
         
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Supporting Document</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body" >
            <?php
              if (empty($outage->support_docx)) {
                ?>
                <center><h4 class="text-danger">Suporting document was not uploaded</h4></center>
                <?php
              } else {
                ?>
                <div style="width: 100%;height: 300px;">
                <img class="img-responsive" width="100%" height="100%" src="<?php echo asset_url();?>uploads/<?= $outage->support_docx ?>" />

                
              </div>
                <?php
              }
              
            ?>
          </div>
          <div class="modal-footer">
            <?php
            if (!empty($outage->support_docx)) {
             ?>
            <a href="<?php echo asset_url();?>uploads/<?= $outage->support_docx ?>" class="btn btn-sm btn-success" download="">Download document</a>
          <?php } ?>
            <button class="btn btn-sm btn-outline-danger" type="button" data-dismiss="modal">Cancel</button>
           
          </div>
          
        </div>
      </div>
    </div>
                  </td>
                  <td>
                     <?php
                    if ($outage->status>=3) {
                      ?>
                     <button class="btn-success text-primary" target="popup" 
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
              if ($outage->status>=5 && $outage->voltage_level=="33kv") {
                ?>
                <h6>Closure</h6>
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
                <button class="btn btn-outline-success my-4" type="submit" id="sub<?= $outage->outage_id ?>">Submit</button>
                </div>
              </form>
               <hr/>
                <?php
              }
            ?>


               <?php
                if ($outage->status==5  && $outage->voltage_level=="33kv") {
              ?>
              <div id="div<?= $outage->outage_id ?>">
              <input type="text" class="form-control" name="ptw_number" id="ptw_number" placeholder="Enter PTW number">
             
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

                    <button id="<?= $outage->outage_id ?>" class="btn btn-sm btn-outline-success approve_plan_out_tso my-3"  type="button" >Start outage</button>
                   <hr/>
                 </div>
              <?php } ?> 
            <p class="text" style="font-size: 11px">Equipment:
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
            <p>Planned date: <?= date("d-M-Y h:i a",strtotime($outage->outage_request_date)); ?></p>
  <p>Duration: <?= $outage->duration ?>minutes</p>
            <p>End date: <?= $outage->end_date ?></p>
            <p>Location: <?= $outage->location ?></p>
            <p>Permit Type: <?= $outage->ptw_type ?></p>
          
            <p>Remark : <?= $outage->remark ?></p>
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
          </div>
          <div class="modal-footer" id="d<?= $outage->outage_id ?>">
           <?php
                if ($outage->status==3) {
              ?>
            <button  id="<?= $outage->outage_id ?>" class="btn btn-sm btn-outline-success approve_plan_out_cd " data-toggle="tooltip" data-placement="bottom"
                title="Approve request" type="button" >Approve</button>
            
            <button class="btn btn-sm btn-outline-danger" type="button" data-toggle="modal" data-target="#reject<?= $outage->id ?>">Reject</button>


             <!-- Reject modal -->
                          <div class="modal fade" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);z-index: 1" id="reject<?= $outage->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form class="cd_reject_plan_out" data-id="<?= $outage->outage_id ?>">
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
                        
                        <label class="col-form-label" for="reading"> Enter reason for rejection</label>
                        
                        <textarea required name="rejection_reason" class="form-control">
                          
                        </textarea>
                        
                    
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


           <?php
                }
            ?>
          </div>
          
        </div>
      </div>
    </div>

    <!-- end -->

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
            </div>
            


           
            <div class="card">
              
                <div class="card-header">
                 
                      <h4>Planned Outage Report</h4>  
                  
                </div>
                      
              <div class="card-body">
                <fieldset class="scheduler-border">
   <legend class="scheduler-border">Filter</legend>
      <form action="" method="POST">
                <div class="row">
                  <div class="col-md-3">
                           <label>Choose Status</label>
                           <select class="form-control" name="status">
                             <option value="all">All</option>
                             <option value="approved">Approved</option>
                           </select>
                        </div>
                         <div class="col-md-3">
                           <label>Choose Zone</label>
                           <select class="form-control" name="zone">
                             <option value="all">All</option>
                             <?php
                             foreach ($zones as $key => $value) {
                             ?>
                             <option value="<?= $value->id ?>"><?= $value->name ?></option>
                             <?php
                             }
                             ?>
                           </select>
                        </div>
                        <div class="col-md-3">
                          <label>Choose Date</label>
                          <input type="text" name="outage_date" id="date_range_picker" class="form-control">
                        </div>
                        
                        <div class="col-md-3">
                          <label style="color: #fff">.</label>
                          <button type="submit" class="btn btn-sm btn-info " style="display: block;">Search</button>
                        </div>
                      </div>
                    </form>
                      </fieldset>
                      <?php
                        if (isset($title_report)) {
                          ?>
                          <center><h6 class="text text-info"><?= $title_report ?></h6></center>
                          <?php
                        }
                      ?>


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
                      <th>Request By</th>
                      <th>Entry Date</th>
                      <th>Planned Date</th>
                      <th>Duration</th>
                      <th>End Date</th>
                      <th></th>
                     <!--  <th></th>                             
                      <th></th>  -->                            
                                                  
                  </tr>
                    </thead>
                    <tbody>
      <?php
          foreach ($outages as $key=> $outage) {

              ?>
              <tr>
                  <td><?=$key+1 ; ?></td>
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
                  
                  <td><?= $outage->status >=5?" <span class='text-success'>Approved</span>":"<span class='text-danger'>Pending</span>"; ?></td>
                  <td><?= $outage->reason; ?></td>
                  <td><?= $outage->oro_f.' '.$outage->oro_l.'('.$outage->oro_desig.')'; ?></td>
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
                      <th>Request By</th>
                      <th>Entry Date</th>
                      <th>Planned Date</th>
                      <th>Duration</th>
                      <th>End Date</th>
                      <th></th>
                     <!--  <th></th>                             
                      <th></th>  -->                            
                                                  
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
                  
                   <td><?= $outage->status >=5?" <span class='text-success'>Approved</span>":"<span class='text-danger'>Pending</span>"; ?></td>
                  <td><?= $outage->reason; ?></td>
                  <td><?= $outage->oro_f.' '.$outage->oro_l.'('.$outage->oro_desig.')'; ?></td>
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
                   
                                    
              </tr>
              <?php
          }
      ?>
              </tbody>
                                   
            </table>
          </div>
                
              </div>
            </div>
            
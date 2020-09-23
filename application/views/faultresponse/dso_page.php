  
              <div class="card">
                <div class="card-header">
                  <h4>DSO Fault/Rapid Response</h4>
                  <div class="card-header-action">
                       <a class="btn btn-sm btn-outline-primary justify-content-end" style="" href="<?= base_url('FaultResponse/outage_form') ?>"><i class="fa fa-plus"></i> New Request</a>
                       <a class="btn btn-sm btn-outline-success justify-content-end" style="" href="<?= base_url('mis/fault_report') ?>"><i class="fa fa-book"></i> Fault Report</a>
                    </div>
                </div>
                      
                  <div class="card-body">
                 
                       <table id="simpleTable2" class="table tables  table-bordered table-responsive" data-toggle="datatables" data-plugin-options='{"searching": true}'>
                     <thead>
                      <tr>
                       <th> Id</th>
                      <th>Equipment</th>
                      <th>Category</th>
                      <th>Voltage Level</th>
                      <th>Response</th>
                      
                      <th>Status</th>
                      <th>Indicator</th>
                      <th>Entry Date</th>
                     <th>Date/Time Occurred</th>
                      <th>Load Loss</th>
                    
                      <th></th>                             
                  </tr>
                    </thead>
                    <tbody>
      <?php
      if (isset($outages)) {
        
      
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
                           echo $outage->transmissionN." > ".$outage->transformerN." >  <span class='text-info'>".$outage->feeder11_name."</span>";
                        }else{
                           echo $outage->iss_nameN." > ".$outage->transformerN." >  <span class='text-info'>".$outage->feeder11_name."</span>";
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
                  <td><?= $outage->load_loss; ?> </td>
                              
                  <td>

                   

                         <button  class=" btn-primary" id="btn<?= $outage->outage_id ?>" data-toggle="modal" data-target="#modal<?= $outage->outage_id ?>" data-placement="bottom"
                title=" Acknowledge"><span class="fa fa-flash"></span></button>
                <?php
                //if status is 7 it means fault is due to be closed
                 ?>
                     <button  class=" btn-danger" id="btn<?= $outage->outage_id ?>" data-toggle="modal" data-target="#Closemodal<?= $outage->outage_id ?>" data-placement="bottom"
                title=" Close fault request">Closure</button>
                   



                 <!-- write modal -->
                          <div class="modal fade" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);z-index: 1" id="Closemodal<?= $outage->outage_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form class="submit_report_lines_man" data-id="<?= $outage->outage_id ?>">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Write report</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="outage_id" value="<?= $outage->outage_id ?>">
                 <div class="row">
                   <div class="col-md-12">
                        
                        <label class=" col-form-label " style="display: block;" for="reading"> Cause of Fault</label>
                        
                        <select class="form-control" style="display: block;width: 100%" name="fault_cause">
                          <?php 
                            foreach ($faults as $key => $value) {
                              ?>
                            <option value="<?= $value->id ?>"><?= $value->name ?></option>
                            <?php
                            }
                          ?>
                        </select>
                        
                       
                  
                    </div>
                 </div>
                 <div class="row">
                   <div class="col-md-12">
              
              <label class="col-form-label" for=""> Date and time closed</label>
              <input type="text" required placeholder="Date and time closed" class="form-control" style="color: #333" type="text" name="date_closed" id="captured_date_time" />
             
              
              </div>  
                 </div>
                     <div class="row">
                   <div class="col-md-12">
                        
                        <label class=" col-form-label " for="reading"> Location</label>
                        
                        <input type="text" class="form-control" name="location">
                        
                       
                  
                    </div>
                 </div>
            <div class="mb-2" >
                    <div class="row">
                        <div class="col-md-12">
                        <label class="col-form-label" for="reading"> Write Comprehensive report of work done</label>
                        
                       <textarea name="content" class="form-control "></textarea>
                        
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
          <form id="<?= $outage->outage_id ?>" class="acknowled_fault_resp_dso" enctype="multipart/form-data">
          <div class="modal-body">


             <?php
                if(!empty($outage->images)){
                  echo "<h6>Uploaded Docx</h6>";
                foreach (explode(',', $outage->images) as $key => $image) {
                  echo "<a style='font-weight:bold' href='".$image."'>Docx ".($key+1)."</a><br/>";
                }
              }
              ?>


              <?php
               if ($outage->status==1) {
            ?>
            <input type="hidden" name="outage_id" value="<?= $outage->outage_id ?>">
            <input type="hidden" name="type_response" value="<?= $outage->type_response ?>">
             <div id="ms<?= $outage->outage_id ?>">
              
                    <br/>
                    <div class="col-md-12">
                      <label class="col-form">Upload docx.(PNG,JPEG,JPG)</label>
                       <input type="file" class="form-control" name="files[]" multiple>
                    </div>
                   
                  </div>

                        <?php
                      }
                    ?>
                </div>
          <div class="modal-footer">
             <?php
                if ($outage->status==1) {
              ?>
            <button type="submit" id="submit<?= $outage->outage_id ?>" class="btn btn-sm btn-outline-success  btn btn-primary btn-sm" data-toggle="tooltip" data-placement="bottom"
                title="Acknowledge request" type="button" >Upload</button>
            <?php
                }
            ?>
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

        }
        else{
          echo "<p class='text-danger'>You are not a DSO </p>";
        }
      ?>
                      </tbody>
                                   
            </table>
                
              </div>
            </div>
         
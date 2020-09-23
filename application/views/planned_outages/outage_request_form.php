


                                <!-- <h5 class="box-title mr-b-0">Horizontal Form</h5>
                                <p class="text-muted">All bootstrap element classies</p> -->
            
                     
                          <form  id="planSubmitForm" enctype="multipart/form-data">
                            <div id="loader_submit"></div>
                            <div class="card">
                              <?php echo validation_errors('<div class="alert alert-danger mb-2">','</div>'); ?>
                              <div class="card-header">
                                <h4>Plan Outage Request</h4>
                              </div>
                              <div class="card-body">


                            <?php $this->load->view('partials/outage_feeder_tree'); ?>
                 <div class="row my-2">   
              <div class="col-md-6">
              
              <label class="col-form-label" for=""> Date outage is required</label>
              <input required placeholder="Choose date and time outage is required" class="form-control" style="color: #333" type="text" value="<?= isset($tripping) ? $tripping->outage_date:set_value('outage_date'); ?>" name="outage_date" id="captured_date_time" />
                                    
              <?php echo form_error('outage_date','<span style="color:red">','</span>'); ?>
              
              </div>  
              <div class="col-md-6">
             
            <!--   <label class="col-form-label" for="">Estimated duration of outage</label>
              <input required placeholder="5 mins" class="form-control" type="text"  name="duration" id="" /> -->

              
                      <label class="col-form-label">Estimated duration of outage(minutes)</label>
                     
                       <!--  <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-phone"></i>
                          </div>
                        </div> -->
                        <input type="number" name="duration" required placeholder="1" min="1" class="form-control ">
                        
                           
              <?php echo form_error('duration','<span style="color:red">','</span>'); ?>
              </div>
              
              
              </div> 
              
                 <div class="row">   
              <div class="col-md-6"> 
              <label class="col-form-label" for=""> Reason</label>
             <select class="form-control" name="reason">
                  <?php
                  //var_dump($indicators);
                    foreach ($reasons as $key => $value) {
                      ?>
                      <option value="<?= $value->id ?>"><?= $value->name ?></option>
                      <?php
                    }
                  ?>
                </select>
              </div>  

              <div class="col-md-6">
                <label class="col-form-label" for=""> Permit holder</label>
                <select class="form-control" name="permit">
                  <?php
                  //var_dump($indicators);
                    foreach ($users as $key => $value) {
                      ?>
                      <option value="<?= $value->id ?>"><?= $value->first_name .' '.$value->last_name; ?></option>
                      <?php
                    }
                  ?>
                </select>
              </div>

             
              </div>  

                  <div class="row">   
              <div class="col-md-4"> 
              <label class="col-form-label" for=""> Location</label>
             <input type="text" name="location" class="form-control">
              </div>  

              <div class="col-md-3">
                <label class="col-form-label" for=""> Permit type</label>
              <select class="form-control" name="ptw_type">
                 <option value="Work permit">Work permit</option>
                 <option value="Work & test permit">Work & test permit</option>
                 <option value="Station guarantee">Station guarantee</option>
                </select>
              </div>
              
              <div class="col-md-5"> 
              <label class="col-form-label" for=""> <small>Supporting Document*You can scan document as pdf*(PDF,PNG,JPEG)</small></label>
             <input type="file" name="support_docx"  class="form-control">
              </div>
             
              </div>  

              <div class="row">
                 <div class="col-md-12">
                <label class="col-form-label" for="">Remark</label>
                <textarea class="form-control" placeholder="Remark" name="remark"></textarea>
              </div>
              </div>   
              <br/>   
                <button type="submit" class="btn btn-primary">Submit</button>             
                  </form>
                          </div>
                        </div>
                  
                        
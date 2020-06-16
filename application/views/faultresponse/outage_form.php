
                                <!-- <h5 class="box-title mr-b-0">Horizontal Form</h5>
                                <p class="text-muted">All bootstrap element classies</p> -->
            <?php echo validation_errors('<div class="alert alert-danger mb-2">','</div>'); ?>
                     
                          <form id="faultReponseForm" action="" method="POST">
                            <div class="card">
                              <div class="card-header">
                                <h4>Fault/Rapid Request Form</h4>
                              </div>
                              <div class="card-body">
                                <div id="loader_submit"></div>
           <?php $this->load->view('partials/outage_feeder_tree'); ?>
                                
              <div class="row my-3">   
                 <div class="col-md-3">
              
              <label class="col-form-label" for=""> Transmission Fault?</label>
              <select required class="form-control" name="transmission_fault">
                <option value="0">NO </option>
                <option value="1">YES</option>
                
              </select>
                                    
              </div>
              <div class="col-md-4">
              
              <label class="col-form-label" for=""> Date and time fault occured</label>
              <input type="text" required placeholder="Date and time fault occured" class="form-control" style="color: #333" type="text" name="outage_date" id="captured_date_time" />
                                    
              <?php echo form_error('outage_date','<span style="color:red">','</span>'); ?>
              
              </div>  
               <div class="col-md-2">
             
            <!--   <label class="col-form-label" for="">Estimated duration of outage</label>
              <input required placeholder="5 mins" class="form-control" type="text"  name="duration" id="" /> -->

              
                      <label class="col-form-label">Est. duration(min.)</label>
                      
                       <!--  <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-phone"></i>
                          </div>
                        </div> -->
                        <input type="number" required name="duration" required value="1" min="1" class="form-control ">
                        
                                    
              <?php echo form_error('duration','<span style="color:red">','</span>'); ?>
              </div>
              <div class="col-md-3">
              
              <label class="col-form-label" for=""> Response type</label>
              <select required class="form-control" name="type_response">
                
                <option value="1">Fault</option>
                <option value="2">Rapid</option>
              </select>
                                    
              <?php echo form_error('type_response','<span style="color:red">','</span>'); ?>
              </div>
              
              </div>

                <div class="row">   
           <!--    <div class="col-md-5"> 
              <label class="col-form-label" for=""> Location</label>
             <input type="text" name="location" required class="form-control">
              </div>  --> 

              <div class="col-md-4"> 
              <label class="col-form-label" for=""> Indicators</label>
              <select class="form-control" name="reason_id">
                  <?php
                  //var_dump($indicators);
                    foreach ($indicators as $key => $value) {
                      ?>
                      <option value="<?= $value->id ?>"><?= $value->indicator ?></option>
                      <?php
                    }
                  ?>
                </select>
              </div>

              <div class="col-md-4"> 
              <label class="col-form-label" for=""> Department</label>
              <select class="form-control" required name="department">
                  <option>PC&M</option>           
                  <option>Lines man</option>           
                  <option>S/S</option>           
              </select>
              </div>
              <div class="col-md-4"> 
              <label class="col-form-label" for=""> Load Loss</label>
              <input type="text" name="load_loss" class="form-control">
              </div> 
            </div>
                <div class="row">
              <div class="col-md-12">
              <label class="col-form-label" for=""> Enter remark</label>
              <textarea  name="remarks" class="form-control" style="color: #333" type="text" >
                
              </textarea> 
                                    
              <?php echo form_error('remarks','<span style="color:red">','</span>'); ?>
              </div>
              </div>  
              <br/>       
                     <button type="submit" class="btn btn-primary">Submit</button>             
                  
                          
                  
                          </div>
                            <!-- /.widget-body -->
                        </div>
                        <!-- /.widget-bg -->
                    </form>


                                <!-- <h5 class="box-title mr-b-0">Horizontal Form</h5>
                                <p class="text-muted">All bootstrap element classies</p> -->
            <?php echo validation_errors('<div class="alert alert-danger mb-2">','</div>'); ?>
                     
                          <form id="" action="" method="POST">
                            <div class="card">
                              <div class="card-header">
                                <h4>Add Feeder to Zone</h4>
                              </div>
                              <div class="card-body">
           
                      
              
                <div class="row">
                   
               
                <div class="col-md-4">
              
              <label class="col-form-label" for=""> Choose Zone</label>
              <select class="form-control " id="zone" name="zone_id" >
               <option value="">Choose Zone</option>
               <?php
                foreach ($zones as $key => $value) {
                  ?>
                  <option value="<?= $value->id ?>"><?= $value->name ?></option>
                  <?php
                }
               ?>
              </select>
                                    
              </div>
               
               <div class="col-md-6">
              
              <label class="col-form-label" for=""> Choose 33kv Feeder</label>
              
              <select class="form-control multiple-selector" multiple="" name="feeders[]" id="feeder">
                <option value="">Choose</option>
                <?php
                  foreach ($feeders_33 as $key => $feeder) {
                    ?>
                    <option value="<?= $feeder->id ?>"><?= $feeder->feeder_name ?></option>
                    <?php
                  }
                ?>
              </select>
                                    
              <?php echo form_error('feeder','<span style="color:red">','</span>'); ?>
              </div>
             
              </div> 
              
              <br/>       
                     <button type="submit" id="add_button" class="btn btn-primary">Submit</button>             
                  
                          
                  
                          </div>
                            <!-- /.widget-body -->
                        </div>
                        <!-- /.widget-bg -->
                    </form>
<table id="" width="100%" class="  " data-toggle="datatables" data-plugin-options='{"searching": true}'>
                                        <?= $report ?>
                                    </table>
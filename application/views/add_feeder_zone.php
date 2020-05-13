
                                <!-- <h5 class="box-title mr-b-0">Horizontal Form</h5>
                                <p class="text-muted">All bootstrap element classies</p> -->
            <?php echo validation_errors('<div class="alert alert-danger mb-2">','</div>'); ?>
                     
                          <form id="add_feeder_zone" action="" method="POST">
                            <div class="card">
                              <div class="card-header">
                                <h4>Add Feeder to Zone</h4>
                              </div>
                              <div class="card-body">
           
                      
              
                <div class="row">
                   
               
                <div class="col-md-2">
              
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
                <div class="col-md-2">
              
              <label class="col-form-label" for=""> Choose Sub Zone</label>
              <select class="form-control " id="sub_zone" name="sub_zone_id" >
               <option value="">Choose Sub Zone</option>
               <?php
                foreach ($sub_zones as $key => $value) {
                  ?>
                  <option value="<?= $value->id ?>"><?= $value->name ?></option>
                  <?php
                }
               ?>
              </select>
                                    
              </div>
               <div class="col-md-3">
              
              <label class="col-form-label" for=""> Choose 33kv Feeder</label>
              
              <select class="form-control" name="feeder_id_33" id="feeder">
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
              <div class="col-md-3">
              
              <label class="col-form-label" for=""> Injection substation</label>
              
              <select class="form-control" name="iss_id" id="feeder">
                <option value="">Choose</option>
                <?php
                  foreach ($iss_data as $key => $iss) {
                    ?>
                    <option value="<?= $iss->id ?>"><?= $iss->iss_names ?></option>
                    <?php
                  }
                ?>
              </select>
                                    
              <?php echo form_error('feeder','<span style="color:red">','</span>'); ?>
              </div>
              <div class="col-md-2">
              
              <label class="col-form-label" for=""> Choose 11kv feeder</label>
              
              <select class="form-control  multiple-selector" multiple name="feeder_id_11[]" id="feeder">
                <option value="">Choose</option>
                <?php
                  foreach ($feeders_11 as $key => $feeder) {
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
<table class="table table-bordered" id="simpleTable">
  <thead>
    <th>Transmision station</th>
    <th>Transformer</th>
    <th>Feeders</th>
    
  </thead>
  <tbody>
    
  </tbody>
</table>
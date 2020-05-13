
                                <!-- <h5 class="box-title mr-b-0">Horizontal Form</h5>
                                <p class="text-muted">All bootstrap element classies</p> -->
            <?php echo validation_errors('<div class="alert alert-danger mb-2">','</div>'); ?>
                     
                          <form id="add_feeder" action="" method="POST">
                            <div class="card">
                              <div class="card-header">
                                <h4>Add 11kv Feeder</h4>
                              </div>
                              <div class="card-body">
           
                      
              
                <div class="row">
                    <div class="col-md-4">
              
              <label class="col-form-label" for=""> Choose Injection Substation</label>
              <input type="hidden" name="voltage_level" value="11kv">
              <select class="form-control" name="station_id" id="iss_transformer">
                <option value="">Choose</option>
                <?php
                  foreach ($iss_data as $key => $iss) {
                    ?>
                    <option value="<?= $iss->id ?>"><?= $iss->iss_names ?></option>
                    <?php
                  }
                ?>
              </select>
                                    
              <?php echo form_error('iss_id','<span style="color:red">','</span>'); ?>
              </div>
                <div class="col-md-4">
              
              <label class="col-form-label" for=""> Choose Transformer</label>
              <select class="form-control" id="transformer" name="transformer_id">
               
              </select>
                                    
              <?php echo form_error('transformer_id','<span style="color:red">','</span>'); ?>
              </div>

                <div class="col-md-4">
              
              <label class="col-form-label" for=""> Choose IBC</label>
              <select class="form-control" id="ibc" name="ibc">
               <option value="">Choose Ibc</option>
               <?php
                foreach ($ibc as $key => $value) {
                  ?>
                  <option value="<?= $value->id ?>"><?= $value->names ?></option>
                  <?php
                }
               ?>
              </select>
                                    
              
              </div>
              
              </div> 
             <button id="add_component" type="button" class="btn btn-primary  my-2"><span class="fa fa-plus"></span></button>
             <div id="container_div">
                <div class="row">
              <div class="col-md-12">
              <label class="col-form-label" for=""> Enter Feeder name</label>
              <input type="text" class="form-control feeder" name="feeder[]">
               </div>                     
             
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
    <th>Injection substation</th>
    <th>Transformer</th>
    <th>Feeders</th>
    
  </thead>
  <tbody>
    <?= $table ?>
  </tbody>
</table>
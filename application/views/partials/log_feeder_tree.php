<fieldset class="scheduler-border">
   <legend class="scheduler-border">Filter</legend>
   <?php 
    if ($user->role_id==8) {
      # user is dso
      ?>
       <div class="row">
            
      <div class="col-md-4 iss_log_div" id="" style="">
<label>Injection Substation</label>
<select class="form-control" name="iss_name" id="iss_name">
    <option value="">Injection Substation</option>
    <option value="<?= $station->id ?>"><?= $station->iss_names ?></option>
   
</select>
</div>
<div class="col-md-4 iss_log_div" id="" style="">

    <label>Power Transformer</label>
    <select class="form-control" name="transformer_iss" id="transformer_iss">
    <option value="">No Transformer data</option>
                
    </select>

                                                
</div>

 <input type="hidden" id="station_id" name="station_id" >
                    <input type="hidden" id="voltage_level" name="voltage_level">
      <?php
    } else {
      ?>

         <div class="d-flex justify-content-start">   
                                             
                                                 <div class="radiobox radio-info">
                                              <label class="custom-switch">
                                                  <input type="radio"  class="feeder_type_log custom-switch-input" name="asset_type" value="TS"> 
                                                  <span class="custom-switch-indicator"></span>
                                                  <span class="custom-switch-description"> 33KV FEEDER</span>
                                              </label>
                                              </div>
                                              
                                              
                                                <div class="radiobox radio-info">
                                              <label class="custom-switch">
                                                  <input type="radio" class="feeder_type_log custom-switch-input" name="asset_type" value="ISS">
                                                  <span class="custom-switch-indicator"></span>
                                                   <span class="custom-switch-description"> 11KV FEEDER</span>
                                              </label>
                                              </div>
                                              </div>
                                       
                                        
                                        <br/>

                                            <div class="row">
            
            
            <div class="col-md-4 ts_div_log" id="">

            <label> Transmission station</label>
                <select class="form-control" name="trans_st" id="trans_st">
                 <option value=""> Transmission Station</option>
                  <!--  -->
                        </select>

                     
                     <input type="hidden" id="station_id" name="station_id" >
                    <input type="hidden" id="voltage_level" name="voltage_level">
                    </div>
                        <div class="col-md-4 ts_div_log" id="">

                <label>Power Transformer</label>
                <select class="form-control" name="transformer" id="transformer_33">
                <option value="">No Transformer data</option>
                
                 </select>

                                                
                </div>
            
    <div class="col-md-4 iss_log_div" id="" style="display: none">
<label>Injection Substation</label>
<select class="form-control" name="iss_name" id="iss_name">
    <option value="">Injection Substation</option>
   
</select>
</div>
<div class="col-md-4 iss_log_div" id="" style="display: none">

    <label>Power Transformer</label>
    <select class="form-control" name="transformer_iss" id="transformer_iss">
    <option value="">No Transformer data</option>
                
    </select>

                                                
</div>

      <?php
    }
    
   ?>
                                  
                        
  
     <div class="col-md-2">
<!-- <input required class="form-control" style="color: #333" type="text" name="captured_date" id="captured_date" /> -->
<label>Date</label>
<input required class="form-control" style="color: #333" placeholder="Select date" type="text" name="captured_date" id="captured_date" />
</div>           
                                        
                                        <!-- <div class="col-md-1"></div> -->
                <div class="col-md-2">
                                           
                                                <!-- <input required class="form-control" style="color: #333" type="text" name="captured_date" id="captured_date" /> -->
            <label> Hour</label>
              <select required class="form-control" name="hour" id="hour">
                <option value=""> Hour</option>
                <?php
                    for ($i=0; $i <=23 ;$i++) {
                        ?>
                        <option 
                        value="<?= $i ?>"
                        
                            ><?= ($i==0)?'00':$i ?></option>
                        <?php
                    }
                ?>
            </select>
        </div>


</div>

</fieldset>
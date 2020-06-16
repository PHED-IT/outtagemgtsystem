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


      <?php
    }elseif ($user->role_id==35) {
      ?>
      <div class="row">
                <div id="spinner"></div>
             <div class="col-md-4 ts_div_log" id="">

                <label> Transmission station</label>
                <select class="form-control" name="trans_st" id="trans_st">
                 <option value=""> Transmission Station</option>
                 <option value="<?= $station->id ?>"><?= $station->tsname ?></option>
                </select>
                </div>
                  <div class="col-md-4 ts_div_log" id="">

                <label>Power Transformer</label>
                <select class="form-control" name="transformer" id="transformer_33">
                <option value="">No Transformer data</option>
                 </select>                                  
                </div>
      <?php

    } else {
      ?>

     <div class="d-flex justify-content-start">   
                                             
       <div class="radiobox radio-info">
    <label class="custom-switch">
        <input type="radio"  class="feeder_type_log custom-switch-input" name="asset_name" value="TS"> 
        <span class="custom-switch-indicator"></span>
        <span class="custom-switch-description"> 33KV FEEDER</span>
    </label>
    </div>
    
    
      <div class="radiobox radio-info">
    <label class="custom-switch">
        <input type="radio" class="feeder_type_log custom-switch-input" name="asset_name" value="ISS">
        <span class="custom-switch-indicator"></span>
         <span class="custom-switch-description"> 11KV FEEDER</span>
    </label>
    </div>
    </div>

                <br/>
               <div class="row">
                <div id="spinner"></div>
             <div class="col-md-4 ts_div_log" id="">

            <label> Transmission station</label>
                <select class="form-control" name="trans_st" id="trans_st">
                 <option value=""> Transmission Station</option>
                    <?php
                        foreach ($ts_data as $key => $value) {
                            ?>
                            <option 
                            value="<?= $value->id ?>"
                            
                                ><?= $value->tsname ?></option>
                            <?php
                        }
                    ?>
                        </select>

                     


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
    <?php
        foreach ($iss_data as $key => $value) {
            ?>
            <option 
            value="<?= $value->id ?>"
            
                ><?= $value->iss_names ?></option>
            <?php
        }
    ?>
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
<div class="col-md-4">
              
              <label class="" for="feeder_name"> Choose Feeder</label>
              <select class="form-control" name="feeder_id" id="feeder_name">
                                                    
             <option value="">Choose Feeder</option>
              </select>
                                      
             </div>
                                        <!-- <div class="col-md-1"></div> -->
                             
                                       
                </div>

              </fieldset>
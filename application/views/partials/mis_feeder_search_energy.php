<?php 
                        if (isset($search_params)) {
                          ?>
                          <button class="btn btn-outline-primary btn-sm" id="btn-show-section">Show Search Section</button>
                          <br/><br/>
                          <?php
                        }
                          ?>
<fieldset id="form-section" class="scheduler-border" style="<?= isset($search_params)?'display: none;':''; ?>">
   <legend class="scheduler-border">Filter</legend>

                          <form   action="" method="POST">

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

<?php } ?>
<div class="col-md-4">
              
              <label class="col-form-label" for="year_input"> Choose Feeder</label>
              <select class="form-control" name="feeder_name" id="feeder_name">
                                                    
              <?php
                 if (isset($search_params)) {
                $feeder_id=$search_params['feeder_id'];
                $feeder_name=$search_params['feeder_name'];
                echo "<option value='".$feeder_id."'>".$feeder_name."</option>";
                         } else {                                                        echo '<option value="">Choose Feeder</option>';       foreach ($feeders as $key => $value) {                                                       ?>
          <option value="<?= $value->feeder_name ?>" ><?= $value->feeder_name ?></option>                                                           <?php }    } ?>
              </select>
                                      
                                        </div>
                                        <!-- <div class="col-md-1"></div> -->
                                        <div class="col-md-3">
                                           
                                            <label class=" col-form-label"> Choose Date Type</label>
                                            <select class="form-control" name="dt" id="date_type">
                                                <option value="day" <?= isset($search_params)&&$search_params['dt']=="day"?'selected':'' ?>>Daily</option>
                                                <option <?= isset($search_params)&&$search_params['dt']=="month"?'selected':'' ?>  value="month">Monthly</option>
                                                
                                            </select>
                                               
                                        </div>
                <div class="col-md-4">
                
                <label class=" col-form-label" id="label_date" for="date_picker"> Choose day </label>
                  <?php
                if (isset($search_params)) {
                 // echo $search_params['date'];
                  if ($search_params['dt']=="day") {
                  ?>
              <input class="form-control captured_date" value="<?= isset($search_params)?$search_params['date']:'' ?>" style="color: #333" type="text" name="captured_daily_date" placeholder="Choose day" id="captured_date" />

                <input class="form-control date_picker" style="color: #333; display: none;" type="text" placeholder="Choose month" name="captured_month_date"  autocomplete="off" id="date_picker" />

                <?php
               } elseif($search_params['dt']=="month") {
                ?>
        <input class="form-control captured_date date_picker" value="<?= isset($search_params)?$search_params['date']:'' ?>" style="color: #333" type="text" name="captured_month_date"  autocomplete="off" id="date_picker" />

            <input class="form-control captured_date " style="color: #333;display: none;" type="text" name="captured_daily_date" id="captured_date" />
              <?php
              }

            }else{
              ?>
              <input class="form-control date_picker" style="color: #333; display: none;" type="text" name="captured_month_date"  autocomplete="off"  id="date_picker" />

              <input class="form-control " placeholder="Choose day" value="<?= isset($search_params)?$search_params['date']:'' ?>" style="color: #333" type="text" name="captured_daily_date" id="captured_date" />
                <?php
               }
                ?>
                 
                </div>
            <input type="hidden" value="energy" id="type">
              <input type="hidden" value="mis" id="page">
            <div class="col-md-4">
                                            
                <div class="form-group">
              <label></label>
              <div class=" ml-md-auto btn-list my-3">
               <button  class="btn btn-primary btn-rounded form-control" type="submit">Show Report</button>
                                                        
              </div>
                                                
                </div>
                </div>
                                       
                </div>
                                   
                                  
                  </form>
                          

                    
            
                    </fieldset>
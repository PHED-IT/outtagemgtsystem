
                                
                                <div style="overflow: auto;">
                               
                                <form action="" id="loadMytoInput" method="POST">
                                    <div id="loader_submit"></div>
                                    <div class="card">
                                        <div class="card-header">
                         <h4>LOAD MYTO INPUT</h4>
                                </div>
                                        <div class="card-body">
 <input type="hidden" id="logType" value="load" name="">
<div class="row">
    <div class="col-md-2">

<label>Date</label>
<input required class="form-control" style="color: #333" placeholder="Select date" type="text" name="captured_date" id="captured_date" />
</div>    
  <div class="col-md-4 ts_div_log" id="">

            <label> Transmission station</label>
         <select class="form-control" name="trans_st" id="trans_st">
                 <option value=""> Transmission Station</option>
                  <?php 
                    foreach ($ts_data as $key => $value) {
                        ?>
                        <option value="<?= $value->id ?>"><?= $value->tsname ?></option>
                        <?php
                    }
                  ?>
            </select>
                        <!-- this holds the id of the transmision or injection sub jection -->
         <input type="hidden" id="station_id" name="station_id" >
        <input type="hidden" id="voltage_level" name="voltage_level">
    </div>

     <div class="col-md-3 ts_div_log" id="">

                <label>Power Transformer</label>
                <select class="form-control" name="transformer" id="transformer_33">
                <option value="">No Transformer data</option>
                
                 </select>

                                                
                </div>

        <div class="col-md-3">
              
              <label class="col-form-label" for="year_input"> Choose Feeder</label>
              <select class="form-control" name="feeder" id="feeder_name">
                                                    
          <option value="" >Choose feeder</option>                                                      
              </select>
              <input type="hidden" id="load_analysis" value="true" name="" >
              <input type="hidden" id="log_new" value="log_new" name="log_new" >
                   <input type="hidden" id="isIncommer" name="isIncommer">                   
        </div>

    </div>


<p class="my-2" id="latest_entry" style="font-weight: bold;"></p>

<table class="my-3 table table-striped table-responsive" width="100%">
<thead style="background-color:#278acd;color:white">
<tr>
<th style="color: #fff">HOUR</th>

<th style="color: #fff">MYTO ALLOCATION (MW)</th>
<th style="color: #fff">MYTO ALLOCATION (A)</th>
<th style="color: #fff"> CONSUMPTION FROM EMBEDED  (MW)</th>

<th style="color: #fff"> FORECASTED LOAD  (MW)</th>


</tr>
</thead>
<tbody >
    <?php
        for ($i=0; $i <24 ; $i++) { 
            ?>
            <tr>
                <th style="background-color: #d0d0d0"><?= $i.'.00' ?><input type="hidden" name="hour[]" value="<?= $i ?>"></th>
               
                <td><input name='myto_allocaton_mw[]' style="width: 100%" autocomplete='off' value='277.97' class='log_input myto_allocaton_mw st_input' placeholder='0.00' /></td>
                <td><input style="width: 100%" name='myto_allocaton_a[]' tabindex="<?= $i +1 ?>" autocomplete='off' class='log_input myto_allocaton_a st_input' placeholder='0.00' /></td>
                <td><input style="width: 100%" name='consumption_embeded[]' autocomplete='off' class='log_input consumption_embeded st_input' placeholder='0.00' /></td>
                <td><input style="width: 100%" name='forecasted_load[]' autocomplete='off' class='log_input forecasted_load st_input' placeholder='0.00' /></td>
               
                
               
            </tr>
            <?php
        }
    ?>
    
</tbody>

</table>
<hr/>
                                 
<div class="form-actions" style="display: none;" id="button-container">
    <div class="form-group ">
        <div class="">
            <button id="btn" class="btn btn-primary btn-rounded" type="submit">Submit</button>
            
        </div>
    </div>
</div>
</div>
</form>
</div>


                            
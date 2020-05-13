
                                
                                <div style="overflow: auto;">
                               
                                <form action="" id="logFormNew" method="POST">
                                    <div id="loader_submit"></div>
                                    <div class="card">
                                        <div class="card-header">
                         <h4>Log Entry</h4>
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
              <input type="hidden" id="log_new" value="log_new" name="log_new" >
                   <input type="hidden" id="isIncommer" name="isIncommer">                   
        </div>

    </div>


<p class="my-2" id="latest_entry" style="font-weight: bold;"></p>

<table class="my-3 table table-striped table-responsive" >
<thead>
<tr>
<th>Hour</th>
<th>Status</th>
<th>Voltage(KV)</th>
<th>Current(AMP)</th>
<th>Power factor(PF)</th>


<th>Frequency(F)</th>
<th>Load(MW)</th>
<th>Load(KVAR)</th>
<th>Remarks(optional)</th>

</tr>
</thead>
<tbody >
    <?php
        for ($i=0; $i <24 ; $i++) { 
            ?>
            <tr>
                <td><?= $i.'.00' ?><input type="hidden" name="hour[]" value="<?= $i ?>"></td>
                <td><select class='status_feeder' name='status[]'>
                 <option value='on'>On</option>
                  <option value='EF'>EF</option>
                <option value='OC'>OC</option>
                <option value='IMB'>IMB</option>
                <option value='LS'>LS</option>
                <option value='LS'>LSG</option>
                <option value='SG'>SG</option>
                <option value='OUT'>OUT</option>
                <option value='BF'>BF</option>
                <option value='NS'>NS</option>
                <option value='OFF'>OFF</option>
                <option value='EMG'>EMG</option>
                <option value='SS'>SS</option>
                <option value='RF'>RF</option>
                <option value='DCF'>DCF</option>
                </select></td>
                <td><input name='voltage[]' autocomplete='off' value='33' class='reading_input log_input voltage st_input' placeholder='0.00' /></td>
                <td><input name='current[]' tabindex="<?= $i +1 ?>" autocomplete='off' class='reading_input log_input current st_input' placeholder='0.00' /></td>
                <td><input name='pf[]' autocomplete='off' value='0.8' class='pf_input log_input st_input' placeholder='0.00' /></td>
                
               
                
                <td><input name='frequency[]' autocomplete='off' value='50' class='reading_input log_input st_input frequency' placeholder='0.00' /></td>
                <td><input name='loadmw' autocomplete='off' class='reading_input log_input loadmw st_input' readonly placeholder='0.00' /></td>
                 <td><input name='load_mvr[]' autocomplete='off' value='0.00' class='reading_input log_input loadmvr st_input' readonly  placeholder='0.00' /></td>
                <td><input name='remarks[]' autocomplete='off' class='remarks' placeholder=''  /></td>
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
            <button id="btn" class="btn btn-primary btn-rounded" type="submit">Log</button>
            
        </div>
    </div>
</div>
</div>
</form>
</div>


                            
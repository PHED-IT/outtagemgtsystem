
                                <form action="" id="energyLogForm" method="POST">
                                     <input type="hidden" id="logType" value="energy" name="logType">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Energy Log Sheet</h4>
                                    </div>
                                    <div class="card-body">
                                <?php echo validation_errors('<div class="alert alert-danger mb-2">','</div>'); ?>
                                
                        <?php $this->load->view('partials/log_feeder_tree'); ?>
                                    <p class="my-2" id="latest_entry" style="font-weight: bold;"></p>
    <table class="my-3 table table-striped " >
                                        <thead style="width: 100%">
                                            <tr>
                                                <th>Feeder</th>
                                                <th>Reading</th>
                                                
                                                <th>Remarks(optional)</th>
                                                
                                            </tr>
                                        </thead>
<tbody id="tbody">
<?php
if (isset($feeders)) {
if ($user->voltage_level=="TS") {
foreach ($feeders as $key => $feeder) {
?>
<tr>
   <td>
    <?= $feeder->feeder_name ?>
    <input type='hidden' value='<?= $feeder->feeder_name ?>' name='feeders[]'/>    
    </td>
    <td>
        <input name='readings[]' type='text' class='form-control' />
    </td>
    <td><input name='remarks[]' type='text' class='form-control' /></td>
</tr>
<?php
}
} else {
foreach ($feeders as $key => $feeder) {
?>
<tr>
   <td>
    <?= $feeder->feeder_name_11 ?>
    <input type='hidden' value='<?= $feeder->feeder_name_11 ?>' name='feeders[]'/>    
    </td>
    <td>
        <input name='readings[]' type='text' class='form-control' />
    </td>
    <td><input name='remarks[]' type='text' class='form-control' /></td>
</tr>
<?php
}
}


}
?>
<!-- <td>
<h4 >No IBC chosen</h4>
</td> -->

<!--  <script id="feeder_temp" type="template">
<tr>
<td>{{feeder_name}}</td>
<td><input type="text" name="readings[]" /></td>

</tr>
</script> -->
</tbody>

</table>
                                    <hr/>
                                    <!--  <div class="form-group row">
                                            <label class="col-md-3 col-form-label" for="captured_date"> Remarks</label>
                                            <div class="col-md-9">
                                               <textarea class="form-control" placeholder="Optional" name="remarks" cols="4"></textarea>
                                            </div>
                                            
                                            </div> -->
                                    <div class="form-actions" style="display: none;" id="button-container">
                                        <div class="form-group ">
                                            <div class="">
                                                <button id="btn" class="btn btn-primary btn-rounded" type="submit">Log</button>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            


                            <!-- this is section for summary -->
                            



                                <!-- <h5 class="box-title mr-b-0">Horizontal Form</h5>
                                <p class="text-muted">All bootstrap element classies</p> -->
                               <!-- <div class="alert alert-info">
                                    Choose TS or ISS
                                </div> -->
                                
                                <div style="overflow: auto;">
                                <?php echo validation_errors('<div class="alert alert-danger mb-2">','</div>'); ?>
                                <form action="" id="logForm" method="POST">
                                    <div id="loader_submit"></div>
                                    <div class="card">
                                        <div class="card-header">
                         <h4>Log Entry</h4>
                                </div>
                                        <div class="card-body">
 <input type="hidden" id="logType" value="load" name="">
 <?php $this->load->view('partials/log_feeder_tree'); ?>
<p class="my-2" id="latest_entry" style="font-weight: bold;"></p>

<table class="my-3 table table-striped table-responsive" style="background-color:#278acd;color:white">
<thead>
<tr>
<th style="color: #fff">Feeder</th>
<th style="color: #fff">Status</th>
<th style="color: #fff">Voltage(KV)</th>
<th style="color: #fff">Current(AMP)</th>
<th style="color: #fff">Power factor(PF)</th>


<th style="color: #fff">Frequency(F)</th>
<th style="color: #fff">Load(MW)</th>
<th style="color: #fff">Load(KVAR)</th>
<th style="color: #fff">Remarks(optional)</th>

</tr>
</thead>
<tbody id="tbody">
<?php
if (isset($feeders)) {
if ($user->station_type=="TS") {
    foreach ($feeders as $key => $feeder) {
   ?>
   <tr>
       <td>
        <?= $feeder->feeder_name ?>
        <input type='hidden' value='<?= $feeder->feeder_name ?>' name='feeders[]'/>                                                             </td>
    <td>                                                           <input name='readings[]' type='text' class='form-control' />
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
                                </div>
                                </form>
                            </div>


                            
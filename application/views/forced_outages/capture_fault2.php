<br/>


            <div class="widget-list">
                <div class="col-md-8 mx-auto widget-holder">
                    <div class="widget-bg">
                        <div class="widget-body clearfix">
                           
                             <h5 class="box-title mr-b-0"><?= $title ?></h5>
                           <!-- <p class="text-muted">All bootstrap element classies</p> -->
                           <!-- <div class="alert alert-info">
                                Choose TS or ISS
                            </div> -->
                           
                            <div style="">
                            
                                        
                            <form action="" method="POST">
                                <div class="row">
                                     <?php
                                        if ($user->role_name=="admin") {
                                            //user is an admin
                                            ?>
                                            
                                            <div class="col-md-12 d-flex flex-row justify-content-between">
                                              <div>
                                                <div class="radiobox radio-info">
                                              <label>
                                                  <input type="radio" class="capture_type" checked name="asset_type" value="ISS"> <span class="label-text ">ISS</span>
                                              </label>
                                              </div>
                                              </div>
                                              <div>
                                                <div class="radiobox radio-info">
                                              <label>
                                                  <input type="radio" class="capture_type" name="asset_type" value="TS"> <span class="label-text">TS</span>
                                              </label>
                                              </div>
                                              </div>
                                              <div>
                                                <div class="radiobox radio-info">
                                              <label>
                                                  <input type="radio" class="capture_type" name="asset_type" value="feeder_11"> <span class="label-text ">FEEDER 11KV</span>
                                              </label>
                                              </div>
                                              </div>
                                              <div>
                                                 <div class="radiobox radio-info">
                                              <label>
                                                  <input type="radio" class="capture_type" name="asset_type" value="feeder_33"> <span class="label-text">FEEDER 33KV</span>
                                              </label>
                                              </div>
                                              </div>
                                             <div>
                                               <div class="radiobox radio-info">
                                              <label>
                                                  <input type="radio" class="capture_type" name="asset_type" value="dtr"> <span class="label-text ">DTR</span>
                                              </label>
                                              </div>
                                             </div>
                                              
                                       
                                    </div>
                                    
                                            <?php
                                        }else{
                                            //user is not admin
                                            ?>
                                            <div class="col-md-8">
                                            	<input type="hidden" value="<?= $user->station_name ?>" name="station_id">
                                       			<input type="hidden" name="station_type" value="<?= $user->station_type ?>">
                                                <p class="text text-info">
                                                    <strong>
                                                        <?php
                                                            if ($user->station_type=="TS") {
                                                                echo "Transmission Station: ".$station->tsname;
                                                            } else {
                                                               echo "ISS: ".$station->ISS;

                                                            }
                                                            
                                                        ?>
                                                    
                                                    </strong>
                                                </p>
                                            </div>
                                            <?php
                                        }
                                
                                    ?>     
                                </div>
                                <br/>
                                <div class="form-group ">
                                    <label class="col-form-label" > Search </label>
                                    
                                        <input type="text" required placeholder="Search ISS" value="<?= isset($tripping) ? $tripping->asset_name:set_value('asset_name'); ?>" name="asset_name" class="form-control asset_name">

                                    
                                    <?php echo form_error('asset_name','<span style="color:red">','</span>'); ?>
                                </div>
                                <input type="hidden" id="asset_id" name="asset_id">
                                <div class="form-group">
                                    <label class=" col-form-label" for="fault"> Faults</label>
                                    
                                        <select name="fault" class="form-control" >
                                        	<?php
                                              foreach ($faults as $key => $fault) {
                                             ?>
                                               <option 
                                               <?php
                                                    if (isset($tripping)) {
                                                       if ($fault->id==$tripping->fault_id) {
                                                           echo ' selected';
                                                       }
                                                    }
                                                ?>
                                                     value="<?= $fault->id ?>">
                                               	<?= $fault->name ?>
                                               </option>
                                                   
                                             <?php
                                               }
                                                
                                        ?>
                                        </select>
                                    
                                    <?php echo form_error('fault','<span style="color:red">','</span>'); ?>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label" for="time"> Time</label>
                                    
                                        <input required placeholder="Choose time" class="form-control" style="color: #333" type="text" value="<?= isset($tripping) ? $tripping->time_fault:set_value('time_fault'); ?>" name="time" id="captured_date" />
                                    
                                    <?php echo form_error('time','<span style="color:red">','</span>'); ?>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label" for="remark"> Remark/ Detail cause of fault</label>
                                    
                                        <textarea cols="3" name="remark" class="form-control"><?= isset($tripping) ? $tripping->remark:set_value('remark'); ?></textarea>
                                    
                                    <?php echo form_error('remark','<span style="color:red">','</span>'); ?>
                                </div>
                                
                                
                                <!--  <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="captured_date"> Remarks</label>
                                        <div class="col-md-9">
                                           <textarea class="form-control" placeholder="Optional" name="remarks" cols="4"></textarea>
                                        </div>
                                        
                                        </div> -->
                                <div class="form-actions"  id="button-containers">
                                    <div class="form-group row">
                                            <button id="btn" class="btn btn-primary btn-rounded" type="submit"><?= isset($tripping) ? 'Edit':"Submit"; ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>


                        <!-- this is section for summary -->
                        </div>
                        <!-- /.widget-body -->
                    </div>
                    <!-- /.widget-bg -->
                </div>
            </div>
            <hr/>
            <div class="widget-list">
              <div class="row">
              <div class="col-md-12 widget-holder">
                      <h5 class="box-title mr-b-0">Opened Trippings</h5>
                       <table class="table table-striped table-responsive" data-toggle="datatables" data-plugin-options='{"searching": true}'>
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Fault</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Remark</th>
                                            <th></th>                             
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    //var_dump($roles);
                                        foreach ($trippings as $tripping) {
                                            ?>
                                            <tr>
                                                <td><?= $tripping->asset_name; ?></td>
                                                <td><?= $tripping->name; ?></td>
                                                <td><?= date("D-M-Y",strtotime($tripping->created_at)); ?></td>
                                                <td><?= $tripping->time_fault; ?></td>
                                                <td><?= $tripping->remark; ?></td>
                                                <td>
                                                   <?php
                                                    if (!$tripping->allocated) {
                                                        ?>
                                                        <a href="<?= base_url('tripping/edit_fault').'/'.$tripping->tripping_id ?>" class="btn btn-xs  btn-info">Edit</a>
                                                        <?php
                                                    }
                                                    
                                                ?> 
                                                </td>                        
                                            </tr>
                                            <?php
                                        }
                                    ?>
                                    </tbody>
                                   
                                </table>

              </div>
            </div>
            </div>
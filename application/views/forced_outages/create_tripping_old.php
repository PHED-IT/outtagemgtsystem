<div class="row page-title clearfix">
                <div class="page-title-left">
                    <h6 class="page-title-heading mr-0 mr-r-5"><?= isset($tripping) ? 'Edit tripping':'Create tripping'; ?></h6>
                    <!-- <p class="page-title-description mr-0 d-none d-md-inline-block">statistics, charts and events</p> -->
                </div>
                <!-- /.page-title-left -->
                <div class="page-title-right d-none d-sm-inline-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active"><?= isset($tripping) ? 'Edit tripping':'Create tripping'; ?></li>
                    </ol>
                </div>
                <!-- /.page-title-right -->
            </div>


            <div class="widget-list">
                <div class="row">
                    <div class="col-md-12 widget-holder">
                        <div class="widget-bg">
                            <div class="widget-body clearfix">
                               
                                <!-- <h5 class="box-title mr-b-0">Horizontal Form</h5>
                                <p class="text-muted">All bootstrap element classies</p> -->
                               <!-- <div class="alert alert-info">
                                    Choose TS or ISS
                                </div> -->
                               
                                <div style="">
                                <?php echo validation_errors('<div class="alert alert-danger mb-2">','</div>'); ?>
                                <?php
                                    if ($user->role_name=="admin") {
                                        //user is an admin
                                 ?>
                                 <div class="alert alert-info">Choose ISS or Transmission station</div>
                                   <?php } ?>             
                                <form action="" method="POST">
                                    <div class="row">
                                         <?php
                                            if ($user->role_name=="admin") {
                                                //user is an admin
                                                ?>
                                                
                                                <div class="col-md-6">
                                                	<div class="form-group">
                                                		 <select class="form-control" name="iss_name" id="iss_name">
                                                    <option value="">Choose iss</option>
                                                    <?php
                                                        foreach ($iss_data as $key => $value) {
                                                            ?>
                                                            <option 
                                                            value="<?= $value->ISS_ID ?>"
                                                            
                                                                ><?= $value->ISS ?></option>
                                                            <?php
                                                        }
                                                    ?>
                                                </select>
                                                	</div>
                                           
                                        </div>
                                        <div></div>
                                        <div class="col-md-6">
                                           
                                               <div class="form-group">
                                               	<select class="form-control" name="trans_st" id="trans_st">
                                                    <option value="">Choose Ts</option>
                                                    <?php
                                                        foreach ($ts_data as $key => $value) {
                                                            ?>
                                                            <option 
                                                            value="<?= $value->tsid ?>"
                                                            
                                                                ><?= $value->tsname ?></option>
                                                            <?php
                                                        }
                                                    ?>
                                                </select>
                                               </div>

                                                <input type="hidden" id="station_id" name="station_id" >
                                                <input type="hidden" id="station_type" name="station_type">
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
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="feeder"> Feeders</label>
                                        <div class="col-md-9">
                                            <select name="feeder" id="feeder_sel" class="form-control">
                                            	<?php
                                                if (isset($feeders)) {
                                                    if ($user->station_type=="TS") {
                                                        foreach ($feeders as $key => $feeder) {
                                                       ?>
                                                       <option <?php
                                                            if (isset($tripping)) {
                                                               if ($feeder->feeder_id==$tripping->feeder_id) {
                                                                   echo ' selected';
                                                               }
                                                            }
                                                        ?> value="<?= $feeder->feeder_id ?>">
                                                       	<?= $feeder->feeder_name ?>
                                                       </option>
                                                       
                                                       <?php
                                                   }
                                                    } elseif($user->station_type=="ISS") {
                                                        foreach ($feeders as $key => $feeder) {
                                                       ?>
                                                      <option
                                                      	<?php
                                                            if (isset($tripping)) {
                                                               if ($feeder->feeder_id_11==$tripping->feeder_id) {
                                                                   echo ' selected';
                                                               }
                                                            }
                                                        ?>
                                                       value="<?= $feeder->feeder_id_11 ?>">
                                                       	<?= $feeder->feeder_name_11 ?>
                                                       </option>
                                                       <?php
                                                   }
                                                    }
                                                    
                                                   
                                                }
                                            ?>
                                            </select>
                                        </div>
                                        <?php echo form_error('feeder','<span style="color:red">','</span>'); ?>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="fault"> Faults/ Power Interruption cause</label>
                                        <div class="col-md-9">
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
                                        </div>
                                        <?php echo form_error('fault','<span style="color:red">','</span>'); ?>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="time"> Time</label>
                                        <div class="col-md-9">
                                            <input required placeholder="Choose time" class="form-control" style="color: #333" type="text" value="<?= isset($tripping) ? $tripping->time_fault:set_value('time_fault'); ?>" name="time" id="captured_date" />
                                        </div>
                                        <?php echo form_error('time','<span style="color:red">','</span>'); ?>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="remark"> Remark/ Detail cause of fault</label>
                                        <div class="col-md-9">
                                            <textarea cols="3" name="remark" class="form-control"><?= isset($tripping) ? $tripping->remark:set_value('remark'); ?></textarea>
                                        </div>
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
                                            <div class="col-md-9 ml-md-auto btn-list">
                                                <button id="btn" class="btn btn-primary btn-rounded" type="submit"><?= isset($tripping) ? 'Edit':"Submit"; ?></button>
                                                
                                            </div>
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
            </div>
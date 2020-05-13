<div class="row page-title clearfix">
               
                <!-- /.page-title-left -->
                <div class="page-title-right d-none d-sm-inline-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Planned Outage By IBC</li>
                    </ol>
                </div>
                <!-- /.page-title-right -->
            </div>

           
            <div class="widget-list">
              <div class="row">
              <div class="col-md-12 widget-holder">
                <div class="d-flex justify-content-between">
                  <div>
                    <h5 class="box-title mr-b-0">Open Faults</h5>
                  </div>
                  <div>
                    <button class="btn btn-sm btn-outline-primary " data-toggle="modal" data-target="#faultModal"><i class="fa fa-plus"></i> Capture</button>
                  </div>
                </div>
                      
                <?php echo validation_errors('<div class="alert alert-danger mb-2">','</div>'); ?>

                  <div id="faultModal" role="dialog" class="modal fade"  >
                                <div class="modal-dialog" >
                                  <form action="" method="POST">
                                    
                                <div class="modal-content">
                                 <div class="modal-header"><!-- 
                                   <h5 class="modal-title">Fault</h5> -->
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

                                 </div>
                                
                                <div class="modal-body"> 
                                   
                                <div class="row">
                                     
                                            
                                            <div class="col-md-12 d-flex flex-row justify-content-between">
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
                                                  <input type="radio" class="capture_type" checked name="asset_type" value="ISS"> <span class="label-text text-uppercase">Injection Substation</span>
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
                                             <!-- 
                                             <div>
                                               <div class="radiobox radio-info">
                                              <label>
                                                  <input type="radio" class="capture_type" name="asset_type" value="dtr"> <span class="label-text ">DTR</span>
                                              </label>
                                              </div>
                                             </div> -->
                                              
                                       
                                    </div>
                                      
                                </div>
                                <br/>
                                
                                        <div class="form-group ">
                                    <label class="col-form-label" > Search </label>
                                    
                                        <input type="text" required placeholder="Search ISS" value="<?= isset($tripping) ? $tripping->asset_name:set_value('asset_name'); ?>" name="asset_name" class="form-control asset_name">
                                    <?php echo form_error('asset_name','<span style="color:red">','</span>'); ?>
                                        </div>
                                      
                                    
                                    <div id="iss_section">
                                        <input type="hidden" id="asset_id" name="asset_id">
                                <div class="form-group">
                                    <label class=" col-form-label" for="component"> Component</label>
                                    
                                        <select name="component_id" id="component" class="form-control" >
                                          <option value="">Choose component</option>
                                          <?php
                                              foreach ($components as $key => $component) {
                                             ?>

                                               <option 
                                               <?php
                                                    if (isset($tripping)) {
                                                       if ($component->id==$tripping->component_d) {
                                                           echo ' selected';
                                                       }
                                                    }
                                                ?>
                                                     value="<?= $component->id ?>">
                                                <?= $component->name ?>
                                               </option>
                                                   
                                             <?php
                                               }
                                                
                                        ?>
                                        </select>
                                     
                                    <?php echo form_error('component','<span style="color:red">','</span>'); ?>
                                </div>
                                     
                                <div class="form-group">
                                    <label class=" col-form-label" for="fault"> Fault Indicators</label>
                                    
                                        <select name="fault_ind_iss" id="fault" class="form-control" >
                                         
                                        </select>
                                    
                                    <?php echo form_error('fault','<span style="color:red">','</span>'); ?>
                                </div>
                              </div>
                                      
                                      <div class="form-group">  
                                      <select name="fault_ind_feeder" style="display: none !important;" class="form-control fault-section">
                                          <option value="">Fault indicators</option>
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
                                                <?= $fault->indicator ?>
                                               </option>
                                                   
                                             <?php
                                               }
                                                
                                        ?>
                                        </select>
                                    
                                    <?php echo form_error('fault','<span style="color:red">','</span>'); ?>
                                </div>
                                   
                                <div class="form-group">
                                    <label class="col-form-label" for="time"> Date</label>
                                    
                                        <input required placeholder="Choose date" class="form-control" style="color: #333" type="text" value="<?= isset($tripping) ? $tripping->date_fault:set_value('date_fault'); ?>" name="date_fault" id="captured_date_time" />
                                    
                                    <?php echo form_error('date_fault','<span style="color:red">','</span>'); ?>
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
                                
                            
                                </div>
                                <div class="modal-footer">
                                     <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Go back</button>
                                     <button id="btn" class="btn btn-primary btn-rounded" type="submit"><?= isset($tripping) ? 'Edit':"Submit"; ?></button>
                                </div>
                                </div>
                              </form>
                                </div>
                                </div>

                      
                       <table class="table table-striped table-bordered table-responsive" data-toggle="datatables" data-plugin-options='{"searching": true}'>
                                    <thead>
                                        <tr>
                                            <th>Asset</th>
                                            <th>Component</th>
                                            <th>Fault Indicators</th>
                                            <th>Date</th>
                                            <th>Remark</th>
                                            <th></th>                             
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        foreach ($trippings as $tripping) {
                                            ?>
                                            <tr>
                                                <td><?= $tripping->asset_name; ?></td>
                                                <td><?= $tripping->component_name; ?></td>
                                                <td><?= $tripping->indicator; ?></td>
                                                <td><?= date("d-M-Y h:i a",strtotime($tripping->date_fault)); ?></td>
                                                
                                                <td><?= $tripping->remark; ?></td>
                                                <td>
                                                   <?php
                                                    if (!$tripping->allocated) {
                                                        ?>
                                                        <a href="#" class="btn btn-xs btn-info">Edit</a>
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
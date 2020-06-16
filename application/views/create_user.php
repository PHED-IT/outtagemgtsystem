
                        <div class="card">
                            <div class="card-header">
                                <h4>Edit user</h4>
                            </div>
                            <div class="card-body ">
                                <!-- <h5 class="box-title mr-b-0">Horizontal Form</h5>
                                <p class="text-muted">All bootstrap element classies</p> -->

                                <form action="" method="POST">
                                    <div class="row">
                                    <div class="col-md-4 ">
                                        <label class=" col-form-label" for="staff_id"> Staff Id</label>
                                      
                                            <input class="form-control" value="<?= isset($user) ? $user->staff_id:set_value('staff_id'); ?>" name="staff_id" id="staff_id" placeholder="Staff Id" type="text">
                                   
                                        <?php echo form_error('staff_id','<span style="color:red">','</span>'); ?>
                                    </div>
                                    <div class="col-md-4 ">
                                        <label class=" col-form-label" for="first_name"> First name</label>
                                      
                                            <input class="form-control" value="<?= isset($user) ? $user->first_name:set_value('first_name'); ?>" name="first_name" id="first_name" placeholder="First name" type="text">
                                   
                                        <?php echo form_error('first_name','<span style="color:red">','</span>'); ?>
                                    </div>

                                     <div class="col-md-4">
                                        <label class=" col-form-label" for="last_name"> Last name</label>
                                     
                                            <input class="form-control" value="<?= isset($user) ? $user->last_name:set_value('last_name'); ?>" name="last_name" id="last_name" placeholder="Last name" type="text">
                                      
                                        <?php echo form_error('last_name','<span style="color:red">','</span>'); ?>
                                    </div>
                                </div>
                                <div class="row">
                                     <div class="col-md-6">
                                        <label class="col-form-label" for="email"> Email</label>
                                       
                                            <input class="form-control" value="<?= isset($user) ? $user->email:set_value('email'); ?>" name="email" id="email" placeholder="Email" type="email">
                                        
                                        <?php echo form_error('email','<span style="color:red">','</span>'); ?>
                                    </div>

                                     <div class="col-md-6">
                                        <label class=" col-form-label" for="phone"> Phone</label>
                                        
                                            <input class="form-control" value="<?= isset($user) ? $user->phone:set_value('phone'); ?>" name="phone" id="phone" placeholder="Phone number" type="text">
                                        
                                        <?php echo form_error('phone','<span style="color:red">','</span>'); ?>
                                    </div>
                                </div>
                                   <div class="row">
                                     <div class="col-md-4">
                                        <label class="col-form-label" for="role">  Role</label>
                                 
                                            <select class="form-control" name="role" required id="role">
                                                <?php
                                                    foreach ($roles as $key => $role) {
                                                        ?>
                                                        <option 
                                                        value="<?= $role->id ?>"
                                                        <?php
                                                            if (isset($user)) {
                                                               if ($role->id==$user->role_id) {
                                                                   echo ' selected';
                                                               }
                                                            }
                                                        ?>
                                                            ><?= $role->role_name ?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                      
                                        <?php echo form_error('role','<span style="color:red">','</span>'); ?>
                                    </div>
                                         <div class="col-md-4">
                                        <label class="col-form-label" for="role">  Zones</label>
                                 
                                            <select class="form-control" name="zone_id" id="zone_id">
                                                <option value="">Choose zone</option>
                                                <?php
                                                    foreach ($zones as $key => $value) {
                                                        ?>
                                                        <option 
                                                        value="<?= $value->id ?>"
                                                        <?php
                                                            if (isset($user)) {
                                                               if ($value->id==$user->zone_id) {
                                                                   echo ' selected';
                                                               }
                                                            }
                                                        ?>
                                                            ><?= $value->name ?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                      
                                        <?php echo form_error('zone_id','<span style="color:red">','</span>'); ?>
                                    </div>
                                       <div class="col-md-4" id="iss_div" style="<?= empty($user->iss)?'display: none':''; ?>">
                                          <label class="col-form-label" for="iss">  Injection substation(DSO)</label>
                                 
                                            <select class="form-control" name="iss" id="iss">
                                                <option value="">Choose ISS</option>
                                                <?php
                                                    foreach ($iss_data as $key => $value) {
                                                        ?>
                                                        <option 
                                                        value="<?= $value->id ?>"
                                                        <?php
                                                            if (isset($user)) {
                                                               if ($value->id==$user->iss) {
                                                                   echo ' selected';
                                                               }
                                                            }
                                                        ?>
                                                            ><?= $value->iss_names ?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                      
                                        <?php echo form_error('iss','<span style="color:red">','</span>'); ?>
                                    </div>
                                       <div class="col-md-4" id="33kv_div" style="<?= empty($user->feeder33kv_id)?'display: none':''; ?>">
                                          <label class="col-form-label" for="iss">  33kv Feeder(Feeder Managers)</label>
                                 
                                            <select class="form-control" id="33kv_feeder" name="33kv_feeder">
                                                <option value="">Choose 33kv Feeder</option>
                                                <?php
                                                    foreach ($feeders_33 as $key => $value) {
                                                        ?>
                                                        <option 
                                                        value="<?= $value->id ?>"
                                                        <?php
                                                            if (isset($user)) {
                                                               if ($value->id==$user->feeder33kv_id) {
                                                                   echo ' selected';
                                                               }
                                                            }
                                                        ?>
                                                            ><?= $value->feeder_name ?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                      
                                        <?php echo form_error('33kv_feeder','<span style="color:red">','</span>'); ?>
                                    </div>

                                    <div class="col-md-4" id="transmission_div" style="<?= empty($user->transmission_id)?'display: none':''; ?>">
                                          <label class="col-form-label" for="trans">  Transmission station</label>
                                 
                                            <select class="form-control" id="trans_station" name="trans_station">
                                                <option value="">Choose Transmission station</option>
                                                <?php
                                                    foreach ($transmissions as $key => $value) {
                                                        ?>
                                                        <option 
                                                        value="<?= $value->id ?>"
                                                        <?php
                                                            if (isset($user)) {
                                                               if ($value->id==$user->transmission_id) {
                                                                   echo ' selected';
                                                               }
                                                            }
                                                        ?>
                                                            ><?= $value->tsname ?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                      
                                        <?php echo form_error('trans_station','<span style="color:red">','</span>'); ?>
                                    </div>
                                </div>
                                
                                    <br/>
                                    <button  class="btn btn-success btn-rounded" type="submit"><?= isset($user) ? 'Update':'Submit'; ?></button>
                                     <a  class="btn btn-primary btn-rounded" href="<?= base_url('admin/view_users') ?>">Back</a>
                                </form>
                            </div>
                            <!-- /.widget-body -->
                        </div>
                        <!-- /.widget-bg -->
                   
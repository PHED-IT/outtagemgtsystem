
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
                                 
                                            <select class="form-control" name="role" id="role">
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
                                       <div class="col-md-4">
                                        <label class="col-form-label" for="role">  Sub zones</label>
                                 
                                            <select class="form-control" name="sub_zone_id" id="sub_zone_id">
                                                <option value="">Choose Sub zones</option>
                                                <?php
                                                    foreach ($sub_zones as $key => $value) {
                                                        ?>
                                                        <option 
                                                        value="<?= $value->id ?>"
                                                        <?php
                                                            if (isset($user)) {
                                                               if ($value->id==$user->sub_zone_id) {
                                                                   echo ' selected';
                                                               }
                                                            }
                                                        ?>
                                                            ><?= $value->name ?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                      
                                        <?php echo form_error('sub_zone_id','<span style="color:red">','</span>'); ?>
                                    </div>
                                </div>
                                <div class="row">
                                         <div class="col-md-12">
                                        <label class="col-form-label" for="iss">  Injection substation(optional)</label>
                                 
                                            <select class="form-control" name="iss" id="iss">
                                                <option value="">Choose ISS(optional)</option>
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
                                    </div>
                                    <br/>
                                    <button  class="btn btn-success btn-rounded" type="submit"><?= isset($user) ? 'Edit':'Submit'; ?></button>
                                     <a  class="btn btn-primary btn-rounded" href="<?= base_url('admin/view_users') ?>">Back</a>
                                </form>
                            </div>
                            <!-- /.widget-body -->
                        </div>
                        <!-- /.widget-bg -->
                   
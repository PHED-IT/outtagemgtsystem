<div class="row page-title clearfix">
                <div class="page-title-left">
                    <h6 class="page-title-heading mr-0 mr-r-5"><?= isset($user) ? 'Edit user':'Create user'; ?></h6>
                    <!-- <p class="page-title-description mr-0 d-none d-md-inline-block">statistics, charts and events</p> -->
                </div>
                <!-- /.page-title-left -->
                <div class="page-title-right d-none d-sm-inline-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active"><?= isset($user) ? 'Edit user':'Create user'; ?></li>
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

                                <form action="" method="POST">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="first_name"> First name</label>
                                        <div class="col-md-9">
                                            <input class="form-control" value="<?= isset($user) ? $user->first_name:set_value('first_name'); ?>" name="first_name" id="first_name" placeholder="First name" type="text">
                                        </div>
                                        <?php echo form_error('first_name','<span style="color:red">','</span>'); ?>
                                    </div>

                                     <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="last_name"> Last name</label>
                                        <div class="col-md-9">
                                            <input class="form-control" value="<?= isset($user) ? $user->last_name:set_value('last_name'); ?>" name="last_name" id="last_name" placeholder="Last name" type="text">
                                        </div>
                                        <?php echo form_error('last_name','<span style="color:red">','</span>'); ?>
                                    </div>

                                     <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="email"> Email</label>
                                        <div class="col-md-9">
                                            <input class="form-control" value="<?= isset($user) ? $user->email:set_value('email'); ?>" name="email" id="email" placeholder="Email" type="email">
                                        </div>
                                        <?php echo form_error('email','<span style="color:red">','</span>'); ?>
                                    </div>

                                     <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="phone"> Phone</label>
                                        <div class="col-md-9">
                                            <input class="form-control" value="<?= isset($user) ? $user->phone:set_value('phone'); ?>" name="phone" id="phone" placeholder="Phone number" type="text">
                                        </div>
                                        <?php echo form_error('phone','<span style="color:red">','</span>'); ?>
                                    </div>

                                     <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="role"> Assign role</label>
                                        <div class="col-md-9">
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
                                        </div>
                                        <?php echo form_error('role','<span style="color:red">','</span>'); ?>
                                    </div>
                                    
                                    <div class="form-actions">
                                        <div class="form-group row">
                                            <div class="col-md-9 ml-md-auto btn-list">
                                                <button  class="btn btn-primary btn-rounded" type="submit"><?= isset($user) ? 'Edit':'Submit'; ?></button>
                                                <a href="<?= base_url('admin/view_users') ?>" class="btn btn-outline-default btn-rounded" type="button">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.widget-body -->
                        </div>
                        <!-- /.widget-bg -->
                    </div>

                </div>
            </div>
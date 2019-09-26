<div class="row page-title clearfix">
                <div class="page-title-left">
                    <h6 class="page-title-heading mr-0 mr-r-5"><?= isset($user) ? 'Edit user':'Asign Menu/Sub menu'; ?></h6>
                    <!-- <p class="page-title-description mr-0 d-none d-md-inline-block">statistics, charts and events</p> -->
                </div>
                <!-- /.page-title-left -->
                <div class="page-title-right d-none d-sm-inline-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active"><?= isset($user) ? 'Edit user':'Asign Menu'; ?></li>
                    </ol>
                </div>
                <!-- /.page-title-right -->
            </div>


            <div class="widget-list">
                <div class="row">
                    <div class="col-md-12 widget-holder">
                        <div class="widget-bg">
                            <div class="widget-body clearfix">
                                <h5 class="box-title mr-b-0">Asign menus</h5>
                               
                               
                                <form action="" method="POST">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="role_id"> Role</label>
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

                                     <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="menu"> Menu</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="menu" id="menu">
                                                <?php
                                                    foreach ($all_menus as $key => $menu) {
                                                        ?>
                                                        <option 
                                                        value="<?= $menu->id ?>"
                                                        <?php
                                                            if (isset($user)) {
                                                               if ($menu->id==$user->menu_id) {
                                                                   echo ' selected';
                                                               }
                                                            }
                                                        ?>
                                                            ><?= $menu->name_alias ?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <?php echo form_error('menu','<span style="color:red">','</span>'); ?>
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

<hr/>
            <div class="widget-list">
                <div class="row">
                    <div class="col-md-12 widget-holder">
                        <div class="widget-bg">
                            <div class="widget-body clearfix">
                                 <h5 class="box-title mr-b-0">Asign sub menus to menus</h5>
                                <!-- <p class="text-muted">All bootstrap element classies</p> --> 
                               
                                <form action="<?= base_url('admin/create_sub_menus') ?>" method="POST">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="choose_role"> Role</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="role_id" id="choose_role">
                                                <option value="">Choose role</option>
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
                                        <?php echo form_error('role_id','<span style="color:red">','</span>'); ?>
                                    </div>

                                     <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="menu_names"> Menu</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="menu_id" id="menu_names">
                                                
                                            </select>
                                        </div>
                                        <?php echo form_error('menu_id','<span style="color:red">','</span>'); ?>
                                    </div>

                                      <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="sub_menu"> Sub Menu</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="sub_menu" id="sub_menu">
                                                <?php
                                                    foreach ($sub_menus as $key => $sub_menu) {
                                                        ?>
                                                        <option 
                                                        value="<?= $sub_menu->id ?>"
                                                        <?php
                                                            if (isset($user)) {
                                                               if ($sub_menu->id==$user->sub_menu_id) {
                                                                   echo ' selected';
                                                               }
                                                            }
                                                        ?>
                                                            ><?= $sub_menu->name_alias ?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <?php echo form_error('sub_menu','<span style="color:red">','</span>'); ?>
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

         
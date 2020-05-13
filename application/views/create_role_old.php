<div class="row page-title clearfix">
                <div class="page-title-left">
                    <h6 class="page-title-heading mr-0 mr-r-5"><?= isset($role) ? 'Edit role':'Create role'; ?></h6>
                    <!-- <p class="page-title-description mr-0 d-none d-md-inline-block">statistics, charts and events</p> -->
                </div>
                <!-- /.page-title-left -->
                <div class="page-title-right d-none d-sm-inline-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active"><?= isset($role) ? 'Edit role':'Create role'; ?></li>
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
                                        <label class="col-md-3 col-form-label" for="role_name"> Role name</label>
                                        <div class="col-md-9">
                                            <input class="form-control" value="<?= isset($role) ? $role->role_name:set_value('role_name'); ?>" name="role_name" id="role_name" placeholder="Role name" type="text">
                                        </div>
                                        <?php echo form_error('role_name','<span style="color:red">','</span>'); ?>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="permission"> Permissions</label>
                                        <div class="col-md-9">
                                           <select class="form-control multiple-selector" name="permissions[]" multiple>
                                               <option
                                                <?php 
                                                    if (in_array('create', explode(",", $role->permissions))) {
                                                        echo "selected ";
                                                    }
                                                ?> value="create">Create</option>
                                               <option
                                                    <?php 
                                                    if (in_array('read', explode(",", $role->permissions))) {
                                                        echo "selected ";
                                                    }
                                                ?>
                                                value="read">Read</option>
                                               <option
                                                <?php 
                                                    if (in_array('update', explode(",", $role->permissions))) {
                                                        echo "selected ";
                                                    }
                                                ?>
                                                value="update">Update</option>
                                               <option
                                               <?php 
                                                    if (in_array('delete', explode(",", $role->permissions))) {
                                                        echo "selected ";
                                                    }
                                                ?>
                                                value="delete">Delete</option>
                                           </select>
                                        </div>
                                        <?php echo form_error('permission','<span style="color:red">','</span>'); ?>
                                    </div>
                                    <div class="form-actions">
                                        <div class="form-group row">
                                            <div class="col-md-9 ml-md-auto btn-list">
                                                <button  class="btn btn-primary btn-rounded" type="submit"><?= isset($role) ? 'Edit':'Submit'; ?></button>
                                                <a href="<?= base_url('admin/view_roles') ?>" class="btn btn-outline-default btn-rounded" type="button">Cancel</a>
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
<div class="row page-title clearfix">
                <div class="page-title-left">
                    <h6 class="page-title-heading mr-0 mr-r-5">Edit menu</h6>
                    <!-- <p class="page-title-description mr-0 d-none d-md-inline-block">statistics, charts and events</p> -->
                </div>
                <!-- /.page-title-left -->
                <div class="page-title-right d-none d-sm-inline-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Edit menu</li>
                    </ol>
                </div>
                <!-- /.page-title-right -->
            </div>


            <div class="widget-list">
                <div class="row">
                    <div class="col-md-12 widget-holder">
                        <div class="widget-bg">
                            <div class="widget-body clearfix">
                                <h5 class="box-title mr-b-0">Edit menus</h5>
                               
                               
                                <form action="" method="POST">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="role_id"> Role</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="role_id" id="role">
                                                <option value="<?= $data_role->id ?>"><?= $data_role->role_name ?></option>
                                                
                                            </select>
                                        </div>
                                        <?php echo form_error('role_id','<span style="color:red">','</span>'); ?>
                                    </div>

                                     <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="menu"> Menu</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="menu_id" id="menu">
                                                <?php
                                                    foreach ($all_menus as $key => $menu) {
                                                        ?>
                                                        <option 
                                                        value="<?= $menu->id ?>"
                                                        <?php
                                                            if (isset($data_menu)) {
                                                               if ($menu->id==$data_menu->id) {
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
                                                <button  class="btn btn-primary btn-rounded" type="submit">Edit</button>
                                                <a href="<?= base_url('admin/view_menus') ?>" class="btn btn-outline-default btn-rounded" type="button">Cancel</a>
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


         
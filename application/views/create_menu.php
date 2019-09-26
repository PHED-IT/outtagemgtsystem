<div class="row page-title clearfix">
                <div class="page-title-left">
                    <h6 class="page-title-heading mr-0 mr-r-5"><?= isset($menu) ? 'Edit menu':'Create menu'; ?></h6>
                    <!-- <p class="page-title-description mr-0 d-none d-md-inline-block">statistics, charts and events</p> -->
                </div>
                <!-- /.page-title-left -->
                <div class="page-title-right d-none d-sm-inline-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active"><?= isset($menu) ? 'Edit menu':'Create menu'; ?></li>
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
                                        <label class="col-md-3 col-form-label" for="menu"> menu name</label>
                                        <div class="col-md-9">
                                            <input class="form-control" value="<?= isset($menu) ? $menu->menu_name:set_value('menu_name'); ?>" name="menu_name" id="menu" placeholder="menu name" type="text">
                                        </div>
                                        <?php echo form_error('menu_name','<span style="color:red">','</span>'); ?>
                                    </div>
                                    
                                    <div class="form-actions">
                                        <div class="form-group row">
                                            <div class="col-md-9 ml-md-auto btn-list">
                                                <button  class="btn btn-primary btn-rounded" type="submit"><?= isset($menu) ? 'Edit':'Submit'; ?></button>
                                                <a href="<?= base_url('user/view_menus') ?>" class="btn btn-outline-default btn-rounded" type="button">Cancel</a>
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
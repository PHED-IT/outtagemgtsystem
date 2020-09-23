


               
                        <div class="card">
                            <div class="card-header">
     <h4>Roles</h4>
     <!-- <div class="card-header-action">
                       <button class="btn btn-sm btn-outline-primary justify-content-end" data-toggle="modal" data-target="#modalNew" style=""><i class="fa fa-plus"></i> New User</button>
                    </div> -->
 </div>
                            <div class="card-body">
                                 
                                <!-- <p class="text-muted">All bootstrap element classies</p> --> 
                               <?php echo validation_errors('<div class="alert alert-danger mb-2">','</div>'); ?>
                                <form action="" method="POST">
                                    <div class="row">
                                    <div class="col-md-4 ">
                                        <label class="col-form-label" for="choose_role"> Role</label>
                                        
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
                                      
                                        <?php echo form_error('role_id','<span style="color:red">','</span>'); ?>
                                    </div>

                                     <div class="col-md-4">
                                        <label class="col-form-label" for="menu_names"> Menu(Priviledges)</label>
                                        
                                            <select class="form-control" name="menu_id" id="choose_menu">
                                                <option value="">Choose menu</option>
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
                                        
                                        <?php echo form_error('menu_id','<span style="color:red">','</span>'); ?>
                                    </div>

                                      <div class="col-md-4">
                                        <label class=" col-form-label" for="sub_menu"> Sub Menu(Priviledges)</label>
                                        
                                            <select required class="form-control multiple-selector" multiple="" name="sub_menu[]" id="sub_menu">
                                                
                                            </select>
                                        
                                        <?php echo form_error('sub_menu','<span style="color:red">','</span>'); ?>
                                    </div>
                                    </div>
                                    <br/>
                                     <button  class="btn btn-primary btn-rounded" type="submit"><?= isset($user) ? 'Edit':'Submit'; ?></button>
                                </form>



                                <table class="table table-bordered" >
  <thead>
    <th>Role</th>
    <th>Menu</th>
    <th>Submenu</th>
    
  </thead>
  <tbody>
    <?= $show_menu ?>
  </tbody>
</table>
                            </div>
                            <!-- /.widget-body -->
                        </div>
                      

         

                            <div class="card">
                                <!-- <h5 class="box-title mr-b-0">Horizontal Form</h5>
                                <p class="text-muted">All bootstrap element classies</p> -->
                                <div class="card-header">
                                    <?= isset($role) ? 'Edit role':'Create role'; ?>
                                </div>
                                <div class="card-body">
                                <form action="" method="POST">
                                    <div class="">
                                        <label class=" col-form-label" for="role_name"> Role name</label>
                                        
                                            <input class="form-control" value="<?= isset($role) ? $role->role_name:set_value('role_name'); ?>" name="role_name" id="role_name" placeholder="Role name" type="text">
                                       
                                        <?php echo form_error('role_name','<span style="color:red">','</span>'); ?>
                                    </div>
                                   <br/><br/>
                                    <div class="form-actions">
                                        
                                                <button  class="btn btn-primary btn-rounded" type="submit"><?= isset($role) ? 'Edit':'Submit'; ?></button>
                                                <a href="<?= base_url('admin/view_roles') ?>" class="btn btn-outline-danger btn-rounded" type="button">Cancel</a>
                                            
                                    </div>
                                </form>
                                <br/>

                                <table class="table table-striped table-responsive" id="simpleTable" data-toggle="datatables" data-plugin-options='{"searching": true}'>
                                    <thead>
                                        <tr>
                                            <th>Role Name</th>
                                            <th></th>
                                            <th></th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    //var_dump($roles);
                                        foreach ($roles as $role) {
                                            ?>
                                            <tr>
                                                <td><?= $role->role_name; ?></td>
                                                <td><a href="<?= base_url('admin/edit_role').'/'.$role->id ?>" class="btn btn-xs btn-info">Edit</a></td>
                                                <td><button onclick="handleDelete(<?= $role->id; ?>); " class="btn btn-xs btn-danger">Delete</button></td>
                                            </tr>
                                            <?php
                                        }
                                    ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Role Name</th>
                                            
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>



                                   <div id="deleteModal" role="dialog" class="modal fade"  >
                                <div class="modal-dialog" >
                                  <form action="" method="POST" id="formDelete">
                                    
                                <div class="modal-content">
                                 <div class="modal-header">
                                   <h5 class="modal-title">Delete Role</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

                                 </div>

                                <div class="modal-body">
                                <p class="text-center">Are you sure ou want to delete?</p>
                                </div>
                                <div class="modal-footer">
                                     <button type="button" class="btn" data-dismiss="modal" aria-label="Close">Go back</button>
                                     <button type="submit" class="btn btn-danger" >Delete role</button>
                                </div>
                                </div>
                              </form>
                                </div>
                                </div>
                            </div>
                            <!-- /.widget-body -->
                        </div>
                        <!-- /.widget-bg -->
                    <script type="text/javascript">
               
            function handleDelete(id){
              var form=document.getElementById('formDelete');
              form.action='<?= base_url('admin/delete_role') ?>/'+id;
              $('#deleteModal').modal('show');
              console.log(form)
            }
            </script>
        
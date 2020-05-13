
                        <div class="card">
                            <div class="card-header">
                                <h4>View roles</h4>
                            </div>
                            <!-- <div class="widget-heading clearfix">
                                <h5>jQuery DataTables</h5>
                            </div>
 -->                            <!-- /.widget-heading -->
                            <div class="card-body ">
                                <table class="table table-striped table-responsive" data-toggle="datatables" data-plugin-options='{"searching": true}'>
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
                   
            <script type="text/javascript">
               
            function handleDelete(id){
              var form=document.getElementById('formDelete');
              form.action='<?= base_url('admin/delete_role') ?>/'+id;
              $('#deleteModal').modal('show');
              console.log(form)
            }
            </script>
        
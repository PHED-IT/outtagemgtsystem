
            <!-- Page Title Area -->
            <div class="row page-title clearfix">
                <div class="page-title-left">
                    <h6 class="page-title-heading mr-0 mr-r-5">View Users</h6>
                    
                </div>
                <!-- /.page-title-left -->
                <div class="page-title-right d-none d-sm-inline-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
                <!-- /.page-title-right -->
            </div>
            <!-- /.page-title -->
            <!-- =================================== -->
            <!-- Different data widgets ============ -->
            <!-- =================================== -->
            <div class="widget-list">
                <div class="row">
                    <div class="col-md-12 widget-holder">
                        <div class="widget-bg">
                            <!-- <div class="widget-heading clearfix">
                                <h5>jQuery DataTables</h5>
                            </div>
 -->                            <!-- /.widget-heading -->

                            <div class="widget-body clearfix">
                                <table class="table table-striped table-responsive" data-toggle="datatables" data-plugin-options='{"searching": true}'>
                                    <thead>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Role</th>
                                            <th></th>
                                            <th></th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    //var_dump($users);
                                        foreach ($users as $user) {
                                            ?>
                                            <tr style="<?= $user->blocked? 'color: red!important':''; ?>">
                                                <td><?= $user->first_name; ?></td>
                                                <td><?= $user->last_name; ?></td>
                                                <td><?= $user->id; ?></td>
                                                <td><?= $user->phone; ?></td>
                                                <td><?= $user->role_name; ?></td>
                                                <td><a href="<?= base_url('admin/edit_user').'/'.$user->id ?>" class="btn btn-xs btn-info">Edit</a></td>
                                                <td>
                                                    <?php 
                                                        if ($user->blocked) {
                                                            ?>
                                                            <button onclick="handleUnBlock(<?= $user->id; ?>); " class="btn btn-xs btn-success">Unblock</button>
                                                            <?php
                                                        } else {
                                                           ?>
                                                           <button onclick="handleBlock(<?= $user->id; ?>); " class="btn btn-xs btn-danger">Block</button>
                                                           <?php
                                                        }
                                                        
                                                    ?>
                                                    
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Role</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>


                                 <div id="blockModal" role="dialog" class="modal fade"  >
                                <div class="modal-dialog" >
                                  <form action="" method="POST" id="formBlock">
                                    
                                <div class="modal-content">
                                 <div class="modal-header">
                                   <h5 class="modal-title">Block User</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

                                 </div>

                                <div class="modal-body">
                                <p class="text-center">Are you sure you want to block this user?</p>
                                </div>
                                <div class="modal-footer">
                                     <button type="button" class="btn" data-dismiss="modal" aria-label="Close">Go back</button>
                                     <button type="submit" class="btn btn-danger" >Block user</button>
                                </div>
                                </div>
                              </form>
                                </div>
                                </div>



                                <div id="unblockModal" role="dialog" class="modal fade"  >
                                <div class="modal-dialog" >
                                  <form action="" method="POST" id="formUnblock">
                                    
                                <div class="modal-content">
                                 <div class="modal-header">
                                   <h5 class="modal-title">Unblock User</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

                                 </div>

                                <div class="modal-body">
                                <p class="text-center">Are you sure you want to unblock this user?</p>
                                </div>
                                <div class="modal-footer">
                                     <button type="button" class="btn" data-dismiss="modal" aria-label="Close">Go back</button>
                                     <button type="submit" class="btn btn-danger" >Unblock user</button>
                                </div>
                                </div>
                              </form>
                                </div>
                                </div>

                            </div>
                            <!-- /.widget-body -->
                        </div>
                        <!-- /.widget-bg -->
                    </div>
                    <!-- /.widget-holder -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.widget-list -->

            <script type="text/javascript">
               
            function handleBlock(id){
              var form=document.getElementById('formBlock');
              form.action='<?= base_url('admin/block_user') ?>/'+id;
              $('#blockModal').modal('show');
              console.log(form)
            }

            function handleUnBlock(id){
              var form=document.getElementById('formUnblock');
              form.action='<?= base_url('admin/unblock_user') ?>/'+id;
              $('#unblockModal').modal('show');
              console.log(form)
            }
            </script>
        
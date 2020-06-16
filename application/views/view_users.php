
            <!-- /.page-title -->
            <!-- =================================== -->
            <!-- Different data widgets ============ -->
            <!-- =================================== -->
      
                        <div class="card">
                            <!-- <div class="widget-heading clearfix">
                                <h5>jQuery DataTables</h5>
                            </div>
 -->                            <!-- /.widget-heading -->
 <div class="card-header">
     <h4>Users</h4>
     <div class="card-header-action">
                       <button class="btn btn-sm btn-outline-primary justify-content-end" data-toggle="modal" data-target="#modalNew" style=""><i class="fa fa-plus"></i> New User</button>
                    </div>
 </div>
                            <div class="card-body">
                                 <?php echo validation_errors('<div class="alert alert-danger mb-2">','</div>'); ?>
                                <table id="simpleTable" class="table table-striped table-responsive" data-toggle="datatables" data-plugin-options='{"searching": true}'>
                                    <thead>
                                        <tr>
                                            <th>Staff ID</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Role</th>
                                            <th>Zone</th>
                                            <th>33kv Feeder</th>
                                            <th>ISS</th>
                                            <th>Transmission</th>
                                            <th></th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    //var_dump($users);
                                        foreach ($users as $user) {
                                            ?>
                                            <tr style="<?= $user->blocked? 'color: red!important':''; ?>">
                                                <td><?= $user->staff_id; ?></td>
                                                <td><?= $user->first_name; ?></td>
                                                <td><?= $user->last_name; ?></td>
                                                <td><?= $user->email; ?></td>
                                                <td><?= $user->phone; ?></td>
                                                <td><?= $user->role_name; ?></td>
                                                <td><?= $user->zone; ?></td>
                                                <td><?= $user->feeder; ?></td>
                                                <td><?= $user->iss; ?></td>
                                                <td><?= $user->tsname; ?></td>
                                                <td><a href="<?= base_url('admin/edit_user').'/'.$user->id ?>" class="btn btn-xs btn-info">Edit</a></td>
                                                
                                            </tr>
                                            <?php
                                        }
                                    ?>
                                    </tbody>
                                   
                                </table>



                            </div>
                            <!-- /.widget-body -->
                        </div>
                        <!-- /.widget-bg -->
                                <div class="modal fade" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);z-index: 1" id="modalNew" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form class="" action="" method="POST">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">New user</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
                    <div class="col-md-12">
                        
                        <label class="col-form-label" required for=""> Role</label>
                         <select class="form-control" required name="role" id="role">
                          <option value="">Choose Role</option>
                          <?php
                              foreach ($roles as $key => $role) {
                                  ?>
                                  <option 
                                  value="<?= $role->id ?>"
                                  
                                      ><?= $role->role_name ?></option>
                                  <?php
                              }
                          ?>
                      </select>
                        
                    </div>
                    
                </div>
               <div class="row">
                    <div class="col-md-12">
                        
                        <label class="col-form-label"  for=""> Staff Id</label>
                        
                        <input type="text" name="staff_id" required class="form-control">
                    </div>
                    
                </div>  
              <div class="row">
                    <div class="col-md-6">
                        
                        <label class="col-form-label" required for=""> First name</label>
                        
                        <input type="text" required name="first_name" class="form-control">
                    </div>
                    <div class="col-md-6">
                        
                        <label class="col-form-label" required for=""> Last name</label>
                        
                        <input type="text" required name="last_name" class="form-control">
                    </div>
                </div>
               
               <div class="row">
                    <div class="col-md-6">
                        
                        <label class="col-form-label" required for=""> Email</label>
                        
                        <input type="email" required name="email" class="form-control">
                    </div>
                    <div class="col-md-6">
                        
                        <label class="col-form-label" required for=""> Phone number</label>
                        
                        <input type="text" required name="phone" placeholder="080********" class="form-control">
                    </div>
                </div>
                
                <div class="row">
                  <div class="col-md-12">
                        
                    <label class="col-form-label"  for=""> Zone</label>
                        
                  <select class="form-control" id="zone_id" required  name="zone_id">
               <option value="">Choose zone</option>
               <?php
                foreach ($zones as $key => $value) {
                  ?>
                  <option value="<?= $value->id ?>"><?= $value->name ?></option>
                  <?php
                }
               ?>
              </select>
                    </div>
                 
                  
                </div>
                <div class="row" style="display: none;" id="iss_div">
                  <div class="col-md-12">
                    <label class="col-form-label" required for=""> Injection substation(DSO)</label>
                        
                       <select class="form-control" id="iss" name="iss">
               <option value="">Choose ISS</option>
               <?php
                foreach ($iss_data as $key => $value) {
                  ?>
                  <option value="<?= $value->id ?>"><?= $value->iss_names ?></option>
                  <?php
                }
               ?>
              </select>
                  </div>
                </div>
                 <div class="row" style="display: none;" id="33kv_div">
                  <div class="col-md-12">
                    <label class="col-form-label" required for=""> 33kv Feeder(Feeder Managers)</label>
                        
                       <select class="form-control" id="33kv_feeder" name="33kv_feeder">
               <option value="">Choose 33kv Feeder</option>
               <?php
                foreach ($feeders_33 as $key => $value) {
                  ?>
                  <option value="<?= $value->id ?>"><?= $value->feeder_name ?></option>
                  <?php
                }
               ?>
              </select>
                  </div>
                </div>
                <div class="row" style="display: none;" id="transmission_div" >
                  <div class="col-md-12">
                    <label class="col-form-label" required for=""> Transmission station</label>
                        
                       <select class="form-control" id="trans_station" name="trans_station">
               <option value="">Choose Transmission station</option>
               <?php
                foreach ($transmissions as $key => $value) {
                  ?>
                  <option value="<?= $value->id ?>"><?= $value->tsname ?></option>
                  <?php
                }
               ?>
              </select>
                  </div>
                </div>
        
          </div>
          <div class="modal-footer">
            <button class="btn btn-sm btn-outline-success" type="submit" id="">Submit</button>
            <button class="btn btn-sm btn-outline-danger" type="button" data-dismiss="modal">Cancel</button>
           
          </div>
          </form>
        </div>
      </div>
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
        

                            <div class="card">
                                <!-- <h5 class="box-title mr-b-0">Horizontal Form</h5>
                                <p class="text-muted">All bootstrap element classies</p> -->
                                <div class="card-header">
                                    Change Password
                                </div>
                                <div class="card-body">
                                <form action="" method="POST">
                                    <div class="row">
                                    <div class="col-md-6">
                                        <label class=" col-form-label" for="role_name"> Password</label>
                                        
                                            <input type="password" class="form-control" name="password">
                                       
                                        <?php echo form_error('password','<span style="color:red">','</span>'); ?>
                                    </div>
                                    <div class="col-md-6">
                                        <label class=" col-form-label" for="role_name">Confirm Password</label>
                                        
                                            <input type="password" class="form-control" name="cpassword">
                                       
                                        <?php echo form_error('cpassword','<span style="color:red">','</span>'); ?>
                                    </div>
                                </div>
                                   <br/><br/>
                                    <div class="form-actions">
                                        
                                     <button  class="btn btn-primary btn-rounded" type="submit">Submit</button>
                                                
                                            
                                    </div>
                                </form>
                                <br/>

                                
                            </div>
                            <!-- /.widget-body -->
                        </div>
                 
        
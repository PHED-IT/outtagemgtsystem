<form action="" method="POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" placeholder="johndoe@site.com" value="<?php echo set_value('email'); ?>" class="form-control form-control-line" name="email" id="email">
                        <?php echo form_error('email','<span style="color:red">','</span>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" value="<?php echo set_value('email'); ?>" placeholder="password" id="password" name="password" class="form-control form-control-line">
                         <?php echo form_error('password','<span style="color:red">','</span>'); ?>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-block btn-lg btn-primary text-uppercase fs-12 fw-600" type="submit">Login</button>
                    </div>
                    <div class="form-group no-gutters mb-0">
                        <div class="col-md-12 d-flex">
                            <div class="checkbox checkbox-primary mr-auto mr-0-rtl ml-auto-rtl">
                                <label class="d-flex">
                                    <input type="checkbox"> <span class="label-text">Remember me</span>
                                </label>
                            </div><a href="javascript:void(0)" id="to-recover" class="my-auto pb-2 text-right"><i class="material-icons mr-2 fs-18">lock</i> Forgot Password?</a>
                        </div>
                        <!-- /.col-md-12 -->
                    </div>
                    <!-- /.form-group -->
                </form>

            <!-- Page Title Area -->
            <div class="row page-title clearfix">
                <div class="page-title-left">
                    <h6 class="page-title-heading mr-0 mr-r-5">Allocate </h6>
                    
                </div>
                <!-- /.page-title-left -->
                <div class="page-title-right d-none d-sm-inline-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Allocate</li>
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
                                            <th>Asset</th>
                                            <th>Component</th>
                                            <th>Fault Indicators</th>
                                            <th>Date</th>
                                            <th>Remark</th>
                                            <th></th>                             
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    //var_dump($roles);
                                    if (!$trippings) {
                                        echo "<h5>No Fault to allocate</h5>";
                                    } else {
                                        foreach ($trippings as $tripping) {
                                            ?>
                                            <tr>
                                                <td><?= $tripping->asset_name; ?></td>
                                                <td><?= $tripping->component_name; ?></td>
                                                <td><?= $tripping->indicator; ?></td>
                                                <td><?= date("d-M-Y h:i a",strtotime($tripping->date_fault)); ?></td>
                                                <td><?= $tripping->remark; ?></td>
                                                
                                                <td>
                                                <?php
                                                    if ($tripping->allocated) {
                                                        ?>
                                                        <div class="d-flex flex-column">
                                                            <div>
                                                                <span class="font-weight-bold text text-success">ALLOCATED</span>
                                                            </div>
                                                            <div>
                                                            
                                                            <a href="View" class="d-inline-block ml-3">
                                                            View
                                                            </a>
                                                               
                                                                
                                                            </div>
                                                        </div>
                                                       
                                                       
                                                       <?php
                                                    } else {
                                                        ?>
                                                        <buttn onclick="handleAllocate(<?= $tripping->tripping_id; ?>);" class="btn btn-xs btn-info">Allocate</buttn>
                                                        <?php
                                                    }
                                                    
                                                ?>         
                                                </td>
                                               
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                    </tbody>
                                    <tfoot>
                                         <tr>
                                            <th>Asset</th>
                                            <th>Component</th>
                                            <th>Fault Indicators</th>
                                            <th>Date</th>
                                            <th>Remark</th>
                                            <th></th>                             
                                        </tr>
                                    </tfoot>
                                </table>


                                 <div id="allocateModal" role="dialog" class="modal fade"  >
                                <div class="modal-dialog" >
                                  <form action="" method="POST" id="allocateForm">
                                    
                                <div class="modal-content">
                                 <div class="modal-header">
                                   <h5 class="modal-title">Allocate Tripping</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

                                 </div>

                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="name">Name to allocate to</label>
                                        <input id="name"  required type="text" name="name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input id="phone" required type="text" name="phone" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="remark">Remark/Comments</label>
                                        <textarea id="remark" name="remarks" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                     <button type="button" class="btn" data-dismiss="modal" aria-label="Close">Close</button>
                                     <button type="submit" class="btn btn-success" >Submit</button>
                                </div>
                                </div>
                              </form>
                                </div>
                                </div>


                                 <div id="closureModal" role="dialog" class="modal fade"  >
                                <div class="modal-dialog" >
                                  <form action="" method="POST" id="closeForm">
                                    
                                <div class="modal-content">
                                 <div class="modal-header">
                                   <h5 class="modal-title">Close Tripping</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

                                 </div>

                                <div class="modal-body">
                                <div class="form-group">
                                    <label for="remark">Remark/Comments</label>
                                    <textarea id="remark" name="remarks" class="form-control"></textarea>
                                </div>
                                </div>
                                <div class="modal-footer">
                                     <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Go back</button>
                                     <button type="submit" class="btn btn-success" >Continue</button>
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
               
            function handleAllocate(id){
              var form=document.getElementById('allocateForm');
              form.action='<?= base_url('tripping/allocate_tripping') ?>/'+id;
              $('#allocateModal').modal('show');
              // console.log(form.serialize())
            }
            function handleClosure(id){
              var form=document.getElementById('closeForm');
              form.action='<?= base_url('tripping/closure_tripping') ?>/'+id;
              $('#closureModal').modal('show');
              // console.log(form.serialize())
            }
            </script>
        
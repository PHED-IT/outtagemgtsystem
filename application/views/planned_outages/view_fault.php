
            <!-- Page Title Area -->
            <div class="row page-title clearfix">
                <div class="page-title-left">
                    <h6 class="page-title-heading mr-0 mr-r-5">View Trippings/Faults</h6>
                    
                </div>
                <!-- /.page-title-left -->
                <div class="page-title-right d-none d-sm-inline-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Trippings/Faults</li>
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
                            </div>
 -->                            <!-- /.widget-heading -->
                            <div class="widget-body clearfix " style="overflow-x: auto;">
                                <table  id="simpleTable" class="table table-striped table-responsive" data-toggle="datatables" data-plugin-options='{"searching": true}'>
                                    <thead>
                                        <tr>
                                           <th>Asset</th>
                                            <th>Component</th>
                                            <th>Fault Indicators</th>
                                            
                                            <th>Date</th>
                                            <th>Cause Fault</th>
                                            <th>Expected Res. Time</th>
                                            
                                            <th>Remark</th>
                                            <th>A</th>
                                            <th>C</th>
                                            <th>E</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    //var_dump($roles);
                                        foreach ($trippings as $tripping) {
                                            ?>
                                            <tr>
                                                <td><?= $tripping->asset_name; ?></td>
                                                <td><?= $tripping->component_name; ?></td>
                                                <td><?= $tripping->indicator; ?></td>
                                                <td><?= date("d-M-Y h:i a",strtotime($tripping->date_fault)); ?></td>
                                                <td><?= $tripping->cause_fault; ?></td>
                                                <td><?= $tripping->expected_res_date; ?></td>
                                                
                                                
                                                <td><?= $tripping->remark; ?></td>
                                               
                                                <td>
                                                <?php
                                                    if ($tripping->allocated) {
                                                        ?>
                                                        <button data-toggle="modal" data-target="#al<?= $tripping->tripping_id ?>" class="d-flex flex-column">
                                                            <div>
                                                                <span class="font-weight-bold text text-success">ALLOCATED</span>
                                                            </div> 
                                                        </button> 

                                 <div id="al<?= $tripping->tripping_id ?>" role="dialog" class="modal fade"  >
                                <div class="modal-dialog" >
                                 
                                <div class="modal-content">
                                 <div class="modal-header">
                                   <h5 class="modal-title">View Allocate </h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

                                 </div>

                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="name">Alllocated to: <?= $tripping->al_name ?></label>
                                       
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone: <?= $tripping->phone ?></label>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="">Date: <?= date("d-m-Y",strtotime($tripping->al_created)) ?></label>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="remark">Remark/Comments: <?= $tripping->al_remarks ?></label>
                                       
                                    </div>
                                    <hr/>
                                     
                                    <div class="form-group">
                                        <label for="remark">Expected Restoration Date: <?= date("d-m-Y",strtotime($tripping->expected_res_date)) ?></label>   
                                    </div>
                                </div>
                                <div class="modal-footer">
                                     <button type="button" class="btn btn-xs btn-danger" data-dismiss="modal" aria-label="Close">Close</button>
                                     
                                </div>
                                </div>
                              
                                </div>
                                </div>
                                <?php
                                    } else {
                                        ?>
                                        
                                        <?php
                                    }
                                    
                                    ?>         
                                                </td>
                                                <td>
                                                   <?php
                                                    if ($tripping->closed) {
                                                        ?>
                                                       <button data-toggle="modal" data-target="#c<?= $tripping->tripping_id ?>" class="d-flex flex-column">
                                                            <div>
                                                                <span class="font-weight-bold text text-info">CLOSED</span>
                                                            </div>
                                                            
                                                        </button>
                                                          <div id="c<?= $tripping->tripping_id ?>" role="dialog" class="modal fade"  >
                                <div class="modal-dialog" >
                                                                     
                                <div class="modal-content">
                                 <div class="modal-header">
                                   <h5 class="modal-title">Closed Tripping</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

                                 </div>

                                <div class="modal-body">
                                <div class="form-group">
                                    <label for="remark">Personnel: <?= $tripping->personnel ?></label>
                                </div>
                                 <div class="form-group">
                                    <label for="remark">Materials: <?= $tripping->materials ?></label>
                                </div>
                                <div class="form-group">
                                    <label for="remark">Completed Date:  <?= date("d-m-Y",strtotime($tripping->completed_at)) ?></label>
                                </div>
                                <div class="form-group">
                                    <label for="remark">Remarks: <?= $tripping->c_remarks ?></label>
                                </div>
                                </div>
                                <div class="modal-footer">
                                     <button type="button" class="btn btn-xs btn-danger" data-dismiss="modal" aria-label="Close">Go back</button>
                                     
                                </div>
                                </div>
                        
                                </div>
                                </div>
                                                       <?php
                                                    } else {
                                                        ?>
                                                        
                                                        <?php
                                                    }   
                                                    ?>    
                                                </td>
                                                <td>
                                                   <?php
                                                    if (!$tripping->caused) {
                                                        ?>
                                                        <a href="<?= base_url('tripping/edit_fault').'/'.$tripping->tripping_id ?>" class="btn btn-xs  btn-info">Edit</a>
                                                        <?php
                                                    }
                                                    
                                                ?> 
                                                </td>
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
        
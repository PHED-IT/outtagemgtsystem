
            <!-- Page Title Area -->
            <div class="row page-title clearfix">
                <div class="page-title-left">
                    <h6 class="page-title-heading mr-0 mr-r-5">Acknowledge By DSO</h6>
                    
                </div>
                <!-- /.page-title-left -->
                <div class="page-title-right d-none d-sm-inline-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Acknowledge By DSO</li>
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
                                            <th>Cause of Fault</th>
                                            <th>Date</th>
                                            <th>Remark</th>
                                            <th></th>    
                                            <th></th>    
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    
 if (!$trippings) {
     echo "<h4>No trippings to close</h4>";
} else {                                    
     foreach ($trippings as $tripping) {
?>
 <tr>
<td><?= $tripping->asset_name; ?></td>
<td><?= isset($tripping->component_name)?$tripping->component_name:'-'; ?></td>
<td><?= $tripping->indicator; ?></td>
<td><?= isset($tripping->cause_fault)?$tripping->cause_fault:'-'; ?></td>
<td><?= date("d-M-Y h:i a",strtotime($tripping->date_fault)); ?></td>
<td><?= !empty($tripping->remark)?'<a href="" style="text-decoration:underline">Read remark</a>':'-'; ?></td>
<td>
 
    <button data-toggle="modal" data-target="#nm<?= $tripping->tripping_id ?>"  class="btn btn-sm  btn-outline-default">N.M Input</button>
<div id="nm<?= $tripping->tripping_id ?>" role="dialog" class="modal fade"  >
        <div class="modal-dialog" >
                                                                     
                <div class="modal-content">
                                 <div class="modal-header">
                                   <h5 class="modal-title">Network Manager Input</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

                                 </div>

                                <div class="modal-body">
                               
                                 <div class="form-group">
                                    <label for="remark">Work Done: <?= $tripping->work_done ?></label>
                                </div>
                                <div class="form-group">
                                    <label for="remark">Completed Date:  <?= date("d-m-Y",strtotime($tripping->date_completed)) ?></label>
                                </div>
                                <div class="form-group">
                                    <label for="remark">Remarks: <?= $tripping->remarks ?></label>
                                </div>
                                </div>
                                <div class="modal-footer">
                                     <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">close</button>
                                     
                                </div>
                                </div>
                        
                                </div>
                                </div>
    
 </td>
 <td>

    
   <button onclick="handleClosure(<?= $tripping->tripping_id; ?>);" class="btn btn-sm  btn-outline-primary">Acknowledge</button>  
 </td>
                                                
</tr>
<?php
    }
    }
?>
 </tbody>
                                   
</table>



 <div id="closureModal" role="dialog" class="modal fade"  >
 <div class="modal-dialog" >
<form action="" method="POST" id="closeForm">
                                    
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title"></h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
                                
  <div class="modal-body"> 
                                   
                          
<div class="form-group">
    <label for="remarks">Remark/Comments</label>
    <textarea id="remarks" placeholder="Optional" name="remarks" class="form-control"></textarea>
</div>
</div>
    <div class="modal-footer">
        
         <button type="submit" class="btn btn-success btn-sm" >Continue</button>
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">Go back</button>
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
               
            
            function handleClosure(id){
              var form=document.getElementById('closeForm');
              form.action='<?= base_url('tripping/acknowlege_dso_post') ?>/'+id;
              $('#closureModal').modal('show');
              // console.log(form.serialize())
            }
            </script>
        

            <!-- Page Title Area -->
            <div class="row page-title clearfix">
                <div class="page-title-left">
                    <h6 class="page-title-heading mr-0 mr-r-5">Closure By Network Managers</h6>
                    
                </div>
                <!-- /.page-title-left -->
                <div class="page-title-right d-none d-sm-inline-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Closure By Network Managers</li>
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
                                            <th>Closure</th>    
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    //var_dump($roles);
 if (!$trippings) {
     echo "<h4>No trippings to close</h4>";
} else {                                    
     foreach ($trippings as $tripping) {
?>
 <tr>
<td><?= $tripping->asset_name; ?></td>
<td><?= $tripping->component_name; ?></td>
<td><?= $tripping->indicator; ?></td>
<td><?= $tripping->cause_fault; ?></td>
<td><?= date("d-M-Y h:i a",strtotime($tripping->date_fault)); ?></td>
<td><?= $tripping->remark; ?></td>
<td>
 <?php
    if ($tripping->closed) {
      echo 'CLOSED';
     } else {
     ?>
    <button onclick="handleClosure(<?= $tripping->tripping_id; ?>);" class="btn btn-sm  btn-outline-primary">Close</button>
    <?php }  ?>    
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
<label for="work_done">Work Done</label>
<textarea id="work_done" required name="work_done" class="form-control"></textarea>
</div>
                                    
<div class="form-group">
<label for="completed_at">Date completed</label>
<input required placeholder="Choose date" class="form-control" style="color: #333" type="text" name="completed_at" id="captured_date" />
</div>
                                    
<div class="form-group">
    <label for="remarks">Remark/Comments</label>
    <textarea id="remarks" name="remarks" class="form-control"></textarea>
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
              form.action='<?= base_url('tripping/closure_nm_post') ?>/'+id;
              $('#closureModal').modal('show');
              // console.log(form.serialize())
            }
            </script>
        



                        <div class="card">
                            <!-- <div class="widget-heading clearfix">
                                <h5>jQuery DataTables</h5>
                            </div>
 -->                            <!-- /.widget-heading -->
 <div class="card-header">
     <h4>Feeder wise latest entry status</h4>
    
 </div>
                            <div class="card-body">
                                 
                                <table id="myTable" class="table table-striped table-responsive" data-toggle="datatables" data-plugin-options='{"searching": true}'>
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Substation</th>
                                            <th>Param</th>
                                            <th>Latest Date</th>
                                            
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    //var_dump($users);
                                        foreach ($reports as $key=> $report) {
                                            ?>
                                            <tr >
                                                <td><?= $key+1; ?></td>
                                                <td><?= $report->iss; ?></td>
                                               <td></td>
                                                <td><?= date("d-M-Y",strtotime($report->captured_at)); ?></td>
                                               
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
                 
            <!-- /.widget-list -->

        
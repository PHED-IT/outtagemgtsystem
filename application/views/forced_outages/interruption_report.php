<div class="row page-title clearfix">
                <div class="page-title-left">
                    <h6 class="page-title-heading mr-0 mr-r-5">Interruption due to fault Report</h6>
                    <!-- <p class="page-title-description mr-0 d-none d-md-inline-block">statistics, charts and events</p> -->
                </div>
                <!-- /.page-title-left -->
                <div class="page-title-right d-none d-sm-inline-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Interruption due to fault Report</li>
                    </ol>
                </div>
                <!-- /.page-title-right -->
            </div>


            <div class="widget-list">
                <div class="row">
                    <div class="col-md-12 widget-holder">
                        <div class="widget-bg">
                            <div class="widget-body clearfix">
                               
                                <!-- <h5 class="box-title mr-b-0">Horizontal Form</h5>
                                <p class="text-muted">All bootstrap element classies</p> -->
                                    <?php echo validation_errors('<div class="alert alert-danger mb-2">','</div>'); ?>
                                
                                    <form action="" method="POST">
                                    <div class="row">
                                        <div class="col-md-4">
                                             <select class="form-control" name="feeder_id" id="feeder_id">
                                                    <option value="">Choose Feeder</option>
                                                    <option value="all">All Feeders</option>
                                                    <
                                                    <?php
                                                        foreach ($feeders as $key => $value) {
                                                            ?>
                                                            <option 
                                                            value="<?= $value->feeder_id ?>"
                                                            
                                                                ><?= $value->feeder_name ?></option>
                                                            <?php
                                                        }
                                                    ?>
                                                </select>
                                        </div>
                                        <!-- <div class="col-md-1"></div> -->
                                        <div class="col-md-4">
                                             <div class="form-group row">
                                            
                                                <input class="form-control date_range_picker" style="color: #333" type="text" name="date" id="date_range_picker" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-actions"  id="button-container">
                                                <div class="form-group row">
                                                    <div class="col-md-9 ml-md-auto btn-list">
                                                        <button  class="btn btn-primary btn-rounded" type="submit">Generate Report</button>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                       
                                    </div>
                                   
                                  
                                </form>
                                    <hr/>
                                    <?php
                                        if (isset($report)) {  
                                             // echo "<pre>";
                                             // print_r($max);
                                             // echo "</pre>";
                                            
                                    ?>
                                    <div id="report-container" >
                                        <h4 style="font-weight: bold" id="summary_title"><?= $title ?></h4>
                                        
                                       

                                        <div style="overflow-x: auto;" id="doublescroll">
                                        <table id="" class="table table-bordered table-striped table-responsive" data-toggle="datatables" data-plugin-options='{"searching": true}'>
                                        <?= $report ?>
                                    </table>
                                    </div>
                                    </div>
                                <?php } ?>
                            <!-- this is section for summary -->
                            </div>
                            <!-- /.widget-body -->
                        </div>
                        <!-- /.widget-bg -->
                    </div>

                </div>
            </div>
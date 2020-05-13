<div class="row page-title clearfix">
                <div class="page-title-left">
                    <h6 class="page-title-heading mr-0 mr-r-5">Fault Report</h6>
                    <!-- <p class="page-title-description mr-0 d-none d-md-inline-block">statistics, charts and events</p> -->
                </div>
                <!-- /.page-title-left -->
                <div class="page-title-right d-none d-sm-inline-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Fault Report</li>
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
                                         <div class="col-md-12 d-flex flex-row justify-content-between">
                                            <!-- <div>
                                                <div class="radiobox radio-info">
                                              <label>
                                                  <input type="radio" class="capture_type" name="asset_type" value="TS"> <span class="label-text">TS</span>
                                              </label>
                                              </div>
                                              </div> -->
                                              <div>
                                                 <div class="radiobox radio-info">
                                              <label>
                                                  <input type="radio" class="capture_type" name="asset_type" value="feeder_33"> <span class="label-text">FEEDER 33KV</span>
                                              </label>
                                              </div>
                                              </div>
                                              <div>

                                                <div class="radiobox radio-info">
                                              <label>
                                                  <input type="radio" class="capture_type" name="asset_type" value="ISS"> <span class="label-text ">ISS</span>
                                              </label>
                                              </div>
                                              </div>
                                              
                                              <div>
                                                <div class="radiobox radio-info">
                                              <label>
                                                  <input type="radio" class="capture_type" name="asset_type" value="feeder_11"> <span class="label-text ">FEEDER 11KV</span>
                                              </label>
                                              </div>
                                              </div>
                                              
                                             <div>
                                               <div class="radiobox radio-info">
                                              <label>
                                                  <input type="radio" class="capture_type" name="asset_type" value="dtr"> <span class="label-text ">DTR</span>
                                              </label>
                                              </div>
                                             </div>
                                              
                                       
                                    </div>
                                    <br/>
                                    <div class="row">
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class=" col-form-label" for="fault"> Search </label>
                                            <span id="spinner"></span>
                                             <!-- <select class="form-control" name="asset_name" id="asset_select">
                                                <option value="all">All</option>
                                                    
                                                </select> -->
                                                <input type="text" placeholder="Search " value="<?= isset($tripping) ? $tripping->asset_name:set_value('asset_name'); ?>" name="asset_name" class="form-control asset_name">
                                            </div>
                                        </div>

                                        
                                        <!-- <div class="col-md-1"></div> -->
                                        <div class="col-md-4">
                                             <div class="form-group">
                                                <label class=" col-form-label" for="fault"> Choose date </label>
                                                <input required class="form-control date_range_picker" style="color: #333" type="text" name="date" id="date_range_picker" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class=" col-form-label"></label>    
                                                <button  class="form-control btn btn-primary btn-rounded" type="submit">Show Report</button>
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
                                        <p style="" id="summary_title"><strong><?= $title ?></strong></p>
                                        
                                       

                                        <div style="overflow-x: auto;" id="doublescroll">
                                        <table id="myTable" class="table table-bordered table-striped table-responsive" data-toggle="datatables" data-plugin-options='{"searching": true}'>
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
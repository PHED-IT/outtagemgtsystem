<div class="row page-title clearfix">
                <div class="page-title-left">
                    <h6 class="page-title-heading mr-0 mr-r-5">Hourly Input Energy Report</h6>
                    <!-- <p class="page-title-description mr-0 d-none d-md-inline-block">statistics, charts and events</p> -->
                </div>
                <!-- /.page-title-left -->
                <div class="page-title-right d-none d-sm-inline-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Hourly Input Energy Report</li>
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
                               
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                            <label class="col-md-5 col-form-label" for="year_input"> Choose year</label>
                                        <div class="col-md-7">
                                               <select class="form-control" name="year_input" id="year_input">
                                                    <option value="">Choose year</option>
                                                    <?php
                                                        for ($i=2000; $i <=2090 ;$i++) {
                                                            ?>
                                                            <option 
                                                            value="<?= $i ?>"
                                                            
                                                                ><?= $i ?></option>
                                                            <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        </div>
                                        <!-- <div class="col-md-1"></div> -->
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                            <label class="col-md-3 col-form-label" for="month_input"> Choose Month</label>
                                            <div class="col-md-9">
                                                
                                               <select class="form-control" name="month_input" id="month_input">
                                                    <option value="">Choose month</option>
                                                    <option value="1">January</option>
                                                    <option value="2">February</option>
                                                    <option value="3">March</option>
                                                    <option value="4">April</option>
                                                    <option value="5">May</option>
                                                    <option value="6">June</option>
                                                    <option value="7">July</option>
                                                    <option value="8">August</option>
                                                    <option value="9">September</option>
                                                    <option value="10">October</option>
                                                    <option value="11">November</option>
                                                    <option value="12">December</option>
                                                </select>
                                            </div>
                                            
                                            </div>
                                        </div>
                                    </div>
                                   <h5>Choose Day</h5>
                                   <?php
                                    for ($day=1; $day <=31 ; $day++) { 
                                        ?>
                                        <button class="day_picker btn btn-primary btn-md" style="margin-right: 7px;margin-bottom: 5px"><?= $day; ?></button>
                                        <?php
                                    }

                                    ?> 
                                
                            
                                    <hr/>
                                    <div id="report-container" >
                                        <h4 style="font-weight: bold;display: none;" id="summary_title">Hourly Report for: <span id="show_date"></span></h4>

                                        <div id="show_record">
                                            <table class="table table-striped table-responsive" data-toggle="datatables" data-plugin-options='{"searching": true}'>
                                                <thead>
                                                    <tr>
                                                        <th>Time</th>
                                                        <th>Readings</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody-report">
                                                    
                                                </tbody>
                                            </table>
                                            
                                        </div>

                                    </div>
                            <!-- this is section for summary -->
                            </div>
                            <!-- /.widget-body -->
                        </div>
                        <!-- /.widget-bg -->
                    </div>

                </div>
            </div>
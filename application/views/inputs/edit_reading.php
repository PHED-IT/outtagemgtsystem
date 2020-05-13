<a href="<?= base_url('input/').'/#summary-container' ?>" class="btn btn-info btn-xs my-2">Back</a>
<div class="row page-title clearfix">
                <div class="page-title-left">
                    <h6 class="page-title-heading mr-0 mr-r-5">Edit Reading for(
                        <?= $feeder_name ?>)</h6>
                    <!-- <p class="page-title-description mr-0 d-none d-md-inline-block">statistics, charts and events</p> -->
                </div>
                <!-- /.page-title-left -->
                <div class="page-title-right d-none d-sm-inline-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Edit Reading for(
                        <?= $feeder_name ?>)</li>
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
                                    
                                    <table class="table table-striped table-responsive" >
                                        <thead>
                                            <tr>
                                                <th>IBC</th>
                                                <th>Feeders</th>
                                                <th>Readings</th>
                                                
                                                
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
                                            <?php
                                                foreach ($input_data as $key => $value) {
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?= $value->ibc_name ?>
                                                            <input type="hidden" value="<?= $value->ibc_name ?>" name="ibc_name">
                                                        </td>
                                                        <td>
                                                            <input type="hidden" value="<?= $value->feeder_name ?>" name="feeder_name">
                                                            <?= $value->feeder_name ?>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="readings[]" 
                                                            value="<?= $value->reading?>">
                                                            <input type="hidden" name="prev_readings[]" 
                                                            value="<?= $value->reading?>">
                                                            <input type="hidden" name="created_at[]" 
                                                            value="<?= $value->created_at?>">
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                             ?>
                                        </tbody>

                                    </table>
                                    <div class="form-actions" id="button-container">
                                        <div class="form-group row">
                                            <div class="col-md-9 ml-md-auto btn-list">
                                                <button  class="btn btn-primary btn-rounded" type="submit">Update</button>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            


                            
                            </div>
                            <!-- /.widget-body -->
                        </div>
                        <!-- /.widget-bg -->
                    </div>

                </div>
            </div>
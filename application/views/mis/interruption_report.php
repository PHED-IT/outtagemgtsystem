
<div class="card">
<div class="card-header"><h4>INTERRUPTION REPORT</h4></div>
            <div class="card-body">
                               
                                <!-- <h5 class="box-title mr-b-0">Horizontal Form</h5>
                                <p class="text-muted">All bootstrap element classies</p> -->
                                    <?php echo validation_errors('<div class="alert alert-danger mb-2">','</div>'); ?>
                                
                                    <form action="" method="POST">
    <fieldset id="form-section" class="scheduler-border" >
   <legend class="scheduler-border">Filter</legend>
                                   <div class="row">
             
    <div class="col-md-3">
               
              <label class="col-form-label" for="date_picker"> Voltage Level</label>
              <select name="voltage_level"  class="form-control">
                <option value="">Choose Voltage level</option>
                <option value="33kv">33kv</option>
                <option value="11kv">11kv</option>
              </select>
            </div>
              
           
               <div class="col-md-4">
               
              <label class="col-form-label" for="date_picker"> Choose Date</label>
              <div class="" style="position: relative !important;">
                <input type="text" name="date" id="date_range_picker" class="form-control">
               
              
              </div>
            </div>
            <div class="col-md-2 my-2">
                                            
                <div class="form-group">
              <label>.</label>
              <div class=" ml-md-auto btn-list">
               <button  class="btn btn-primary form-control" id="show_report_click" type="submit">Show Report</button>
                                                        
              </div>
                                                
                </div>
                </div>
                                       
                </div>
                             </fieldset>

                                </form>
                                <center><div class="alert alert-info" id="show_report_click_div" style="display: none;"><span class="fa fa-spinner fa-spin"></span> Wait report is loading... </div></center>
                                <?php 

                                if (isset($report)) {
                                  ?>
                                  <center><h5><?= $title ?></h5></center>
                                
                         <!-- programe sheet -->
                          <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" style="color: #000" id="home-tab" data-toggle="tab" href="#home" role="tab"
                          aria-controls="home" aria-selected="true">Report </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" style="color: #000" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                          aria-controls="profile" aria-selected="false"></a>
                      </li>
                     
                    </ul>

                    <div class="tab-content" id="myTabContent">
                       <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                        <table id="" class=" table-bordered table-responsive" data-toggle="datatables" data-plugin-options='{"searching": true}'>
                                        <?= $report ?>
                                    </table>
                        
                     </div>
                     <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                       <table id="" class=" table-bordered table-responsive" data-toggle="datatables" data-plugin-options='{"searching": true}'>
                                          
                                    </table>
                     </div>
                   </div>

                   
                   <?php
                       
                       } ?>
                            </div>
                            <!-- /.widget-body -->
                        </div>
                        <!-- /.widget-bg -->
                   
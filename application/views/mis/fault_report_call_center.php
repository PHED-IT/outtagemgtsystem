
<div class="card">
                               <div class="card-header"><h4>FAULT REPORT</h4></div>
                               <div class="card-body">
                               
                                <!-- <h5 class="box-title mr-b-0">Horizontal Form</h5>
                                <p class="text-muted">All bootstrap element classies</p> -->
                                    <?php echo validation_errors('<div class="alert alert-danger mb-2">','</div>'); ?>
                                
                                    <form action="" method="POST">
                                                               <fieldset id="form-section" class="scheduler-border" >
   <legend class="scheduler-border">Filter</legend>
                                   <div class="row">
             <div class="col-md-4 ts_div_log" id="">

            <label> Report Type</label>
                <select class="form-control" name="report_type" id="report_type_fault">
                 <option>Summary</option>
                 
                 <!-- <option value="interruption">Interruption Report</option>
                 <option value="programe_sheet">Programme Sheet</option> -->
                  </select>
              </div>
  
              <div class="col-md-3" id="status_div">

            <label> Status</label>
                <select class="form-control" name="status" id="">
                 <option value="all">All</option>
                 
                 <option value="opened">Opened</option>
                 <option value="closed">Closed</option>
                  </select>
              </div>
           
               <div class="col-md-3">
               
              <label class="col-form-label" for="date_picker"> Choose Month</label>
              <div class="" style="position: relative !important;">
                  <input placeholder="Choose month" class="form-control date_picker" style="color: #333" type="text" name="date"  autocomplete="off" id="date_picker" />
               
              
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

                                if (isset($report_type)) {
                                  ?>
                                  <center><h5><?= $title ?></h5></center>
                                  <?php
                                  if ($report_type=="Summary") {
                                    
                                 
                                  
                                    # dispatch,hso,admin,others,feeder manager

                                    ?>
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" style="color: #000" id="home-tab" data-toggle="tab" href="#home" role="tab"
                          aria-controls="home" aria-selected="true">33kv</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" style="color: #000" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                          aria-controls="profile" aria-selected="false">11kv</a>
                      </li>
                     
                    </ul>
                    <div class="tab-content" id="myTabContent">
                       <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <table id="myTable" class="table table-bordered table-responsive">
                           <thead>
                             <th>S/N</th>
                             <th>Status</th>
                             <th>Name of Feeder</th>
                             
                             <th>Time and date of fault</th>
                             <th>Indication</th>
                             
                             <th>Location</th>
                            
                           </thead>
                           <tbody>
                             <?php
                              foreach ($report as $key => $value) {
                               ?>
                               <tr>
                                 <td><?= $key+1 ?></td>
                                 <td>
                                  <?php
                                    if (empty($value->date_closed)) {
                                      ?>
                                      <span class="text-danger" style="font-weight: bold;">Open</span>

                                      <?php
                                    } else {
                                      ?>
                                      <span class="text-success" style="font-weight: bold;">Closed</span>
                                      <?php
                                      # code...
                                    }
                                    
                                  ?>
                                    
                                  </td>
                                  <td style="font-size: 11px">
                    <?php
                      if ($value->category=="Transmission station") {
                        echo $value->transmission;
                      }elseif ($value->category=="Injection substation") {
                        echo $value->iss_name;
                      }elseif ($value->category=="Transformer") {
                        if ($value->voltage_level=="33kv") {
                           echo $value->transmissionN." > <span class='text-info'>".$value->transformer."</span>";
                        }else{
                          echo $value->iss_nameN." > <span class='text-info'>".$value->transformer."</span>";
                        }
                       
                      }elseif ($value->category=="Feeder") {
                        if ($value->voltage_level=="33kv") {
                           echo $value->transmissionN." > ".$value->transformerN." >  <span class='text-info'>".$value->feeder_name."</span>";
                        }else{
                           echo $value->iss_nameN." > ".$value->transformerN." >  <span class='text-info'>".$value->feeder_name."</span>";
                        }
                      }
                    ?>
                  </td>
                  
                  <td class="td"><?= $value->outage_date; ?></td>
                  <td><?= $value->indicator; ?></td>
                  
                  <td><?= $value->location ?></td>
                 
                   
                               </tr>
                               <?php
                              }
                             ?>
                           </tbody>
                         </table>
                       </div>
<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

            <table id="myTable" class="table table-bordered table-responsive">
                           <thead>
                             <th>S/N</th>
                             <th>Status</th>
                             <th>Name of Feeder</th>
                             
                             <th>Time and date of fault</th>
                             <th>Indication</th>
                             
                             <th>Location</th>
                             
                           </thead>
                           <tbody>
                             <?php
                              foreach ($report_11kv as $key => $value) {
                               ?>
                               <tr>
                                 <td><?= $key+1 ?></td>

                                 <td>
                                  <?php
                                    if (empty($value->date_closed)) {
                                      ?>
                                      <span class="text-danger" style="font-weight: bold;">Open</span>

                                      <?php
                                    } else {
                                      ?>
                                      <span class="text-success" style="font-weight: bold;">Closed</span>
                                      <?php
                                      # code...
                                    }
                                    
                                  ?>
                                    
                                  </td>
                                  <td style="font-size: 11px">
                    <?php
                      if ($value->category=="Transmission station") {
                        echo $value->transmission;
                      }elseif ($value->category=="Injection substation") {
                        echo $value->iss_name;
                      }elseif ($value->category=="Transformer") {
                        if ($value->voltage_level=="33kv") {
                           echo $value->transmissionN." > <span class='text-info'>".$value->transformer."</span>";
                        }else{
                          echo $value->iss_nameN." > <span class='text-info'>".$value->transformer."</span>";
                        }
                       
                      }elseif ($value->category=="Feeder") {
                        if ($value->voltage_level=="33kv") {
                           echo $value->transmissionN." > ".$value->transformerN." >  <span class='text-info'>".$value->feeder_name."</span>";
                        }else{
                           echo $value->iss_nameN." > ".$value->transformerN." >  <span class='text-info'>".$value->feeder_name."</span>";
                        }
                      }
                    ?>
                  </td>
                  
                  <td class="td"><?= $value->outage_date; ?></td>
                  <td><?= $value->indicator; ?></td>
                 
                  <td><?= $value->location ?></td>
                 
                               </tr>
                               <?php
                              }
                             ?>
                           </tbody>
                         </table>

</div>
<!-- End of admin,hso and others -->
                         <?php }
                       }?>
                            </div>
                            <!-- /.widget-body -->
                        </div>
                        <!-- /.widget-bg -->
                   
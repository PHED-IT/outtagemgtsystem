
           
            <div class="widget-list">
              <div class="row">
              <div class="card">
                <div class="card-header">
                  <h4>General Manager Technical</h4>
                </div>
                      
      <div class="card-body">
                
                      <table id="simpleTable2" class="table tables  table-bordered table-responsive" data-toggle="datatables" data-plugin-options='{"searching": true}'>
                     <thead>
                      <tr>
                       <th> Id</th>
                      <th>Equipment</th>
                      <th>Category</th>
                      <th>Voltage Level</th>
                      <th>Response</th>
                      
                      <th>Status</th>
                      <th>Indicator</th>
                      <th>Entry Date</th>
                      <th>Date/Time Occurred</th>
                      <th>Est. Duration</th>
                      <th></th>                             
                      <th></th>                             
                  </tr>
                    </thead>
                    <tbody>
      <?php
          foreach ($outages as $outage) {
              ?>
              <tr>
                   <td><?= $outage->outage_id; ?></td>
                  <td style="font-size: 11px">
                    <?php
                      if ($outage->category=="Transmission station") {
                        echo $outage->transmission;
                      }elseif ($outage->category=="Injection substation") {
                        echo $outage->iss_name;
                      }elseif ($outage->category=="Transformer") {
                        if ($outage->voltage_level=="33kv") {
                           echo $outage->transmissionN." > <span class='text-info'>".$outage->transformer."</span>";
                        }else{
                          echo $outage->iss_nameN." > <span class='text-info'>".$outage->transformer."</span>";
                        }
                       
                      }elseif ($outage->category=="Feeder") {
                        if ($outage->voltage_level=="33kv") {
                           echo $outage->transmissionN." > ".$outage->transformerN." >  <span class='text-info'>".$outage->feeder_name."</span>";
                        }else{
                           echo $outage->iss_nameN." > ".$outage->transformerN." >  <span class='text-info'>".$outage->feeder_name."</span>";
                        }
                      }
                    ?>
                  </td>
                  <td><?= $outage->category; ?></td>
                  <td><?= $outage->voltage_level; ?></td>
                  <td><?= $outage->type_response==1?'Fault':'Rapid'; ?></td>
                  
                   <td>
                    <?php 
                      if($outage->status==0){
                        ?>
                        <i class="fa fa-ban text-danger"></i>
                        <?php
                      }else{
                        ?>
                        <i class="fa fa-handshake-o text-success"></i>
                       <span id="text<?= $outage->outage_id ?>"> <?= $outage->status_message; ?></span>
                        <?php
                      }
                    ?>
                  </td>
                  <td><?= $outage->indicator; ?></td>
                  <td class="td"><?= date("d-M-Y h:i a",strtotime($outage->created_at)); ?></td>
                  <td class="td"><?= date("d-M-Y h:i a",strtotime($outage->outage_date)); ?></td>
                  <td><?= $outage->duration; ?> min.</td>
                             
                  
                  <td>
                  
                        <?php
                      
                      if ($outage->status>=4) {
                        ?>
                        <div class="d-flex justify-content-between">
                          <div>
                       
                          </div>
                          <div>
                            <button class="btn-info" target="popup" 
  onclick="window.open('<?= base_url('FaultResponse/view_boq/'.$outage->outage_id) ?>','popup','width=600,height=600'); return false;" data-toggle="tooltip" data-placement="bottom"
                title="View BOQ"><span class="fa fa-eye text-primary"></span></button>
                          </div>
                        </div>
                        
                
                        <?php
                      }
                    ?>
                  </td>  
                    
                   <td>
                    <?php
                      if ($outage->status==6) {
                        ?>
                         <button id="<?= $outage->outage_id ?>" class="btn-success approve_boq_gm" data-toggle="tooltip" data-placement="bottom"
                title="Approve BOQ"><span class="fa fa-flash"></span></button>
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
            </div>
   
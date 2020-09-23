<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    
    <style>
    	.title_td:{
    		font-weight: bold;
    		color: #375fb3
    	}
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    .text-info{
      color: #375fb3
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }
    
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="<?php echo asset_url();?>img/logo.png" style="width:100%; max-width:300px;">
                            </td>
                            
                            <td>
                               <span style="color:#375fb3"> Outage ID #:<?= $outage->outage_id ?></span><br>
                                Created: <?= date("F d, Y",strtotime($outage->created_at)) ?> 
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                 REQUEST FOR OUTAGE<br>
                                
                            </td>
                            
                            
                        </tr>
                    </table>
                </td>
            </tr>
            
            
            <tr class="heading">
                <td>
                    
                </td>
                
                <td>
                   
                </td>
            </tr>
            
            <tr class="item">
                <td >
                    <strong class="title_td" style="">Feeder:</strong>
                </td>
                
                <td>
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
            </tr>
            
            <tr class="item">
                <td class="title_td">
                  <strong class="title_td" style=""> Voltage Level:</strong>
                </td>
                
                <td>
                   <?= $outage->voltage_level ?>
                </td>
            </tr>
            <tr class="item">
                  <td class="title_td">
                    <strong class="title_td" style="">Reason for the outage request:</strong>
                </td>
                
                <td>
                    <?= $outage->reason ?>
                </td>
            </tr>
            
            <tr class="item">
                <td class="title_td">
                    <strong class="title_td" style="">Estimated Duration:</strong>
                </td>
                
                <td>
                	<?= $outage->duration ?>minutes
                   
                </td>
            </tr>
            <tr class="item">
                <td class="title_td">
                    <strong class="title_td" style="">Date and time outage is required:</strong>
                </td>
                
                <td>
                  <?= date("d F, Y H:i:a",strtotime($outage->outage_request_date)) ?>
                   
                </td>
            </tr>
            <tr class="item">
                <td class="title_td">
                    <strong class="title_td" style="">Request Officer Name:</strong>
                </td>
                
                <td>
                     <?= $outage->oro_fname.' '.$outage->oro_lname ?>
                </td>
            </tr>
            <tr class="item">
                <td class="title_td">
                    <strong class="title_td" style="">Request Officer Designation:</strong>
                </td>
                
                <td>
                     <?= $outage->oro_desig ?>
                </td>
            </tr>
            <tr class="item">
                <td class="title_td">
                    <strong class="title_td" style="">Permit Holder Name:</strong>
                </td>
                
                <td>
                    <?= $outage->permit_holder_lname.' '.$outage->permit_holder_fname ?>
                </td>
            </tr>
          
            <?php
            if (!empty($outage->request_from) && $outage->request_from!=7) {
              //request is from ibc
              ?>
                 <tr class="item">
                <td class="title_td">
                    <strong class="title_td" style="">Feeder manager Approval:</strong>
                </td>
                
                <td>
             <?php
              if ($outage->status==0 && $outage->reject_by=="FEEDER MANAGER") {
                //hibc rejected
                ?>
                <span style="color:red">REJECTED</span>(<?= date("d F, Y H:i:a",strtotime($outage->hibc_approve_date)).' '.$outage->reject_fname.' '.$outage->reject_lname ?>) <br/>
                <?= $outage->rejection_reason ?>
                <?php
              }elseif ($outage->status==2) {
                # hibc has not respond
                echo "NO RESPONSE YET";
              }elseif($outage->status>=3){
                ?>
                <span style="color:green">APPROVED</span>(<?= date("d F, Y H:i:a",strtotime($outage->hibc_approve_date)).' '.$outage->fd_fname.' '.$outage->fdlname ?>)
                <?php
              }
             ?> 


                </td>
            </tr>
            	<tr class="item">
                <td class="title_td">
                    <strong class="title_td" style="">NETWORK MANGER ACK.:</strong>
                </td>
                
                <td>
                    <?= (empty($outage->tsm_id))?'NOT ACKNOWLEDGED':''.$outage->tsm_fname.' '.$outage->tsm_lname. '  '.date("d F, Y H:i:a",strtotime($outage->tsm_ack_date)) ?> 
                </td>
            </tr>
          <?php }else{
            ?>
          
             <tr class="item">
                <td class="title_td">
                    <strong class="title_td" style="">HT COORDINATOR ACK.:</strong>
                </td>
                
                <td>
                    <?= (empty($outage->ht_cord_id))?'NOT ACKNOWLEDGED':''.$outage->htcor_fname.' '.$outage->htcor_lname. '  '.date("d F, Y H:i:a",strtotime($outage->ht_cord_ack_date)) ?> 
                </td>
            </tr>
            <?php
          } ?>
         
             <tr class="item">
                <td class="title_td">
                    <strong class="title_td" style="">HSO Approval:</strong>
                </td>
                
                <td>
                  <?php
             	if ($outage->status==0 &&  $outage->reject_by=="HSO") {
             		//hso rejected
             		?>
             		<span style="color:red">REJECTED</span>(<?= date("d F, Y H:i:a",strtotime($outage->hso_approve_date)).' '.$outage->reject_fname.' '.$outage->reject_lname ?>)<br/>
             		<?= $outage->reason_rejection ?>
             		<?php
             	}elseif ($outage->status==4) {
             		# hso has not respond
             		echo "NO RESPONSE YET";
             	}elseif($outage->status>=5){
             		?>
             		<span style="color:green">APPROVED</span>(<?= date("d F, Y H:i:a",strtotime($outage->hso_approve_date)).' '.$outage->hso_fname.' '.$outage->hsolname  ?>)
             		<?php
             	}
             ?>	
                </td>
            </tr>
            <tr class="item">
                <td class="title_td">
                    <strong class="title_td" style="">COORDINATOR CENTRAL DISPATCH:</strong>
                </td>
                
                <td>
                    <?php
                      if ($outage->status==0 &&  $outage->reject_by=="Central dispatch") {
                //hso rejected
                ?>
                <span style="color:red">REJECTED</span>(<?= date("d F, Y H:i:a",strtotime($outage->hso_approve_date)).' '.$outage->reject_fname.' '.$outage->reject_lname ?>)<br/>
                <?= $outage->reason_rejection ?>
                <?php
              }elseif ($outage->status==5) {
             		
             		echo "NO RESPONSE YET";
             	}elseif($outage->status>=4){
             		?>
             		<span style="color:green">APPROVED</span>(<?= date("d F, Y H:i:a",strtotime($outage->hso_approve_date)).' '.$outage->dispatch_fname.' '.$outage->dispatch_lname  ?>)
             		<?php
             	}
             ?>	
                </td>
            </tr>
            <?php 
            if ($outage->voltage_level=="11kv") {
              ?>
              <tr class="item">
                <td class="title_td">
                    <strong class="title_td" style="">DSO</strong>
                </td>
                
                <td>
                    <?php
                      if ($outage->status==0 &&  $outage->reject_by=="DSO") {
                //hso rejected
                ?>
                <span style="color:red">REJECTED</span>(<?= date("d F, Y H:i:a",strtotime($outage->hso_approve_date)).' '.$outage->reject_fname.' '.$outage->reject_lname ?>)<br/>
                <?= $outage->reason_rejection_hso ?>
                <?php
              }elseif ($outage->status==5) {
                
                echo "NO RESPONSE YET";
              }elseif($outage->status>=6){
                ?>
                <span style="color:green">APPROVED</span>(<?= date("d F, Y H:i:a",strtotime($outage->tso_approve_date)).' '.$outage->dso_fname.' '.$outage->dso_lname ?>)
                <?php
              }
             ?> 
                </td>
            </tr>
              <?php
            } else {
              ?>
               <tr class="item">
                <td class="title_td">
                    <strong class="title_td" style="">Transmission Operator</strong>
                </td>
                
                <td>
                  
                </td>
            </tr>
              <?php
            } ?>
            
            
            	
           
         
            <tr class="total">
                <td></td>
                
                <td>
                   <!-- Total: $385.00 -->
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
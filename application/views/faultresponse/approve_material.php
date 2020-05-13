<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript">
        window.BASE_URL="<?= base_url() ?>"
    </script>
    <style>
        #loader_submit {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  width: 100%;
  background: rgba(0,0,0,0.75) url(<?php echo asset_url();?>img/small.gif) no-repeat center center;
  z-index: 10000;
}
    	.title_td:{
    		font-weight: bold;
    		color: #375fb3
    	}
    .invoice-box {
        max-width: 1100px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
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
    <div id="loader_submit"></div>
    <div class="invoice-box">
         <a style="color: red" href="<?= base_url('FaultResponse/store_manager'); ?>">< Back</a> 
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
                                BILL OF QUANTITIES<br>
                                
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
            
            
        </table>
        
            
        <form id="approve_boq_material" data-id="<?= $outage->outage_id ?>">
        	<table id="container_div" class="table table-bordered">
                <thead>
                    <th>S.N</th>
                    <th>Item</th>
                    <th>Unit of Material</th>
                    <th>Quantity</th>
                    <th>Unit cost</th>
                   
                    <th>Available Qty</th>
                    
                </thead>
        <tbody>
            <?php

                foreach ($boqs as $key => $boq) {
                    ?>
                    <tr>
                        <td><?= $key+1 ?></td>
                        <td>
                            <?= $boq->name ?>
                            
                            <input type="hidden" name="boq_id[]" value="<?= $boq->bid ?>">
                        </td>
                       <td><?= $boq->unit ?></td>
                       <td><?= $boq->quantity ?></td>
                       <td><?= $boq->cost ?></td>
                        <td>
                            
                            <input type="hidden" name="outage_id" value="<?= $outage->outage_id ?>">
                           <!--  <input type="checkbox" value="<?= $boq->bid ?>"  name="available[]"> -->
                            <input type="number" value="<?= $boq->quantity ?>" name="quantity[]">
                           
                        </td>
                    </tr>
        <?php
            }
        ?>
        </tbody>
       
         
    </table>
     <button type="submit" id="<?= $outage->outage_id ?>" class="btn  btn-outline-success">Submit</button>
  </form>
</div>

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
     <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
    <script src="<?php echo asset_url();?>js/boq.js"></script>
</body>
</html>
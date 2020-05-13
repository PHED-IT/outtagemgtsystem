<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
     <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
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
    <div class="invoice-box">
        <!-- <a href="">< Back</a> -->
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
                                PREPARE BILL OF QUANTITIES<br>
                                
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
        <form id="boq_form">
            <input type="hidden" name="outage_id" value="<?= $outage->outage_id ?>">
            <div id="loader_submit"></div>
            <button id="add_component" type="button" class="btn btn-primary btn-outline-primary my-2"><span class="fa fa-plus"></span></button>
            <div id="container_div">
        <div class="row">
            <div class="col-5">
                  <div class="form-group">
                        <label class="col-form-label" for="reading"> Enter Item</label>
                        <input type="text" class="form-control materials" name="item[]">
                       <!--  <input type="hidden" class="form-control it" name="item[]"> -->
                    </div>
            </div>
             <div class="col-2">
                  <div class="form-group">
                        <label class="col-form-label" for="reading"> Unit of Material</label>
                        <input type="text" class="form-control unit" name="unit[]">
                    </div>
            </div>
            <div class="col-2">
                  <div class="form-group">
                        <label class="col-form-label" for="reading"> Qty.</label>
                        <input type="number" class="form-control" name="quantity[]">
                    </div>
            </div>
            <div class="col-3">
                  <div class="form-group">
                        <label class="col-form-label" for="reading"> Remark</label>
                        <input type="text" class="form-control" name="remark[]">
                    </div>
            </div>
            
        </div>
        <div class="row">
            <div class="col-5">
                  <div class="form-group">
                       
                        <input type="text" class="form-control materials" name="item[]">
                    </div>
            </div>
            <div class="col-2">
                  <div class="form-group">
                       
                        <input type="text" class="form-control unit" name="unit[]">
                    </div>
            </div>
            <div class="col-2">
                  <div class="form-group">
                       
                        <input type="number" class="form-control " name="quantity[]">
                    </div>
            </div>
            <div class="col-3">
                  <div class="form-group">
                        
                        <input type="text" class="form-control" name="remark[]">
                    </div>
            </div>
            
        </div>
         <div class="row">
            <div class="col-5">
                  <div class="form-group">
                       
                        <input type="text" class="form-control materials" name="item[]">
                    </div>
            </div>
             <div class="col-2">
                  <div class="form-group">
                       
                        <input type="text" class="form-control unit" name="unit[]">
                    </div>
            </div>
            <div class="col-2">
                  <div class="form-group">
                       
                        <input type="number" class="form-control" name="quantity[]">
                    </div>
            </div>
            <div class="col-3">
                  <div class="form-group">
                        
                        <input type="text" class="form-control" name="remark[]">
                    </div>
            </div>
            
        </div>
    </div>
        <button type="submit" id="$outage->outage_id ?>" class="btn  btn-outline-success">Submit</button>
    </form>
</div>

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
     <script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
    
    <script src="<?php echo asset_url();?>js/boq.js"></script>
</body>
</html>
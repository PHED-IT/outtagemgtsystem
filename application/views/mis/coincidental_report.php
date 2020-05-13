<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    
  <link rel="stylesheet" href="<?php echo asset_url();?>css/app.min.css">
  <!-- Template CSS -->

  <link rel="stylesheet" href="<?php echo asset_url();?>css/style.css">
  <link rel="stylesheet" href="<?php echo asset_url();?>css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="<?php echo asset_url();?>css/custom.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

     <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.25/daterangepicker.min.css" rel="stylesheet" type="text/css"> -->
   
     
    
    <script type="text/javascript">
        window.BASE_URL="<?= base_url() ?>"
    </script>
  
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css"> -->
    <link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
     <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css"> 
   <style type="text/css">
        .buttons-html5{
      position: relative;
    display: inline-block;
    box-sizing: border-box;
    margin-right: 0.1em !important;
    margin-bottom: 0.1em !important;
    padding: 0.1em 0.1em !important;
    border: none !important;
    border-radius: 0px !important;
    cursor: pointer;
    font-size: 1em !important;
    line-height: 1.6em;
    color: #6777ef !important;
    white-space: nowrap;
    overflow: hidden;
    background-color: transparent !important;
    outline: none !important;
    background: transparent!important;
    }
   </style>
</head>

<body>

        <section class="section ">
          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-11 col-lg-11" >
                <div class="card">
                  <div class="card-header">
                    <h4><?= $title ?></h4>
                  </div>
                  <div class="card-body">
                   
                        <?php  echo isset($summary)?$summary:""; ?>
                   
                  </div>
                  
                </div>
              </div>
          </div>
      </div>
  </section>


    <!-- General JS Scripts -->
  <script src="<?php echo asset_url();?>js/app.min.js"></script>
  
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
  <!-- Template JS File -->
  <script src="<?php echo asset_url();?>js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="<?php echo asset_url();?>js/custom.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    
   
    
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> 
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.15/js/jquery.dataTables.min.js"></script> -->
    <script type="text/javascript" src="http://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> -->
 <!--    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script> -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.time.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.1.1/trix.js"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script src="<?php echo asset_url();?>js/chart.js"></script>
    <script src="<?php echo asset_url();?>js/MonthPicker.min.js"></script>
    <script src="<?php echo asset_url();?>js/site.js"></script>
</body>
</html>
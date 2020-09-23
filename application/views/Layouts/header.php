<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo asset_url();?>img/favicon.png"> 
    
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $title; ?></title>
    <!-- CSS -->
   <link href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
 
<link rel="stylesheet" href="<?php echo asset_url();?>css/app.min.css">
  <!-- Template CSS -->

  <link rel="stylesheet" href="<?php echo asset_url();?>css/style.css">
  <link rel="stylesheet" href="<?php echo asset_url();?>css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="<?php echo asset_url();?>css/custom.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

     <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.25/daterangepicker.min.css" rel="stylesheet" type="text/css"> -->
   
     <!--  <script src="http://maps.google.com/maps/api/js?key=AIzaSyC223rsW34u3YLJWAeFvquz-lxUL-SOUuk&sensor=false" 
          type="text/javascript"></script>  --> 
    
    <script type="text/javascript">
        window.BASE_URL="<?= base_url() ?>"
    </script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css"> -->
    <link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
     <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.1.1/trix.css" />
    <link rel="stylesheet" href="<?php echo asset_url();?>bundles/pretty-checkbox/pretty-checkbox.min.css">
     <link rel="stylesheet" href="<?php echo asset_url();?>css/MonthPicker.min.css">  
      <link rel="stylesheet" href="<?php echo asset_url();?>/bundles/izitoast/css/iziToast.min.css">
      <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <style type="text/css">
     
        #map {
        height: 300px;  /* The height is 400 pixels */
        width: 100%;  /* The width is the width of the web page */
       }
         .ui-datepicker-calendar {
        display: none;
        }
        #doublescroll
        {
          overflow: auto; overflow-y: hidden; 
        }
        .btn-td{
            outline: none;
            cursor: pointer;
            display: block;
            
        }
        .date_picker{

        }
        .max {
  color: green
}

.min {
  color: "#000"
}
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


.modal-contents {
  border-radius: 0px;
  box-shadow: 0 0 20px 8px rgba(0, 0, 0, 0.7) !important;
}

.modal-backdrop.show {
  opacity: 0.75;
}


.loader_ss {
  position: relative;
  text-align: center;
  margin: 15px auto 35px auto;
  z-index: 9999;
  display: block;
  width: 80px;
  height: 80px;
  border: 10px solid rgba(0, 0, 0, .3);
  border-radius: 50%;
  border-top-color: #000;
  animation: spin 1s ease-in-out infinite;
  -webkit-animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
  to {
    -webkit-transform: rotate(360deg);
  }
}

@-webkit-keyframes spin {
  to {
    -webkit-transform: rotate(360deg);
  }
}

/*.modal-backdrop {
  z-index: -1;
}*/
.modal-dialog {
    z-index: 1000 !important;
  }

  .modal {
    z-index: 1000 !important;
  }
    .modal-backdrop {
    /* bug fix - no overlay */    
    display: none;    
}
.section{
  z-index: 0;
  position: initial;

}
  .header-logo {
    height: 78px !important;
}
/*.modal-backdrop{z-index: 1500 !important;}
.modal{z-index: 1500 !important;}*/
fieldset.scheduler-border {
    border: 1px groove #6777ef !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
}

    legend.scheduler-border {
        font-size: 1.2em !important;
        font-weight: bold !important;
        text-align: left !important;
        width:auto;
        padding:0 10px;
        border-bottom:none;
    }

    .log_input{
      width: 64px;
      padding-left: 5px
    }

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

  /*  .myclass  {
    table-layout: auto !important;
}*/

/*table{
   text-align: left;
  position: relative;
  border-collapse: collapse; 
}*/
  
th{
   /* background: white;
  position: sticky;
  top: 0;*/
  box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
}

/*tbody {
    display: block;
    overflow: auto;
    width: 100% !important;
    height:500px;
    
  }*/
  
.tables{
  /*table-layout:fixed !important;*/
   /*position: relative;*/
  /*border-collapse: collapse; */
}
.td{
  white-space:nowrap !important;
  text-align: right !important;

}

select{
        width: 100%;
      }

      .table-scroll {
  position:relative;
  /*max-width:600px;*/
  margin:auto;
  overflow:hidden;
  border:1px solid #000;
}




.table-wrap {
  width:100%;
  overflow:auto;
}
.table-scroll table {
  width:100%;
  margin:auto;
  border-collapse:separate;
  border-spacing:0;
}
.table-scroll th, .table-scroll td {
  padding:5px 10px;
  border:1px solid #000;
  background:#fff;
  white-space:nowrap;
  vertical-align:top;
}
.table-scroll thead, .table-scroll tfoot {
  background:#f9f9f9;
}
.clone {
  position:absolute;
  top:0;
  left:0;
  pointer-events:none;
}
.clone th, .clone td {
  visibility:hidden
}
.clone td, .clone th {
  border-color:transparent
}
.clone tbody th {
  visibility:visible;
  color:red;
}
.clone .fixed-side {
  border:1px solid #000;
  background:#eee;
  visibility:visible;
}
.clone thead, .clone tfoot{background:transparent;}
    </style>
</head>

<body>
    <!-- <div class="loader"></div> -->
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar sticky" style="z-index: 1">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
                                    collapse-btn"> <i data-feather="align-justify"></i></a></li>
            <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                <i data-feather="maximize"></i>
              </a></li>
            <li>
              <form class="form-inline mr-auto">
                <div class="search-element">
                  <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="200">
                  <button class="btn" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </form>
            </li>
          </ul>
        </div>
        <ul class="navbar-nav navbar-right">
         <!--  <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
              class="nav-link nav-link-lg message-toggle"><i data-feather="mail"></i>
              <span class="badge headerBadge1">
                0 </span> </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
              <div class="dropdown-header">
                Messages
                <div class="float-right">
                  <a href="#">Mark All As Read</a>
                </div>
              </div>
              
              
            </div>
          </li> -->
           
          <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
              class="nav-link notification-toggle nav-link-lg"><i data-feather="bell" class="bell"></i>
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
              <div class="dropdown-header">
                Notifications
                <div class="float-right">
                  <a href="#">Mark All As Read</a>
                </div>
              </div>
              
            </div>
          </li>

          <li class="dropdown"><a href="#" data-toggle="dropdown"
              class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <img alt="image" src="<?php echo asset_url();?>demo/user.png"
                class="user-img-radious-style"> <span class="d-sm-none d-lg-inline-block"></span></a>
            <div class="dropdown-menu dropdown-menu-right pullDown">
              <div class="dropdown-title">Welcome</div>
               <a href="<?= base_url('home/change_password') ?>" class="dropdown-item has-icon"> <i class="fas fa-cog"></i>
                Change password
              </a>
              <div class="dropdown-divider"></div>
              <a href="<?= base_url('auth/logout') ?>" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
                Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>

      <div class="main-sidebar sidebar-style-2" >
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="">  <img alt="image"  src="<?php echo asset_url();?>img/rsz_1logo.png"  class="header-logo" />
                <span
                class="logo-name" style="color: #3367b8"> <img alt="image"  src="<?php echo asset_url();?>img/rsz_2logo.png"  class="" /></span>
            </a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown ">
              <a href="<?= base_url('home/index') ?>" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            <?php
             echo $menus;

            ?>
        </ul>
      </aside>
  </div>
 <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row">
              
              <div class="col-12 col-md-12 col-lg-12">
                <?php $this->load->view('Flash_alert/alert'); ?>
       
        <!-- HEADER & TOP NAVIGATION -->
       
    <!-- /.navbar -->
    
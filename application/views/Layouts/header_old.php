<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <!-- <link rel="icon" type="image/png" sizes="16x16" href="<?php //echo asset_url();?>img/favicon.png"> -->
    <link rel="stylesheet" href="<?php echo asset_url();?>css/pace.css">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $title; ?></title>
    <!-- CSS -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600%7CRoboto:400" rel="stylesheet" type="text/css">
   
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/0.7.0/css/perfect-scrollbar.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick-theme.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css" rel="stylesheet" type="text/css"> -->

     <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.25/daterangepicker.min.css" rel="stylesheet" type="text/css">
   <link href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo asset_url();?>css/MonthPicker.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo asset_url();?>css/style.css" rel="stylesheet" type="text/css">
    <link href="<?php echo asset_url();?>css/mdb.min.css" rel="stylesheet" type="text/css">
    <!-- Head Libs -->
   <!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script> -->
    <script data-pace-options='{ "ajax": false, "selectors": [ "img" ]}' src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>
    <script type="text/javascript">
        window.BASE_URL="<?= base_url() ?>"
    </script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css"> -->
    <link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.0/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.1.1/trix.css" />
    <link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/plug-ins/1.10.20/integration/font-awesome/dataTables.fontAwesome.css">
    <style type="text/css">
        body{
            color: #333 !important;
        }
        table{
            color: #333 !important
        }
        thead{
            background-color: #1a232d;
            color:#ffffff;
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

#simpleTable > thead > tr > th[class*="sort"]:after{
    content: "" !important;
}

    </style>
</head>

<body class="sidebar-dark sidebar-expand navbar-brand-dark header-light">
    <div id="wrapper" class="wrapper">
        <!-- HEADER & TOP NAVIGATION -->
        <nav class="navbar">
            <!-- Logo Area -->
            <div class="navbar-header">
                <a href="/" style="font-weight: bold;font-size: 20px" class="navbar-brand">
                   <!--  <img class="logo-expand" alt="" src="<?php //echo asset_url();?>img/logo-dark.png"> -->
                    <!-- <img class="logo-collapse" alt="" src="<?php //echo asset_url();?>img/logo-collapse.png"> -->
                    PHED
                    <!-- <p>BonVue</p> -->
                </a>
            </div>
            <!-- /.navbar-header -->
            <!-- Left Menu & Sidebar Toggle -->
            <ul class="nav navbar-nav">
                <li class="sidebar-toggle dropdown"><a href="javascript:void(0)" class="ripple"><i class="  fa fa-bars list-icon fa-2x"></i></a>
                </li>
            </ul>
            <!-- /.navbar-left -->
            <!-- Search Form -->
            <form class="navbar-search d-none d-sm-block" role="search"><i class="feather feather-search list-icon"></i> 
                <input type="search" class="search-query" placeholder="Search anything..."> <a href="javascript:void(0);" class="remove-focus"><i class="feather feather-x"></i></a>
            </form>
            <!-- /.navbar-search -->
            <div class="spacer"></div>
            <!-- Right Menu -->
            <ul class="nav navbar-nav d-none d-lg-flex ml-2 ml-0-rtl">
               
                <!-- /.dropdown -->
                <li><a href="javascript:void(0);" class="right-sidebar-toggle"><i class="feather feather-settings list-icon"></i></a>
                </li>
            </ul>
            <!-- /.navbar-right -->
            <!-- User Image with Dropdown -->
            <ul class="nav navbar-nav">
                <li class="dropdown"><a href="javascript:void(0);" class="dropdown-toggle dropdown-toggle-user ripple" data-toggle="dropdown"><span class="avatar thumb-xs2"><img src="<?php echo asset_url();?>demo/user.png" class="rounded-circle" alt=""> <i class="feather feather-chevron-down list-icon"></i></span><span class="ml-2 font-weight-bold text-capitalize"><?= $user_role ?></span></a>
                    <div
                    class="dropdown-menu dropdown-left dropdown-card dropdown-card-profile animated flipInY">
                        <div class="card">
                          <!--   <header class="card-header d-flex mb-0"><a href="javascript:void(0);" class="col-md-4 text-center"><i class="feather feather-user-plus align-middle"></i> </a><a href="javascript:void(0);" class="col-md-4 text-center"><i class="feather feather-settings align-middle"></i> </a>
                                <a
                                href="javascript:void(0);" class="col-md-4 text-center"><i class="feather feather-power align-middle"></i>
                                    </a>
                            </header> -->
                            <ul class="list-unstyled card-body">
                                
                                <li><a href="<?= base_url('home/change_password'); ?>"><span><span class="align-middle">Change Password</span></span></a>
                                </li>
                                
                                <li><a href="<?= base_url('auth/logout'); ?>"><span><span class="align-middle">Sign Out</span></span></a>
                                </li>
                            </ul>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
    </div>
    <!-- /.dropdown-card-profile -->
    </li>
    <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-nav -->
    </nav>
    <!-- /.navbar -->
    <div class="content-wrapper">
        <!-- SIDEBAR -->
        <aside class="site-sidebar scrollbar-enabled" data-suppress-scroll-x="true">
            <!-- User Details -->
            <div class="side-user d-none">
                <div class="col-sm-12 text-center p-0 clearfix">
                    <div class="d-inline-block pos-relative mr-b-10">
                        <figure class="thumb-sm mr-b-0 user--online">
                            <img src="<?php echo asset_url();?>demo/users/user1.jpg" class="rounded-circle" alt="">
                        </figure><a href="page-profile.html" class="text-muted side-user-link"><i class="feather feather-settings list-icon"></i></a>
                    </div>
                    <!-- /.d-inline-block -->
                    <div class="lh-14 mr-t-5"><a href="page-profile.html" class="hide-menu mt-3 mb-0 side-user-heading fw-500">Scott Adams</a>
                        <br><small class="hide-menu">Developer</small>
                    </div>
                </div>
                <!-- /.col-sm-12 -->
            </div>
            <!-- /.side-user -->
            <!-- Call to Action -->
            <!-- <div class="side-content mr-t-30 mr-lr-15"><a class="btn btn-block btn-success ripple fw-600" href="#"><i class="fa fa-plus-square-o mr-1 mr-0-rtl ml-1-rtl"></i> Add user</a>
            </div> -->
            <!-- Sidebar Menu -->
            
            <nav class="sidebar-nav">
                <ul class="nav in side-menu">
                    <li class="current-page menu-item"><a href="<?php echo base_url(); ?>"><i class="list-icon fa fa-dashboard"></i> <span class="hide-menu">Dashboard</span></a>
                        
                    </li>
                   <?php
                  	echo $menus;

                   ?>
                  
                </ul>
                <!-- /.side-menu -->
            </nav>
            <!-- /.sidebar-nav -->
        </aside>
        <!-- /.site-sidebar -->
        <main class="main-wrapper clearfix">
        	<!-- <pre>
            	 <?php //print_r($menus); ?> 
            </pre> -->
        	
        	<?php $this->load->view('Flash_alert/alert'); ?>
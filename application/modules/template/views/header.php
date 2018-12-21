<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        <?php echo ($pageTitle) ? $pageTitle : 'CRM RS'; ?>
    </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="baseUrl" content="<?php echo base_url(); ?>">
    <link rel="shortcut icon" href="<?php echo $this->config->item('assets'); ?>dist/img/avatar.png" type="image/x-icon">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo $this->config->item('assets'); ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo $this->config->item('assets'); ?>bower_components/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="<?php echo $this->config->item('assets'); ?>bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo $this->config->item('assets'); ?>bower_components/Ionicons/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo $this->config->item('assets'); ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo $this->config->item('assets'); ?>dist/css/AdminLTE.min.css">
    <!-- Customize style -->
    <link rel="stylesheet" href="<?php echo $this->config->item('assets'); ?>dist/css/crm.css">
    <!--  Alertify style -->
    <link rel="stylesheet" href="<?php echo $this->config->item('assets'); ?>vendor/alertify/css/alertify.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo $this->config->item('assets'); ?>dist/css/skins/_all-skins.min.css">
    <!-- sematic -->
    <link rel="stylesheet" href="<?php echo $this->config->item('assets'); ?>bower_components/semantic/semantic.css">


    <?php
foreach ($linksStyleSheet as $value) {
    echo '<link href="' . $value . '"/>' . PHP_EOL;
}
?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="<?php echo base_url(); ?>" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <!-- <span class="logo-mini"><b>C</b>RM</span> -->
                <!-- logo for regular state and mobile devices -->
                <!-- <span class="logo-lg"><b>CRM</b>RS</span> -->
                <img src="<?php echo $this->config->item('assets');?>/dist/img/logoRs.png" alt="logo">
                <!-- <span class=""></span> -->
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">

                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?php echo $this->config->item('assets'); ?>dist/img/avatar.png" class="user-image"
                                    alt="User Image">
                                <span class="hidden-xs">
                                    <?php echo $users = $this->session->name; ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="<?php echo $this->config->item('assets'); ?>dist/img/avatar.png" class="img-circle"
                                        alt="User Image">
                                    <p>
                                        <?php echo $users = $this->session->name; ?>
                                        <small>
                                            <?php echo date('Y-m-d H:i:s'); ?></small>
                                    </p>
                                </li>

                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?php echo base_url('users/change_password'); ?>" class="btn btn-default btn-flat">
                                            <i class="fa fa-sign-out"></i> Change Password</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo base_url('users/logout'); ?>" class="btn btn-default btn-flat">
                                            <i class="fa fa-sign-out"></i> &nbsp;Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <!-- Control Sidebar Toggle Button -->
                        <!-- <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> -->
                    </ul>
                </div>
            </nav>
        </header>

        <?php $this->load->view('template/sidebar');?>
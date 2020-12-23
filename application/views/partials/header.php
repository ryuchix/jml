<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->config->item('site_info')['company_name'];?> | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"> -->
    <!-- <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/font-awesome.min.css'); ?>"> -->
    <!-- Ionicons -->
    <!-- <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/ionicons.min.css'); ?>"> -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	 <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/toastr/toastr.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Animate.css style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/animate.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css?v=<?php echo $this->config->item('asset_version'); ?>">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css">
    
    <script src="https://use.fontawesome.com/80e53a0339.js"></script>

    <style>
        .form-group.has-error .error-msg {
            color: #dd4b39;
            font-weight: bold;
            font-size: 12px;
        }
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

 <body class="skin-green sidebar-mini">
    <div class="wrapper">

      <header class="main-header">

        <!-- Logo -->
        <a href="<?php echo site_url(); ?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><?php echo $this->config->item('site_info')['company_name'];?></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b><?php echo $this->config->item('site_info')['company_name'];?></b></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
             
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="<?php echo site_url( 'users/profile' ); ?>">
                  <?php if ($this->session->userdata('dp')): ?>
                    <img src="<?php echo base_url('uploads/profile_images/'.$this->session->userdata('dp'));?>" class="user-image" alt="User Image">
                  <?php endif ?>
                  <span class="hidden-xs"><?php echo $this->session->userdata('fullname'); ?></span>
                </a>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <a href="<?php echo site_url( 'users/logout' ); ?>"><i class="fa fa-sign-out"></i></a>
              </li>
            </ul>
          </div>

        </nav>
      </header>
 
	  <?php 
	  //echo "hello".$this->session->userdata('user_id');
      // x($this->session->userdata());
      // if ($this->session->userdata('user_id')==1)
      //     $this->session->set_userdata('user_role', 2);
      // if ($this->session->userdata('user_role')==ADMIN_ROLE) {
      //   x("You are the Admin");
      // }else{
      //   x("You are not the Admin");
      // }

    ?>

	  <?php $this->load->view('partials/navigation');?>


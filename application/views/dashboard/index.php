<?php $this->load->view( 'partials/header' ); ?>

<!-- Morris charts -->
<link rel="stylesheet" href="<?php echo site_url( 'assets/plugins/morris/morris.css' ); ?>">

<style>
	.bg-blue-grey{
		background: #607D8B;
	}
	.bg-blue-grey .inner{
		color: #fff;
	}
	.bg-blue-grey .small-box-footer{
		background: #455A64;
	}

	.small-box.bg-green{
		background: #009688 !important;
	}
	.bg-green .inner{
		color: #fff;
	}
	.bg-green .small-box-footer{
		background: #00796B;
	}
	.users-list>li img{
		width: 125px;
		height: 125px;
	}

/**************************** Weather Location ****************************/


#setting {
  margin: 20px 0;
}

#display {
	padding: 20px 16px 24px 16px;
	box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.16), 0 0 0 1px rgba(0, 0, 0, 0.08);
	background: white;
	margin-bottom: 20px;
	display: none;
}

#top {
  	margin-bottom: 20px;
}

#top .location {
	font-size: 24px;
	line-height: 1.2;
}

#top .time {
	font-size: 16px;
	line-height: 2;
}

#top .status {
	font-size: 13px;
	line-height: 1.4
}

#left-information {
  	color: #212121;
}

#left-information .thumbnail {
	float: left;
	height: 100px;
	width: 100px;
}

#left-information .temperature {
	float: left;
	margin-top: -3px;
	padding-left: 10px;
	font-size: 64px;
}

#left-information .unit {
	float: left;
	margin-top: 6px;
	font-size: 20px;
}

#right-information {
	/*float: right;*/
	/*padding-left: 5px;*/
	line-height: 22px;
	/*padding-top: 2px;*/
	/*min-width: 43%;*/
	font-weight: lighter;
}

#forecast {
	padding-top: 10px;
	clear: both;
    text-align: center;
}

#forecast ul {
	padding: 0;
	margin: 15px 0 5px 0;
}

#forecast ul li {
	display: inline-block;
	height: 90px;
	width: 73px;
	text-align: center;
	line-height: 1;
}
.small-box .ion img {
    width: 100px;
    opacity: 0.3;
    position: relative;
    top: -7px;
    right: -7px;
}

</style>


<div class="content-wrapper">

	<!-- Content Header (Page header) -->

	<section class="content-header">

		<h1>Dashboard <small>Version <?php echo $this->config->item('site_info')['version']; ?></small></h1>

		<ol class="breadcrumb">
			
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

			<li class="active">Dashboard</li>

		</ol>

	</section>

	<!-- Main content -->
	<section class="content">

		<?php $this->load->view('dashboard/widget'); ?>

		<?php $this->load->view('dashboard/rego_table'); ?>

		<?php $this->load->view('dashboard/equipment_table'); ?>

		<?php $this->load->view('dashboard/daily_balances_progress'); ?>

		<?php if( has_access('dashboard') ): ?>

		<div class="row">

			<div class="col-md-6">
              	
              	<!-- USERS LIST -->
              	<div class="box box-danger">

	                <div class="box-header with-border">

	                  	<h3 class="box-title">Upcoming Birthdays</h3>

	                  	<div class="box-tools pull-right">

	                    	<span class="label label-danger"><?php echo count($bday_users) ?> events</span>

	                    	<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	                    	
	                    	<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
	                  	
	                  	</div>

	                </div><!-- /.box-header -->

                	<div class="box-body no-padding">

                  		<ul class="users-list clearfix">

                 			<?php foreach ($bday_users as $user): ?>

	                    	<li>

	                    		<?php if ( file_exists("./uploads/profile_images/$user->image") && $user->image ): ?>

	                      			<img src="<?php echo base_url("uploads/profile_images/$user->image"); ?>" alt="User Image">
	                    		
	                    		<?php else: ?>
	                      		
	                      			<img src="<?php echo base_url("uploads/profile_images/user-placeholder.jpg"); ?>" alt="User Image">
	                    		
	                    		<?php endif; ?>
	                      		
	                      		<a class="users-list-name" href="<?php echo site_url( "users/view/$user->id" ); ?>" target="_blank">
	                      		
	                      			<?php echo $user->first_name .' '. $user->last_name; ?>
	                      		
	                      		</a>
	                      			
	                      		<span class="users-list-date"><?php echo local_date($user->dob); ?></span>

	                    	</li>

                 			<?php endforeach ?>

                  		</ul><!-- /.users-list -->

                	</div><!-- /.box-body -->

                	<div class="box-footer text-center">

                  		<a href="<?php echo site_url( 'users' ); ?>" class="uppercase">View All Users</a>

                	</div><!-- /.box-footer -->

              	</div><!--/.box -->

            </div>

		</div>

		<?php endif; ?>

	</section>

</div>

<?php $this->load->view( 'partials/footer' ); ?>

<!-- Morris charts -->
<script src="<?php echo site_url( 'assets/plugins/raphael/raphael.min.js' ); ?>"></script>
<script src="<?php echo site_url( 'assets/plugins/morris/morris.min.js' ); ?>"></script>
<script src="<?php echo site_url( 'assets/dist/js/image-preview.js' ); ?>"></script>
<script src="<?php echo site_url( 'assets/dist/js/dashboard-weather.js' ); ?>"></script>
<script src="<?php echo site_url( 'assets/dist/js/dashboard-balance-chart.js' ); ?>"></script>

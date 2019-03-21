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

@media only screen and (max-width: 800px) {
	
	/* Force table to not be like tables anymore */
	.no-mobile-tables table, 
	.no-mobile-tables thead, 
	.no-mobile-tables tbody, 
	.no-mobile-tables th, 
	.no-mobile-tables td, 
	.no-mobile-tables tr { 
		display: block; 
	}
 
	/* Hide table headers (but not display: none;, for accessibility) */
	.no-mobile-tables thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
 
	.no-mobile-tables tr { border: 1px solid #ccc; }
 
	.no-mobile-tables td { 
		/* Behave  like a "row" */
		border: none;
		border-bottom: 1px solid #eee; 
		position: relative;
		padding-left: 50%; 
		white-space: normal;
		text-align:left;
	}
 
	.no-mobile-tables td:before { 
		/* Now like a table header */
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;
		text-align:left;
		font-weight: bold;
	}
 
	/*
	Label the data
	*/
	.no-mobile-tables td:before { content: attr(data-title); }
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

		<?php $this->load->view('dashboard/pending_gallery_table'); ?>

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
<script>

$('.propcess-gallery').on('click',function(e){
	e.preventDefault();
	$link = $(this);
	$.ajax({
		url: './gallery/process',
		method: "POST",
		data: { 'id':$link.data('id') },
		success: function(data){
			$link.parents('tr').fadeOut(function(){ 
				$(this).remove();
				// alert($('.pendign-gallery').find('tr').length);
				if($('.pendign-gallery').find('tr').length === 1)
				{
					$('.pendign-gallery').append('<p align="center">No pending gallery</p>');
					$('.pendign-gallery table').remove();
				}
			})
		}
	});

});

$("#photoModel").on("show.bs.modal", function(e) {
	var $link = $(e.relatedTarget);
	$('#photoModelLabel').text( $link.parents('tr').find('td:eq(0)').text() );
	$(this).find(".modal-body").load($link.attr("href"));
});

$(function(){
    
    $("#rotate").on('click', function(e){
        var $btn = $(this).prop('disabled', true);
        var currentImg = $('#photoModel .modal-body').find('.item.active img');
        var index = $('#photoModel .modal-body').find('.item.active').index();
        var src = currentImg.attr('src');
        $.ajax({
            url: '<?php echo base_url('gallery/image_rotate') ?>',
            method: 'post',
            data: { img: src, index: index },
            success: function(data){
                $('#photoModel .modal-body').find('.item:eq('+ data.index +') img').attr('src', data.image);
                $btn.prop('disabled', false);
            },
            error: function(err){
                console.log(err);
            }
        });
        
    });
    
    /*$("#rotate").on('click', function(e){
        var $btn = $(this).prop('disabled', true);
        var currentImg = $('#photoModel .modal-body').find('.item.active img');
        var index = $('#photoModel .modal-body').find('.item.active').index();
        var src = currentImg.attr('src');
        $.ajax({
            url: 'http://api.jmlcleaningservices.com.au/galleries/rotate/image',
            method: 'post',
            data: { img: src, index: index },
            success: function(data){
                $('#photoModel .modal-body').find('.item:eq('+ data.index +') img').attr('src', '<?php echo base_url() ?>/' + data.image);
                $btn.prop('disabled', false);
            },
            error: function(err){
                console.log(err);
            }
        });
        
    });*/
    
});

</script>
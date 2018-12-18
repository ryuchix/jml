<?php $this->load->view( 'partials/header' ); ?>

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
    
        <h1>Reports</h1>
    
        <ol class="breadcrumb">
    
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    
            <li><a href="<?php echo site_url( 'reports' ); ?>"><i class="fa fa-file-o"></i> Reports</a></li>
    
        </ol>
    
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">

	        <div class="col-md-4">

				<div class="list-group">
				  	<a href="#!" class="list-group-item active">Users</a>

            		<?php if($controller->hasAccess('export-user')) : ?>
				  		<a href="<?php echo site_url('users/export'); ?>" class="list-group-item">Export Users</a>
				  	<?php endif;?>
				</div>
	            
	        </div>
	        <!-- /.col -->

	        <div class="col-md-4">

				<div class="list-group">
				  	
				  	<a href="#!" class="list-group-item active">Client Reports</a>
				  	
				  	<?php if ($controller->hasAccess('export-client')): ?>
				  	<a href="<?php echo site_url('client/export') ?>" class="list-group-item">Export Clients</a>
					<?php endif; ?>
				  	
				  	<?php if($controller->hasAccess('export-prospect')): ?>
				  	<a href="<?php echo site_url('client/export/prospects') ?>" class="list-group-item">Export Prospects</a>
				  	<?php endif; ?>
				  	
				  	<?php if($controller->hasAccess('client-report')): ?>
				  	<a href="<?php echo site_url('reports/client/filter') ?>" class="list-group-item">Client Reports</a>
				  	<?php endif; ?>

				  	<?php if ($controller->hasAccess('property-keys-report')): ?>
				  		<a href="<?php echo site_url('reports/properties/keys') ?>" class="list-group-item self-report">Properties Keys</a>
				  	<?php endif ?>

				  	<?php if ($controller->hasAccess('property-bins-report')): ?>
				  		<a href="<?php echo site_url('reports/properties/bins') ?>" class="list-group-item self-report">Proterties Bins</a>
				  	<?php endif ?>

				</div>
	            
	        </div>
	        <!-- /.col -->

	        <div class="col-md-4">

				<div class="list-group">
				  	
				  	<a href="#!" class="list-group-item active">Bin Liners Management</a>
				  	
				  	<?php if ($controller->hasAccess('export-bin-liner-management')): ?>
				  	<a href="<?php echo site_url('reports/bin-liner-management/filter') ?>" class="list-group-item">Bin Liner Management</a>
					<?php endif; ?>
				  	
				</div>
	            
	        </div>
	        <!-- /.col -->

        </div>
        <!-- /.row -->

        <div class="row">

	        <div class="col-md-4">

				<div class="list-group">
				  	<a href="#!" class="list-group-item active">Suppliers Councils Report</a>

            		<?php if($controller->hasAccess('export-suppliers')) : ?>
				  		<a href="<?php echo site_url('reports/suppliers/pdf'); ?>" class="list-group-item self-report">Export Suppliers</a>
				  	<?php endif;?>

					<?php if ($controller->hasAccess('export-councils')): ?>
						<a href="<?php echo site_url('reports/councils/pdf') ?>" class="list-group-item self-report">Export Councils</a>
					<?php endif ?>

				</div>
	            
	        </div>
	        <!-- /.col -->

	        <div class="col-md-4">

				<div class="list-group">
				  	
				</div>
	            
	        </div>
	        <!-- /.col -->

	        <div class="col-md-4">

				<div class="list-group">
				  	
				</div>
	            
	        </div>
	        <!-- /.col -->

        </div>
        <!-- /.row -->

    </section>

</div>

<?php $this->load->view( 'partials/footer' ); ?>

<!-- <a class="btn btn-primary" data-toggle="modal" href='#selfReportModal'>Trigger modal</a> -->
<div class="modal fade" id="selfReportModal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Report</h4>
			</div>
			<div class="modal-body">
				<div class="preloader-container">
                    <div class="preloader">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
				<iframe id="selfReportIframe" src="" frameborder="0" style="width: 100%; height: 550px;"></iframe>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<style>
@media (min-width: 992px){
    .modal-lg {
        width: 1280px;
    }
}
</style>
<script>
	$('.self-report').click(function(e) {
		e.preventDefault();
		
		$this = $(this);

		$("#selfReportModal .modal-title").text($this.text());

		$('.preloader-container').show();
		
		$('#selfReportModal').modal();
		
		$('#selfReportIframe').attr('src', $this.attr('href'))
		.load(function() {
            $('.preloader-container').hide();
        });
	});
</script>
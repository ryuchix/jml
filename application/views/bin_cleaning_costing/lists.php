<?php $this->load->view( 'partials/header' ); ?>

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
    
        <h1>Bin Cleaning Costing</h1>
    
        <ol class="breadcrumb">
    
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    
            <li class="active">Bin Cleaning Costing</li>
    
        </ol>
    
    </section>


    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs pull-right">
                              <li class="pull-left header"><a href="<?php echo site_url( "bin-cleaning-costing/create" ); ?>" style="display: inline;"><i class="fa fa-plus"></i></a> Bin Cleaning Costing List</li>
                            </ul>

                            <div class="tab-content">

                                <div class="tab-pane active" id="tab_1-1">

                                <?php $this->load->view("bin_cleaning_costing/table"); ?>
                                    
                                </div><!-- /.tab-pane -->
                                
                            </div><!-- /.tab-content -->
                        </div>
                        
                        
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
</div>
<?php $this->load->view( 'partials/footer' ); ?>

<script>


</script>
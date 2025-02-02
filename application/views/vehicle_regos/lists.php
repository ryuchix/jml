<?php $this->load->view( 'partials/header' ); ?>

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
    
        <h1>Vehicle Rego <small>list</small></h1>
    
        <ol class="breadcrumb">
    
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    
            <li><a href="<?php echo site_url( 'vehicle/' ); ?>"><i class="fa fa-car"></i> Vehicles</a></li>

            <li><a href="<?php echo site_url( "vehicle_rego/index/$vehicle_id" ); ?>"><i class="fa fa-fax"></i> Vehicle Rego</a></li>
    
            <li class="active">List</li>
    
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
                                
                                <li>
                                    <a href="#tab_1-1" data-toggle="tab" aria-expanded="true">&nbsp;</a>
                                </li>
                                
                                <li class="active" style="visibility: hidden;">
                                    <a href="#tab_2-2" data-toggle="tab" aria-expanded="false">&nbsp;</a>
                                </li>

                                <li class="pull-left header">
                                <?php if ($controller->hasAccess('add-vehicle-rego')): ?>
                                    <a href="<?php echo site_url( "vehicle_rego/save/$vehicle_id" ); ?>" style="display: inline;"><i class="fa fa-plus"></i></a> 
                                <?php endif ?> Rego
                                </li>

                            </ul>

                            <div class="tab-content">

                                <div class="tab-pane" id="tab_1-1">

                                </div><!-- /.tab-pane -->
                                
                                <div class="tab-pane active" id="tab_2-2">

                                    <?php $this->load->view('vehicle_regos/table', array('records'=>$records)); ?>
                                    
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

    $('.delete').on('click', function (e) {
        if (!confirm("do you really want to delete this record?")) { e.preventDefault(); }
    });

    $('.reactivate').on('click', function (e) {
        if (!confirm("do you really want to Reactivate this record?")) { e.preventDefault(); }
    });

</script>
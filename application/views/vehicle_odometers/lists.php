<?php $this->load->view( 'partials/header' ); ?>

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
    
        <h1>Vehicle Odometer <small>list</small></h1>
    
        <ol class="breadcrumb">
    
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    
            <li><a href="<?php echo site_url( 'vehicle/' ); ?>"><i class="fa fa-car"></i> Vehicles</a></li>

            <li><a href="<?php echo site_url( "odometer/lists/$vehicle_id" ); ?>"><i class="fa fa-fax"></i> Vehicle Odometer</a></li>
    
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
                              <li class="pull-left header"><a href="<?php echo site_url( "odometer/save/$vehicle_id" ); ?>" style="display: inline;"><i class="fa fa-plus"></i></a> Odometer</li>
                            </ul>

                            <div class="tab-content">

                                <div class="tab-pane" id="tab_1-1">

                                </div><!-- /.tab-pane -->
                                
                                <div class="tab-pane active" id="tab_2-2">

                                    <?php $this->load->view('vehicle_odometers/table', array('records'=>$records)); ?>
                                    
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
<?php $this->load->view( 'partials/header' ); ?>

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
    
        <h1>Job <small>list</small></h1>
    
        <ol class="breadcrumb">
    
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    
            <li><a href="<?php echo site_url( $class_name ); ?>"><i class="fa fa-trash"></i> Jobs</a></li>
    
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
                            <?php $class_title = ucwords(str_replace('_', ' ', $class_name)); ?>
                            <ul class="nav nav-tabs pull-right">
                                <li><a href="#tab_2-2" data-toggle="tab" aria-expanded="false">Closed Jobs</a></li>
                                <li class="active"><a href="#tab_2-1" data-toggle="tab" aria-expanded="true">Opened Jobs</a></li>
                              
                                <?php if ( $controller->hasAccess('add-job') ): ?>
                                <li class="pull-left header" style="padding: 0;">
                                    <a onclick="return confirm('Make Sure if you want to delete all jobs record. it will delete all record from database and would not be able to recover the deleted data.');" href="<?php echo site_url( $class_name."/clean" ); ?>" style="display: inline; padding: 10px 0;">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </li>
                                <li class="pull-left header">
                                    <a href="<?php echo site_url( $class_name."/save" ); ?>" style="display: inline; padding: 10px 0;">
                                        <i class="fa fa-plus"></i>
                                    </a> <?php echo $class_title ?> List
                                </li>
                                <?php endif ?>
                                  
                            </ul>

                            <div class="tab-content">

                                <div class="tab-pane <?php echo $active_list; ?>" id="tab_2-1">

                                    <?php $this->load->view("$class_name/table", array('records'=>$opened_records)); ?>

                                </div><!-- /.tab-pane -->

                                <div class="tab-pane <?php echo $inactive_list; ?>" id="tab_2-2">

                                    <?php $this->load->view("$class_name/table", array('records'=>$closed_records)); ?>
                                    
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

    $('.close-job').on('click', function (e) {
        if (!confirm("Closing this job will remove all Incomplete visits.")) { e.preventDefault(); }
    });


</script>
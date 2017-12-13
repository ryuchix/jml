<?php $this->load->view( 'partials/header' ); ?>

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
    
        <h1>Issues/Complaints <small>list</small></h1>
    
        <ol class="breadcrumb">
    
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    
            <li><a href="<?php echo site_url( 'complaints/' ); ?>"><i class="fa fa-bug"></i> Issues/Complaints</a></li>
    
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
                                <li><a href="#tab_1-3" data-toggle="tab" aria-expanded="true">Resolved</a></li>
                                <li><a href="#tab_1-2" data-toggle="tab" aria-expanded="true">Closed</a></li>
                                <li class="active"><a href="#tab_1-1" data-toggle="tab" aria-expanded="true">Open/Assigned</a></li>
                                <li class="pull-left header">
                                    <a href="<?php echo site_url( $class_name."/save" ); ?>" style="display: inline;">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                    Issues / Complaints List
                                </li>
                            </ul>

                            <div class="tab-content">

                                <div class="tab-pane active" id="tab_1-1">
                        
                                    <?php $this->load->view('complains/table', array('records'=>$open_records)); ?>

                                </div><!-- /.tab-pane -->

                                <div class="tab-pane" id="tab_1-2">
                        
                                    <?php $this->load->view('complains/table', array('records'=>$closed_records)); ?>

                                </div><!-- /.tab-pane -->

                                <div class="tab-pane" id="tab_1-3">
                        
                                    <?php $this->load->view('complains/table', array('records'=>$resolved_records)); ?>

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

    $('.disable').on('click', function (e) {
        if (!confirm("do you really want to disable this Gallery type?")) { e.preventDefault(); }
    });

    $('.reactivate').on('click', function (e) {
        if (!confirm("do you really want to Reactivate this Gallery type?")) { e.preventDefault(); }
    });

    $('.not').on('click', function (e) {
        e.preventDefault();
        alert('Not implemented yet.');
    });

</script>
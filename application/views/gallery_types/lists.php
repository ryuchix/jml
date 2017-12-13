<?php $this->load->view( 'partials/header' ); ?>

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
    
        <h1>Gallery Types <small>list</small></h1>
    
        <ol class="breadcrumb">
    
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    
            <li><a href="<?php echo site_url( 'gallery_type/' ); ?>"><i class="fa fa-trash"></i> Gallery types</a></li>
    
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
                              <li class="<?php echo $inactive_list; ?>"><a href="#tab_1-1" data-toggle="tab" aria-expanded="true">Inactive Gallery types</a></li>
                              <li class="<?php echo $active_list; ?>"><a href="#tab_2-2" data-toggle="tab" aria-expanded="false">Active Gallery types</a></li>
                              <li class="pull-left header"><a href="<?php echo site_url( "bin_type/save" ); ?>" style="display: inline;"><i class="fa fa-plus"></i></a> Gallery types List</li>
                            </ul>

                            <div class="tab-content">

                                <div class="tab-pane <?php echo $inactive_list; ?>" id="tab_1-1">

                                    <?php $this->load->view('gallery_types/table', array('records'=>$inactive_records)); ?>
                                    
                                </div><!-- /.tab-pane -->
                                
                                <div class="tab-pane <?php echo $active_list; ?>" id="tab_2-2">

                                    <?php $this->load->view('gallery_types/table', array('records'=>$records)); ?>
                                    
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

    $('.btn-group').on('show.bs.dropdown', function () {
        $('.dataTables_paginate').fadeOut();
    });

    $('.btn-group').on('hide.bs.dropdown', function () {
        $('.dataTables_paginate').fadeIn();
    });



</script>
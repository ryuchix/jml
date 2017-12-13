<?php $this->load->view( 'partials/header' ); ?>

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
    
        <h1>Manage Bin Liners <small>list</small></h1>
    
        <ol class="breadcrumb">
    
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    
            <li><a href="<?php echo site_url( $class_name ); ?>"><i class="fa fa-trash"></i> Bin Liner</a></li>Bin Liners

            <li><a href="<?php echo site_url( "$class_name/record_list/" ); ?>"><i class="fa fa-trash"></i> Bin Liner</a></li>Manage Bin Liners
    
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
                              <li class="active" style="visibility: hidden;"><a href="#tab_1-1" data-toggle="tab" aria-expanded="true"><?php echo $class_title ?></a></li>
                              <li class="pull-left header"><a href="<?php echo site_url( $class_name."/save" ); ?>" style="display: inline;"><i class="fa fa-plus"></i></a> <?php echo $class_title ?> List</li>
                            </ul>

                            <div class="tab-content">

                                <div class="tab-pane active" id="tab_1-1">

                                    <?php $this->load->view($class_name.'s/record_table', array('records'=>$records)); ?>
                                    
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
        if (!confirm("do you really want to disable this Bin Liner?")) { e.preventDefault(); }
    });

    $('.reactivate').on('click', function (e) {
        if (!confirm("do you really want to Reactivate this Bin Liner?")) { e.preventDefault(); }
    });

</script>
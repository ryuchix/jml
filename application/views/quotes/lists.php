<?php $this->load->view( 'partials/header' ); ?>

<style>
    
    .dropdown-menu {
        right: 0;
        left: auto;
    }

</style>

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
    
        <h1>Quotes <small>list</small></h1>
    
        <ol class="breadcrumb">
    
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    
            <li><a href="<?php echo site_url( $class_name ); ?>"><i class="fa fa-file-text-o"></i> Quotes</a></li>
    
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
                                <li data-type="lost"><a href="#tab_1-3" data-toggle="tab" aria-expanded="true"><?php echo $class_title ?> Lost</a></li>
                                <li data-type="won"><a href="#tab_1-2" data-toggle="tab" aria-expanded="true"><?php echo $class_title ?> Won</a></li>
                                <li data-type="pending" class="active"><a href="#tab_1-1" data-toggle="tab" aria-expanded="true"><?php echo $class_title ?> Pending</a></li>
                                <li class="pull-left header">
                                    
                                    <?php if( $controller->hasAccess('add-quote') ): ?>
                                    <a href="<?php echo site_url( $class_name."/save" ); ?>" style="display: inline;">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                    <?php endif; ?>

                                    <a class="pdf_view" href="<?php echo site_url( $class_name."/pdf_view" ); ?>" style="display: inline;">
                                        <i class="fa fa-file-pdf-o"></i>
                                    </a>
                                    
                                    <a href="<?php echo site_url( "quote/list_in_csv" ); ?>" class="exportCSV" style="display: inline;" target="_blank">
                                        <i class="fa fa-file-excel-o"></i>
                                    </a> 

                                    <?php echo $class_title ?> List
                                    
                                </li>
                            </ul>

                            <div class="tab-content">

                                <div class="tab-pane active" id="tab_1-1">

                                    <?php $this->load->view($class_name.'s/table', array('records'=>$pending_records)); ?>

                                </div><!-- /.tab-pane -->

                                <div class="tab-pane" id="tab_1-2">

                                    <?php $this->load->view($class_name.'s/table', array('records'=>$won_records)); ?>

                                </div><!-- /.tab-pane -->

                                <div class="tab-pane" id="tab_1-3">

                                    <?php $this->load->view($class_name.'s/table', array('records'=>$lost_records)); ?>

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
        if (!confirm("do you really want to disable this Bin type?")) { e.preventDefault(); }
    });

    $('.reactivate').on('click', function (e) {
        if (!confirm("do you really want to Reactivate this Bin type?")) { e.preventDefault(); }
    });

    $('.pdf_view').on('click', function(event) {
        // alert();
        // window.location = 'pdf_view/'+$('.nav-tabs').find('li.active').data('type');
        window.open(
            'pdf_view/'+$('.nav-tabs').find('li.active').data('type'),
            "_blank"
            );
        event.preventDefault();

    });

    $('.exportCSV').on('click', function(event) {
        var baseUrl = '<?php echo site_url( "quote/" ); ?>';
        window.location = baseUrl+'list_in_csv/'+$('.nav-tabs').find('li.active').data('type');
        event.preventDefault();
    });

</script>
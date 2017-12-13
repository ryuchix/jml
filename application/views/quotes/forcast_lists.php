<?php $this->load->view( 'partials/header' ); ?>

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
    
        <h1>Sales <small>Forcast</small></h1>
    
        <ol class="breadcrumb">
    
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    
            <li><a href="<?php echo site_url( $class_name ); ?>"><i class="fa fa-trash"></i> Quotes</a></li>
    
            <li class="active">Forcast</li>
    
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
                                <li class="active" style="visibility: hidden;"><a href="#tab_1-1" data-toggle="tab" aria-expanded="true">Forecast</a></li>
                                <li class="pull-left header">
                                    <a href="<?php echo site_url( "quote/forecast_pdf_view" ); ?>" style="display: inline;" target="_blank"><i class="fa fa-file-pdf-o"></i></a> 
                                    <a href="<?php echo site_url( "quote/forecast_list_in_csv" ); ?>" style="display: inline;" target="_blank"><i class="fa fa-file-excel-o"></i></a> 
                                    Forecast
                                </li>
                            </ul>

                            <div class="tab-content">

                                <div class="tab-pane active" id="tab_1-1">

                                <?php $this->load->view($class_name.'s/forcast_table', array('records'=>$records, 'months' => $months)); ?>

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

    $('#example').DataTable( {
        "dom": '<"custom-data-table"<"row"<"col-sm-6"l><"col-sm-6"f>><"row"<"col-sm-12"t>><"row"<"col-sm-6"i><"col-sm-6"p>>>'
    } );



</script>
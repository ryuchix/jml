<?php $this->load->view( 'partials/header' ); ?>

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
    
        <h1>Property Videos <small>list</small></h1>
    
        <ol class="breadcrumb">
    
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    
            <li><a href="<?php echo site_url( 'property/' ); ?>"><i class="fa fa-car"></i> Property</a></li>

            <li><a href="<?php echo site_url( "property_video/lists/$property_id" ); ?>"><i class="fa fa-video-camera"></i> Videos</a></li>
    
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
                              <li class="<?php echo $inactive_list; ?>"><a href="#tab_1-1" data-toggle="tab" aria-expanded="true">Inactive <?php echo $class_title ?></a></li>
                              <li class="<?php echo $active_list; ?>"><a href="#tab_2-2" data-toggle="tab" aria-expanded="false">Active <?php echo $class_title ?></a></li>
                              <li class="pull-left header"><a href="<?php echo site_url( "property_video/save/$property_id" ); ?>" style="display: inline;"><i class="fa fa-plus"></i></a> List of videos</li>
                            </ul>

                            <div class="tab-content">

                                <div class="tab-pane <?php echo $inactive_list; ?>" id="tab_1-1">

                                    <?php $this->load->view('properties/video_table', array('records'=>$inactive_records)); ?>
                                    
                                </div><!-- /.tab-pane -->
                                
                                <div class="tab-pane <?php echo $active_list; ?>" id="tab_2-2">

                                    <?php $this->load->view('properties/video_table', array('records'=>$records)); ?>
                                    
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


<!-- Default bootstrap modal example -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view( 'partials/footer' ); ?>

<script>

    $("#myModal").on("show.bs.modal", function(e) {
        var $link = $(e.relatedTarget);
        $('#myModalLabel').text( $link.parents('tr').find('td:eq(0)').text() );
        $(this).find(".modal-body").load($link.attr("href"));
    }).on('hidden.bs.modal', function () {
        $(this).find(".modal-body").html('');
    })

</script>
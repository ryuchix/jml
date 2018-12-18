<?php $this->load->view( 'partials/header' ); ?>

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
    
        <h1>Bins <small>list</small></h1>
    
        <ol class="breadcrumb">
    
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    
            <li><a href="<?php echo site_url( "property/" ); ?>"><i class="fa fa-life-user"></i> Properties</a></li>

            <li><a href="<?php echo site_url( "property/bins/$property_id/lists" ); ?>"><i class="fa fa-file-o"></i> Bins</a></li>

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
                                <li class="<?php echo $inactive_list; ?>"><a href="#tab_1-1" data-toggle="tab" aria-expanded="true">Inactive Bins</a></li>
                                <li class="<?php echo $active_list; ?>"><a href="#tab_2-2" data-toggle="tab" aria-expanded="false">Active Bins</a></li>
                                
                                <?php if ($controller->hasAccess('add-property-bin')): ?>
                                <li class="pull-left header">
                                    <a href="<?php echo site_url( "property/bins/$property_id/save" ); ?>" style="display: inline;">
                                        <i class="fa fa-plus"></i>
                                    </a> Property bins
                                </li>
                                <?php endif ?>
                                    
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane <?php echo $inactive_list; ?>" id="tab_1-1">

                                    <?php $this->load->view('properties/bins_table', array('records'=>$inactive_records)); ?>
                                    
                                </div><!-- /.tab-pane -->
                                
                                <div class="tab-pane <?php echo $active_list; ?>" id="tab_2-2">

                                    <?php $this->load->view('properties/bins_table', array('records'=>$records)); ?>
                                    
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
<div class="modal fade" id="photoModel" tabindex="-1" role="dialog" aria-labelledby="photoModelLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="photoModelLabel">Modal title</h4>
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

    $('.confirmation').on('click', function (e) {
        if (!confirm("do you really want to remove this service?")) { e.preventDefault(); }
    });

    $("#photoModel").on("show.bs.modal", function(e) {
        var $link = $(e.relatedTarget);
        $('#photoModelLabel').text( $link.parents('tr').find('td:eq(0)').text() + ' Key Photo' );
        $(this).find(".modal-body").load($link.attr("href"));
    });

</script>

<?php $this->load->view( 'partials/header' ); ?>

<style>
    .widget-user-desc a {
        color: white;
        text-decoration: underline;
    }
</style>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $address; ?></h4>
            </div>
            <div class="modal-body">
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
    
        <h1>&nbsp;</h1>
    
        <ol class="breadcrumb">
    
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    
            <li><a href="<?php echo site_url( $class_name ); ?>"><i class="fa fa-trash"></i> Jobs</a></li>
    
            <li class="active">view</li>
    
        </ol>
    
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">

            <div class="col-sm-12">
                <!-- Widget: user widget style 1 -->
                <div class="box box-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-aqua-active" style="height: auto;">
                        
                        <h3 class="widget-user-username">
                            <?php echo $client; ?>
                        </h3>

                        <h5 class="widget-user-desc">
                            <?php echo anchor(site_url("property/map/$record->property_id"),'<i class="fa fa-map-marker"> </i> '. $address, ' data-remote="false" data-toggle="modal" data-target="#myModal" class=""')?>
                        </h5>
                        
                        <h5 class="widget-user-desc">
                            Job # <?php echo $record->id; ?> - <?php echo get_job_types($record->job_type); ?>
                        </h5>
                        
                        <h5 class="widget-user-desc">
                            <a href="<?php echo site_url("jobs/save/{$record->id}") ?>">
                                <?php echo $record->job_title . ' - ' . get_job_categories($record->job_category); ?>
                                &nbsp;&nbsp;&nbsp;<i class="fa fa-edit"></i>
                            </a>
                        </h5>
                        
                        <?php if($record->job_type == 2): ?>

                        <h5 class="widget-user-desc">
                            Last for: <?php echo $record->duration . ' ' . $record->duration_schedule; ?>
                        </h5>

                        <?php endif;?>
                        
                        <h5 class="widget-user-desc">
                            Contact: <?php echo "$contact->contact_name $contact->surname 
                                (<i class='fa fa-phone'> </i> $contact->phone <i class='fa fa-envelope'> </i> $contact->email)"; ?>
                        </h5>

                    </div>

                    <div class="box-footer">
                        <div class="row">
                            <div class="col-sm-3 border-right">
                                <div class="description-block">
                                    <h5 class="description-header"><?php echo count($visits); ?></h5>
                                    <a href="#tab_2-2" data-toggle="tab" aria-expanded="true">
                                        <span class="description-text">VISITS</span>
                                    </a>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 border-right">
                                <div class="description-block">
                                    <h5 class="description-header"><?php echo count($crew_users); ?></h5>
                                    <a href="#tab_2-1" data-toggle="tab" aria-expanded="false">
                                        <span class="description-text">CREW USERS</span>
                                    </a>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 border-right">
                                <div class="description-block">
                                    <h5 class="description-header"><?php echo count($line_items); ?></h5>
                                    <a href="#tab_2-3" data-toggle="tab" aria-expanded="false">
                                        <span class="description-text">LINE ITEMS</span>
                                    </a>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3">
                                <div class="description-block">
                                    <h5 class="description-header"><?php echo count($notes); ?></h5>
                                    <a href="#tab_2-4" data-toggle="tab" aria-expanded="false">
                                        <span class="description-text">Notes</span>
                                    </a>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                        </div>
                      <!-- /.row -->
                    </div>
                </div>
                <!-- /.widget-user -->
            </div>

            <div class="col-xs-12">

                <div class="box">

                    <div class="box-body">

                        <div class="nav-tabs-custom">

                            <div class="tab-content">

                                <div class="tab-pane <?php echo $show_note?'':'active'; ?>" id="tab_2-2">

                                    <?php $this->load->view("$class_name/job_visits_table", array('records'=>$visits)); ?>
                                    
                                </div><!-- /.tab-pane -->

                                <div class="tab-pane" id="tab_2-1">

                                    <?php $this->load->view("$class_name/crew_user_table", array('records'=>$crew_users)); ?>
                                    
                                </div><!-- /.tab-pane -->

                                <div class="tab-pane" id="tab_2-3">

                                    <?php $this->load->view("$class_name/job_line_items_table", array('records'=>$line_items)); ?>
                                    
                                </div><!-- /.tab-pane -->

                                <div class="tab-pane <?php echo $show_note?'active':''; ?>" id="tab_2-4">

                                    <?php $this->load->view("$class_name/note_form", array('records'=>$notes)); ?>
                                    
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

    $('.edit_note').on('click', function (e) {
        var $this = $(this),
            note = $this.parents('.timeline-item').find('.note-text').text(),
            url = $('#editModal').find('form').attr('action'),
            note_id = $this.data('note-id'),
            actionUrl = url.substring( 0, url.lastIndexOf('/') )+'/'+note_id;
        
        $('#editModal').find('form').attr('action', actionUrl );
        // console.log(actionUrl);

        $('#editNote').text(note);
    });

    $('.reactivate').on('click', function (e) {
        if (!confirm("do you really want to Reactivate this Bin type?")) { e.preventDefault(); }
    });


    $('a .badge').on('click', function(event) {
        $that = $(this);
        event.preventDefault();
        if (confirm('do you want do delete attachment?')) {
            var url = '<?php echo site_url( "jobs/delete_attachment" ); ?>';
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {'file_id': $(this).data('file_id')},
            })
            .done(function(data) {
                console.log(data);
                if (data.status) {
                    $that.parents('.list-group-item').fadeOut('slow', function() {
                        $(this).remove();
                    });
                }
            });
            
        }
    });

    $("#myModal").on("show.bs.modal", function(e) {
        var $link = $(e.relatedTarget);
        // $('#myModalLabel').text( $link.parents('tr').find('td:eq(0)').text() + ' Location Map' );
        $(this).find(".modal-body").load($link.attr("href"));
    });

    $('[name="visit_id"]').on('change', function() {
        $(this).parent('form').submit();
    });

</script>
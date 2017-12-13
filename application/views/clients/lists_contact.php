<?php $this->load->view( 'partials/header' ); ?>

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
    
        <h1>Client <small>list</small></h1>
    
        <ol class="breadcrumb">
    
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    
            <li><a href="<?php echo site_url( "client/" ); ?>"><i class="fa fa-life-user"></i> Clients</a></li>

            <li><a href="<?php echo site_url( "client/contact/$client_id/list" ); ?>"><i class="fa fa-file-text"></i> Contacts</a></li>
    
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
                              <li class=""><a href="#tab_1-1" data-toggle="tab" aria-expanded="true">Inactive Contacts</a></li>
                              <li class="active"><a href="#tab_2-2" data-toggle="tab" aria-expanded="false">Active Contacts</a></li>
                              <li class="pull-left header"><a href="<?php echo site_url( "client/contact/$client_id/add" ); ?>" style="display: inline;"><i class="fa fa-plus"></i></a> Client's Contacts</li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane" id="tab_1-1">

                                    <?php $this->load->view('clients/contact_table', array('records'=>$inactive_records)); ?>
                                    
                                </div><!-- /.tab-pane -->
                                
                                <div class="tab-pane active" id="tab_2-2">

                                    <?php $this->load->view('clients/contact_table', array('records'=>$records)); ?>
                                    
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
        if (!confirm("do you really want to disable this contact?")) { e.preventDefault(); }
    });

    $('.reactivate').on('click', function (e) {
        if (!confirm("do you really want to Reactivate this contact?")) { e.preventDefault(); }
    });

    $('.not').on('click', function (e) {
        e.preventDefault();
        alert('Not implemented yet.');
    });

</script>
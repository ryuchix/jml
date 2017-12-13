<?php $this->load->view( 'partials/header' ); ?>

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
    
        <h1>Consumable Requests<small>list</small></h1>
    
        <ol class="breadcrumb">
    
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    
            <li><a href="<?php echo site_url( "consumables/" ); ?>"><i class="fa fa-life-user"></i> Consumables</a></li>

            <li><a href="<?php echo site_url( "consumable_request/" ); ?>"><i class="fa fa-file-o"></i> Request</a></li>

            <li class="active">List</li>
    
        </ol>
    
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">

            <div class="col-xs-12">

                <div class="box box-primary">

                    <div class="box-body">

                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs pull-right">
                              <li><a href="#tab_1-1" data-toggle="tab" aria-expanded="true">Void Request</a></li>
                              <li><a href="#tab_2-2" data-toggle="tab" aria-expanded="false">Closed Request</a></li>
                              <li class="active"><a href="#tab_3-3" data-toggle="tab" aria-expanded="false">Open Request</a></li>
                              <li class="pull-left header"><a href="<?php echo site_url( "consumable_request/save/" ); ?>" style="display: inline;"><i class="fa fa-plus"></i></a> Request List</li>
                            </ul>

                            <div class="tab-content">

                                <div class="tab-pane" id="tab_1-1">

                                <?php $this->load->view('consumables_request/table', array('records'=>$void_records)); ?>
                                   
                                </div><!-- /.tab-pane -->

                                <div class="tab-pane" id="tab_2-2">

                                <?php $this->load->view('consumables_request/table', array('records'=>$closed_records)); ?>
                                   
                                </div><!-- /.tab-pane -->

                                <div class="tab-pane active" id="tab_3-3">

                                <?php $this->load->view('consumables_request/table', array('records'=>$open_records)); ?>
                                   
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

    $('.confirmation').on('click', function (e) {
        if (!confirm("do you really want to remove this request?")) { e.preventDefault(); }
    });

</script>

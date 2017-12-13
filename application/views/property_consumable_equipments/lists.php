<?php $this->load->view( 'partials/header' ); ?>

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
    
        <h1>Property Consumable Equipments <small>list</small></h1>
    
        <ol class="breadcrumb">
    
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    
            <li><a href="<?php echo site_url( "property/" ); ?>"><i class="fa fa-trash"></i> Property</a></li>

            <li><a href="<?php echo site_url( $class_name ); ?>"><i class="fa fa-trash"></i> Consumable Equipment</a></li>
            <li class="active">List</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title"><a href="<?php echo site_url( "$class_name/save/$property_id" ); ?>" style="display: inline;"><i class="fa fa-plus"></i></a> &nbsp; 
                        <?php echo $property->address . ', ' . $property->address_suburb . ', ' . $property->address_post_code ?>
                      </h3>
                    </div>
                    <div class="box-body">
                        <?php $this->load->view($class_name.'s/table', array('records'=>$records)); ?>
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
        if (!confirm("do you really want to disable this Equipment type?")) { e.preventDefault(); }
    });

    $('.reactivate').on('click', function (e) {
        if (!confirm("do you really want to Reactivate this Equipment type?")) { e.preventDefault(); }
    });

</script>
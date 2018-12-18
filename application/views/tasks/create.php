<?php $this->load->view( 'partials/header' ); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Tasks <small><?php echo $record->id? 'edit': 'new'; ?></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( 'tasks/' ); ?>"><i class="fa fa-user"></i> Tasks</a></li>
            <li><a href="<?php echo site_url( 'tasks/' ); ?>"><i class="fa fa-user"></i> lists</a></li>
            <li class="active"><?php echo $record->id? 'Edit': 'New'; ?> Bin Type</li>
        </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content">
        
        <div class="row">

            <!-- form start -->
            <form role="form" method="post" action="<?php echo site_url( $record->id? "tasks/$record->id/update": "tasks/store/" ); ?>">
                <div class="col-sm-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?php echo $record->id? 'Edit': 'Add New'; ?> Task</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            
                            form fields woud be here....

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    
                </div> <!-- .col-sm-4 -->
            </form>

        </div>
        <!-- /.row -->
    </section>
</div>

<?php $this->load->view( 'partials/footer' ); ?>
<script src="<?php echo base_url(); ?>assets/dist/js/colorpicker.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/js/imageupload.js"></script>
<script>

</script>
<?php $this->load->view( 'partials/header' ); ?>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Service <small>new</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( 'services/' ); ?>"><i class="fa fa-life-ring"></i> Services</a></li>
            <li class="active">new</li>
        </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content">
        
        <div class="row">

            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">Add New Service</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" action="<?php echo site_url( 'services/add/' ); ?>">
                        <div class="box-body">
                            <div class="form-group <?php echo form_error('data[name]')? 'has-error':''; ?>">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="data[name]" id="name" placeholder="Service Name" value="<?php echo set_value('data[name]'); ?>">
                                <?php echo form_error('data[name]', '<p class="error-msg">', '</p>') ?>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" rows="3" name="data[description]" placeholder="Description..."><?php echo set_value('data[description]'); ?></textarea>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            

        </div>
        <!-- /.row -->

    </section>
</div>

<?php $this->load->view( 'partials/footer' ); ?>
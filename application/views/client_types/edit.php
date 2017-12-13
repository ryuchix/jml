<?php $this->load->view( 'partials/header' ); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Client type <small>edit</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( 'client_type/' ); ?>"><i class="fa fa-life-ring"></i> Client type</a></li>
            <li class="active">edit</li>
        </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content">
        
        <div class="row">

            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">Edit Client type</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="post" action="<?php echo site_url( 'client_type/edit/'.$record->id ); ?>">
                        <div class="box-body">
                            <div class="form-group <?php echo form_error('data[type]')? 'has-error':''; ?>">
                                <label for="name">Client Type Name</label>
                                <input type="text" class="form-control" name="data[type]" id="name" placeholder="Client Type" value="<?php echo set_value('data[type]', $record->type); ?>">
                                <?php echo form_error('data[type]', '<p class="error-msg">', '</p>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" rows="3" name="data[description]" placeholder="Description..."><?php echo set_value('data[description]', $record->description); ?></textarea>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" name="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <!-- /.row -->

    </section>
</div>

<?php $this->load->view( 'partials/footer' ); ?>
<?php $this->load->view( 'partials/header' ); ?>

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">

        <h1>Roles <small><?php echo $record->id? 'edit': 'new'; ?></small></h1>

        <ol class="breadcrumb">

            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>

            <li><a href="<?php echo site_url( 'users/' ); ?>"><i class="fa fa-user"></i> Users</a></li>

            <li><a href="<?php echo site_url( 'users/roles/' ); ?>"><i class="fa fa-key"></i> Roles</a></li>

            <li class="active"><?php echo $record->id? 'Edit': 'New'; ?></li>

        </ol>

    </section>

    <br>
    
    <!-- Main content -->
    <section class="content">
        
        <div class="row">

            <!-- form start -->
            <form role="form" method="post" action="<?php echo site_url( "roles/save/$record->id" ); ?>">

                <div class="col-sm-4">

                    <div class="box box-primary">

                        <div class="box-header with-border">

                          <h3 class="box-title"><?php echo $record->id? 'Edit': 'Add New'; ?> Role</h3>

                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            
                            <div class="form-group <?php echo form_error('name')? 'has-error':''; ?>">

                                <label for="name">Name</label>

                                <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo set_value('name', $record->name); ?>">

                                <?php echo form_error('name','<p class="error-msg">','</p>') ?>

                            </div>
                            
                            <div class="form-group">

                                <label for="description">Description</label>

                                <textarea class="form-control" placeholder="Description" name="description" id="description" rows="5"><?php echo set_value('description', $record->description); ?></textarea>

                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">

                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>

                        </div>
                        <!-- .box-footer -->

                    </div>
                    <!-- .box.box-primary -->

                </div>
                <!-- .col-md-8 -->

                <div class="col-sm-8">

                    <div class="box box-primary">

                        <div class="box-header with-border">

                          <h3 class="box-title">Permissions</h3>

                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            
                            <?php $this->load->view('user/roles/permission_table'); ?>
                            
                        </div>
                        <!-- .body -->

                    </div>
                    <!-- .box-primary -->

                </div> <!-- .col-sm-4 -->

            </form>

        </div>
        <!-- /.row -->

    </section>
    <!-- .section -->

</div>
<!-- .content-wrapper -->

<?php $this->load->view( 'partials/footer' ); ?>

<script>
    
$(function () {

    

});

</script>
<?php $this->load->view( 'partials/header' ); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Users <small>Module</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( 'users/' ); ?>"><i class="fa fa-users"></i> Users</a></li>
            <li class="active">Change Password</li>
        </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content">

        <!-- form start -->
        <form role="form" method="post" action="<?php echo site_url( "users/change_password/$user_id" ); ?>">
            <div class="row">
                <div class="col-sm-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">Change Users Password</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">

                            <div class="form-group <?php echo form_error('password')? 'has-error':''; ?>">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                <?php echo form_error('password', '<p class="error-msg">', '</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('confirm_password')? 'has-error':''; ?>">
                                <label for="confirmation">Confirm Password</label>
                                <input type="password" class="form-control" name="confirm_password" id="confirmation" placeholder="Password Confirmation">
                                <?php echo form_error('confirm_password', '<p class="error-msg">', "</p>") ?>
                            </div>

                        </div>

                        <div class="box-footer hidden-sm hidden-xs">
                            <button type="submit" class="btn btn-primary" name="submit">Save</button>
                        </div>

                    </div>

                </div> <!-- .com-sm-6 -->

            </div>
            <!-- /.row -->
        </form>

    </section>
</div>

<?php $this->load->view( 'partials/footer' ); ?>

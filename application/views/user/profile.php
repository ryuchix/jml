<?php $this->load->view( 'partials/header' ); ?>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Users <small>profile</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( 'users/' );; ?>"><i class="fa fa-users"></i> Users</a></li>
            <li class="active">Profile</li>
        </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content">

        <div class="row">
            
            <div class="col-xs-12">
                <?php if(validation_errors()): ?>
                <div class="alert alert-warning">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Warning</strong>
                    <?php echo validation_errors(); ?>
                </div>
                <?php endif; ?>

                <form class="form-horizontal" method="post" action="<?php echo site_url( 'users/profile/' ); ?>">

                    <div class="tab-pane active" id="settings">

                        <div class="form-group">
                            <label for="first_name" class="col-sm-2 control-label">First Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="data[first_name]" id="first_name" value="<?php echo set_value('data[first_name]', $user->first_name); ?>" placeholder="First Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="last_name" class="col-sm-2 control-label">Last Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="data[last_name]" id="last_name" value="<?php echo set_value('data[last_name]', $user->last_name); ?>" placeholder="Last Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="user_name" class="col-sm-2 control-label">Username</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="data[user_name]" id="user_name" value="<?php echo set_value('data[user_name]', $user->user_name); ?>" placeholder="Username">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" name="data[email]" id="email" value="<?php echo set_value('data[email]', $user->email); ?>" placeholder="Email">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cell" class="col-sm-2 control-label">Cell</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="data[cell]" id="data[cell]" placeholder="Cell #" value="<?php echo set_value('data[cell]', $user->cell); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-danger" name="submit">Save</button>
                            </div>
                        </div>
                        <div class="box-header with-border">
                            <?php /* Listing all services for this particular */ ?>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.col -->

        </div>
        <!-- /.row -->

    </section>
</div>

<?php $this->load->view( 'partials/footer' ); ?>
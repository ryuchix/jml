<?php $this->load->view( 'partials/header' ); ?>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Users <small>edit</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( 'users/' );; ?>"><i class="fa fa-users"></i> Users</a></li>
            <li class="active">edit</li>
        </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content">

        <div class="row">
            
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit User</h3>

                        <form role="form" method="post" action="<?php echo site_url( 'users/edit/'.$user->id ); ?>">

                            <div class="box-body">

                                <div class="form-group <?php echo form_error('data[first_name]')?'has-error':''; ?>">
                                    <label for="first_name">First Name</label>
                                    <input type="text" class="form-control" name="data[first_name]" id="first_name" value="<?php echo set_value('data[first_name]', $user->first_name); ?>" placeholder="First Name">
                                    <?php echo form_error('data[first_name]', '<p class="error-msg"', '</p>'); ?>
                                </div>

                                <div class="form-group <?php echo form_error('data[last_name]')?'has-error':''; ?>">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="form-control" name="data[last_name]" id="last_name" value="<?php echo set_value('data[last_name]', $user->last_name); ?>" placeholder="Last Name">
                                    <?php echo form_error('data[last_name]','<p class="error-msg">','</p>'); ?>
                                </div>

                                <div class="form-group <?php echo form_error('data[user_name]')? "has-error": ""; ?>">
                                    <label for="user_name">Username</label>
                                    <input type="text" class="form-control" name="data[user_name]" id="user_name" value="<?php echo set_value('data[user_name]', $user->user_name); ?>" placeholder="Username">
                                    <?php echo form_error('data[user_name]','<p class="error-msg">','</p>'); ?>
                                </div>

                                <div class="form-group <?php echo form_error('data[email]')?"has-error":''; ?>">
                                    <label for="email">Email</label>
                                        <input type="email" class="form-control" name="data[email]" id="email" value="<?php echo set_value('data[email]', $user->email); ?>" placeholder="Email">
                                    <?php echo form_error('data[email]','<p class="error-msg">','</p>') ?>
                                </div>

                                <div class="form-group <?php echo form_error('data[user_role]')? "has-error":''; ?>">
                                    <label for="user_role">User Type</label>
                                    <select name="data[user_role]" id="user_role" class="form-control">
                                        <option value="">Select user role</option>
                                        <option value="<?php echo ADMIN_ROLE; ?>" <?php echo ($user->user_role==ADMIN_ROLE)? 'selected':''; ?>>Admin</option>
                                        <option value="<?php echo STAFF_ROLE; ?>" <?php echo ($user->user_role==STAFF_ROLE)?'selected':''; ?>>Staff/Contractor</option>
                                        <option value="<?php echo OFFICE_MANAGER_ROLE; ?>" <?php echo ($user->user_role==OFFICE_MANAGER_ROLE)?'selected':''; ?>>Office Manager</option>
                                        <option value="<?php echo OPERATION_MANAGER_ROLE; ?>" <?php echo ($user->user_role==OPERATION_MANAGER_ROLE)?'selected':''; ?>>Operation Manager</option>
                                    </select>
                                    <?php echo form_error('data[user_role]','<p class="error-msg"', '</p>'); ?>
                                </div>

                                <div class="form-group">
                                    <label for="cell">Mobile number</label>
                                    <input type="text" class="form-control" name="data[cell]" id="cell" placeholder="Mobile number" value="<?php echo set_value('data[cell]', $user->cell); ?>">
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
            <!-- /.col -->

        </div>
        <!-- /.row -->

    </section>
</div>

<?php $this->load->view( 'partials/footer' ); ?>
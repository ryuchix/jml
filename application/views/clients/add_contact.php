<?php $this->load->view( 'partials/header' ); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Clients <small>new</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( 'client/' ); ?>"><i class="fa fa-user"></i> Clients</a></li>
            <li><a href="<?php echo site_url( 'client/' ); ?>"><i class="fa fa-user"></i> lists</a></li>
            <li class="active">New Contact</li>
        </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content">
        
        <div class="row">

            <!-- form start -->
            <form role="form" method="post" action="<?php echo site_url( "client/contact/$client_id/add/" ); ?>">
                <div class="col-sm-8 col-sm-offset-2">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">Add New Contact</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <div class="form-group <?php echo form_error('data[contact_name]')? 'has-error':''; ?>">
                                <label for="contact_name">Contact Name</label>
                                <input type="text" class="form-control" name="data[contact_name]" id="contact_name" placeholder="Contact name" value="<?php echo set_value('data[contact_name]'); ?>">
                                <?php echo form_error('data[contact_name]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[surname]')? 'has-error':''; ?>">
                                <label for="surname">Surname</label>
                                <input type="text" class="form-control" name="data[surname]" id="surname" placeholder="Surname" value="<?php echo set_value('data[surname]'); ?>">
                                <?php echo form_error('data[surname]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[role]')? 'has-error':''; ?>">
                                <label for="role">Role</label>
                                <input type="tel" class="form-control" name="data[role]" id="role" placeholder="Role" value="<?php echo set_value('data[role]'); ?>">
                                <?php echo form_error('data[role]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[phone]')? 'has-error':''; ?>">
                                <label for="phone">Phone</label>
                                <input type="tel" class="form-control" name="data[phone]" id="phone" placeholder="Phone #" value="<?php echo set_value('data[phone]'); ?>">
                                <?php echo form_error('data[phone]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[email]')? 'has-error':''; ?>">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="data[email]" id="email" placeholder="Email" value="<?php echo set_value('data[email]'); ?>">
                                <?php echo form_error('data[email]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="data[is_primary]" checked>Primary
                                    </label>
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        </div>
                    </div>
                </div>
            
            </form>

        </div>
        <!-- /.row -->
    </section>
</div>

<?php $this->load->view( 'partials/footer' ); ?>
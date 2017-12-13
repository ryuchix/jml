<!-- Default bootstrap modal example -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        
        <!-- form start -->
        <form role="form" method="post" action="<?php echo site_url( "client/contact/0/add_contact_service/" ); ?>" id="contactForm">
        
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add New Contact</h4>
                </div>
                <div class="modal-body">
                    <!-- /.box-header -->
                    <div class="box-body">

                        <div id="errorContainer"></div>

                        <input type="hidden" id="client_hidden_value" name="client_id">
                        <div class="form-group <?php echo form_error('contact_name')? 'has-error':''; ?>">
                            <label for="contact_name">Contact Name</label>
                            <input type="text" class="form-control" name="contact_name" id="contact_name" placeholder="Contact name" value="<?php echo set_value('contact_name'); ?>">
                            <?php echo form_error('contact_name','<p class="error-msg">','</p>') ?>
                        </div>

                        <div class="form-group <?php echo form_error('surname')? 'has-error':''; ?>">
                            <label for="surname">Surname</label>
                            <input type="text" class="form-control" name="surname" id="surname" placeholder="Surname" value="<?php echo set_value('surname'); ?>">
                            <?php echo form_error('surname','<p class="error-msg">','</p>') ?>
                        </div>

                        <div class="form-group <?php echo form_error('role')? 'has-error':''; ?>">
                            <label for="role">Role</label>
                            <input type="tel" class="form-control" name="role" id="role" placeholder="Role" value="<?php echo set_value('role'); ?>">
                            <?php echo form_error('role','<p class="error-msg">','</p>') ?>
                        </div>

                        <div class="form-group <?php echo form_error('phone')? 'has-error':''; ?>">
                            <label for="phone">Phone</label>
                            <input type="tel" class="form-control" name="phone" id="phone" placeholder="Phone #" value="<?php echo set_value('phone'); ?>">
                            <?php echo form_error('phone','<p class="error-msg">','</p>') ?>
                        </div>

                        <div class="form-group <?php echo form_error('email')? 'has-error':''; ?>">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo set_value('email'); ?>">
                            <?php echo form_error('email','<p class="error-msg">','</p>') ?>
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="1" name="is_primary" checked>Primary
                                </label>
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        
        </form>
    </div>
</div>










            
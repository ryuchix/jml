<?php $this->load->view( 'partials/header' ); ?>
<link rel="stylesheet" href="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css">
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/colorpicker/bootstrap-colorpicker.min.css'); ?>">

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Users <small>Module</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( 'users/' );; ?>"><i class="fa fa-users"></i> Users</a></li>
            <li class="active">New</li>
        </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content">

        <!-- form start -->
        <form role="form" method="post" action="<?php echo site_url( "users/save/$record->id" ); ?>">
            <div class="row">
                <div class="col-sm-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">Add User</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">

                            <div class="form-group <?php echo form_error('data[first_name]')? 'has-error':''; ?>">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control" name="data[first_name]" id="first_name" value="<?php echo set_value('data[first_name]', $record->first_name); ?>" placeholder="First Name">
                                <?php echo form_error('data[first_name]','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[last_name]')? 'has-error':''; ?>">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" name="data[last_name]" id="last_name" value="<?php echo set_value('data[last_name]', $record->last_name); ?>" placeholder="Last Name">
                                <?php echo form_error('data[last_name]', '<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[user_name]')? 'has-error':''; ?>">
                                <label for="user_name">Username</label>
                                <input type="text" class="form-control" name="data[user_name]" id="user_name" value="<?php echo set_value('data[user_name]', $record->user_name); ?>" placeholder="Username" <?php echo $record->id? 'readonly':'' ?>>
                                <?php echo form_error('data[user_name]','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[email]')? 'has-error':''; ?>">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="data[email]" id="email" value="<?php echo set_value('data[email]', $record->email); ?>" placeholder="Email">
                                <?php echo form_error('data[email]','<p class="error-msg">','</p>'); ?>
                            </div>
                            <?php if (!$record->id): ?>
                            <div class="form-group <?php echo form_error('password')?'has-error':''; ?>">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                <?php echo form_error('password','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('confirm_password')? 'has-error':''; ?>">
                                <label for="Confirm_password">Confirm Password</label>
                                <input type="password" class="form-control" name="confirm_password" id="Confirm_password" placeholder="Confirm Password">
                                <?php echo form_error('confirm_password','<p class="error-msg">','</p>'); ?>
                            </div>
                            <?php endif ?>

                            <div class="form-group <?php echo form_error('role_ids[]')? 'has-error':''; ?>">
                                <label for="user_role">User Roles</label>
                                <?php 

                                echo form_dropdown('role_ids[]', $roles, $given_roles, ' id="user_role" class="form-control" multiple');
                                ?>
                                <?php echo form_error('role_ids[]','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group">
                                <div class='input-group date' id='datetimepicker2'>
                                    <input type="text" class="form-control" name="data[dob]" id="dob" placeholder="Date of Birth" value="<?php echo set_value('data[dob]', ($record->id && $record->dob)? local_date($record->dob):''); ?>">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="cell">Mobile number</label>
                                <input type="text" class="form-control" name="data[cell]" id="cell" placeholder="Mobile number" value="<?php echo set_value('data[cell]', $record->cell); ?>">
                            </div>

                        </div>

                    </div>
                
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">Bank Details</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <div class="form-group <?php echo form_error('data[bank_name]')? 'has-error':''; ?>">
                                <label for="bank_name">Bank Name:</label>
                                <input type="text" class="form-control" name="data[bank_name]" id="bank_name" value="<?php echo set_value('data[bank_name]', $record->bank_name); ?>" placeholder="Bank Name">
                                <?php echo form_error('data[bank_name]','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[bsb_no]')? 'has-error':''; ?>">
                                <label for="bsb_no">BSB:</label>
                                <input type="text" class="form-control" name="data[bsb_no]" id="bsb_no" value="<?php echo set_value('data[bsb_no]', $record->bsb_no); ?>" placeholder="BSB">
                                <?php echo form_error('data[bsb_no]','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[account_number]')? 'has-error':''; ?>">
                                <label for="account_number">Account No:</label>
                                <input type="text" class="form-control" name="data[account_number]" id="account_number" value="<?php echo set_value('data[account_number]', $record->account_number); ?>" placeholder="Account No">
                                <?php echo form_error('data[account_number]','<p class="error-msg">','</p>'); ?>
                            </div>

                        </div>

                    </div>
                
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">Next of Kin</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <div class="form-group <?php echo form_error('data[kin_name]')? 'has-error':''; ?>">
                                <label for="kin_name">Next of kin name:</label>
                                <input type="text" class="form-control" name="data[kin_name]" id="kin_name" value="<?php echo set_value('data[kin_name]', $record->kin_name); ?>" placeholder="Next of kin name">
                                <?php echo form_error('data[kin_name]','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[kin_relationship]')? 'has-error':''; ?>">
                                <label for="kin_relationship">Relationship:</label>
                                <input type="text" class="form-control" name="data[kin_relationship]" id="kin_relationship" value="<?php echo set_value('data[kin_relationship]', $record->kin_relationship); ?>" placeholder="Relationship">
                                <?php echo form_error('data[kin_relationship]','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group">
                                <label for="kin_phone">Phone:</label>
                                <input type="text" class="form-control" name="data[kin_phone]" id="kin_phone" value="<?php echo set_value('data[kin_phone]', $record->kin_phone); ?>" placeholder="Phone">
                            </div>

                            <div class="form-group">
                                <label for="kin_address_street">Search Address:</label>
                                <input type="text" class="form-control" id="kin_address_street" placeholder="Search Address">
                            </div>

                            <div class="form-group <?php echo form_error('data[kin_address]')? 'has-error':''; ?>">
                                <label for="kin_address">Address:</label>
                                <input type="text" readonly class="form-control" name="data[kin_address]" id="kin_address" placeholder="Address" value="<?php echo set_value('data[kin_address]', $record->kin_address); ?>">
                                <?php echo form_error('data[kin_address]','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[kin_address_state]')? 'has-error':''; ?>">
                                <label for="kin_address_state">State:</label>
                                <input type="text" class="form-control" name="data[kin_address_state]" readonly id="kin_address_state" placeholder="State" value="<?php echo set_value('data[kin_address_state]', $record->address_state); ?>">
                                <?php echo form_error('data[kin_address_state]','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[kin_address_suburb]')? 'has-error':''; ?>">
                                <label for="kin_address_suburb">Suburb:</label>
                                <input type="text" class="form-control" name="data[kin_address_suburb]" readonly id="kin_address_suburb" placeholder="Suburb" value="<?php echo set_value('data[kin_address_suburb]', $record->kin_address_suburb); ?>">
                                <?php echo form_error('data[kin_address_suburb]','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[kin_address_post_code]')? 'has-error':''; ?>">
                                <label for="kin_address_post_code">Postcode:</label>
                                <input type="text" class="form-control" name="data[kin_address_post_code]" readonly id="kin_address_post_code" placeholder="Postal Code" value="<?php echo set_value('data[kin_address_post_code]', $record->kin_address_post_code); ?>">
                                <?php echo form_error('data[kin_address_post_code]','<p class="error-msg">','</p>'); ?>
                            </div>

                            <input type="hidden" name="data[kin_address_location]" id="kin_address_location" value="<?php echo set_value('data[kin_address_location]', $record->kin_address_location); ?>">
                            <input type="hidden" name="data[kin_address_long_state]" id="kin_address_long_state" value="<?php echo set_value('data[kin_address_long_state]', $record->kin_address_long_state); ?>">

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer hidden-sm hidden-xs">
                            <button type="submit" class="btn btn-primary" name="submit">Save</button>
                        </div>

                    </div>

                </div>
                <!-- /.col -->

                <div class="col-sm-6">
                
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">Address Details</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <div class="form-group">
                                <label for="address_street">Search Address:</label>
                                <input type="text" class="form-control" id="address_street" placeholder="Search Address">
                            </div>

                            <div class="form-group <?php echo form_error('data[address]')? 'has-error':''; ?>">
                                <label for="address">Address:</label>
                                <input type="text" readonly class="form-control" name="data[address]" id="address" placeholder="Address" value="<?php echo set_value('data[address]', $record->address); ?>">
                                <?php echo form_error('data[address]','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[address_state]')? 'has-error':''; ?>">
                                <label for="address_state">State:</label>
                                <input type="text" class="form-control" name="data[address_state]" readonly id="address_state" placeholder="State" value="<?php echo set_value('data[address_state]', $record->address_state); ?>">
                                <?php echo form_error('data[address_state]','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[address_suburb]')? 'has-error':''; ?>">
                                <label for="address_suburb">Suburb:</label>
                                <input type="text" class="form-control" name="data[address_suburb]" readonly id="address_suburb" placeholder="Suburb" value="<?php echo set_value('data[address_suburb]', $record->address_suburb); ?>">
                                <?php echo form_error('data[address_suburb]','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[address_post_code]')? 'has-error':''; ?>">
                                <label for="address_post_code">Postcode:</label>
                                <input type="text" class="form-control" name="data[address_post_code]" readonly id="address_post_code" placeholder="Postal Code" value="<?php echo set_value('data[address_post_code]', $record->address_post_code); ?>">
                                <?php echo form_error('data[address_post_code]','<p class="error-msg">','</p>'); ?>
                            </div>

                            <input type="hidden" name="data[address_location]" id="address_location" value="<?php echo set_value('data[address_location]', $record->address_location); ?>">
                            <input type="hidden" name="data[address_long_state]" id="address_long_state" value="<?php echo set_value('data[address_long_state]', $record->address_long_state); ?>">

                        </div>

                    </div>
                
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">Residency Details</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <div class="form-group <?php echo form_error('data[australian_citizen]')? 'has-error':''; ?>">
                                <label for="australian_citizen">Australian Citizen</label>
                                <?php $options = [''=>'Choose...', 'Yes'=>'Yes', 'No'=>'No']; 
                                echo form_dropdown('data[australian_citizen]', $options, isset($_POST['data']['australian_citizen'])? $_POST['data']['australian_citizen']:$record->australian_citizen, ' id="australian_citizen" class="form-control"');
                                ?>
                                <?php echo form_error('data[australian_citizen]','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[permanent_resident]')? 'has-error':''; ?>">
                                <label for="permanent_resident">Permanent Resident</label>
                                <?php echo form_dropdown('data[permanent_resident]', $options, isset($_POST['data']['permanent_resident'])? $_POST['data']['permanent_resident']:$record->permanent_resident, ' id="permanent_resident" class="form-control"'); ?>
                                <?php echo form_error('data[permanent_resident]','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[working_visa]')? 'has-error':''; ?>">
                                <label for="working_visa">Working Visa</label>
                                <?php echo form_dropdown('data[working_visa]', $options, isset($_POST['data']['working_visa'])? $_POST['data']['working_visa']:$record->working_visa, ' id="working_visa" class="form-control"'); ?>
                                <?php echo form_error('data[working_visa]','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[expiry_date]')? 'has-error':''; ?>">
                                <div class='input-group date' id='datetimepicker'>
                                    <input type="text" class="form-control" name="data[expiry_date]" id="expiry_date" placeholder="Expiry Date" value="<?php echo set_value('data[expiry_date]', $record->id? local_date($record->expiry_date):''); ?>">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                <?php echo form_error('data[expiry_date]','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[hour_per_week]')? 'has-error':''; ?>">
                                <label for="hour_per_week">Restriction hours per week:</label>
                                <input type="text" class="form-control" name="data[hour_per_week]" id="hour_per_week" placeholder="Restriction Hours per Week." value="<?php echo set_value('data[hour_per_week]', $record->hour_per_week); ?>">
                                <?php echo form_error('data[hour_per_week]','<p class="error-msg">','</p>'); ?>
                            </div>

                        </div>

                    </div>
                
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">Taxation Details</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <div class="form-group">
                                <label for="abn_no">ABN No:</label>
                                <input type="text" class="form-control" name="data[abn_no]" id="abn_no" placeholder="ABN No." value="<?php echo set_value('data[abn_no]', $record->abn_no); ?>">
                            </div>

                            <div class="form-group">
                                <label for="acn_no">ACN No:</label>
                                <input type="text" class="form-control" name="data[acn_no]" id="acn_no" placeholder="ACN No." value="<?php echo set_value('data[acn_no]', $record->acn_no); ?>">
                            </div>

                            <div class="form-group">
                                <label for="tfn_no">TFN No:</label>
                                <input type="text" class="form-control" name="data[tfn_no]" id="tfn_no" placeholder="TFN No." value="<?php echo set_value('data[tfn_no]', $record->tfn_no); ?>">
                            </div>

                        </div>

                    </div>
                
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">Other Details</h3>
                        </div>
                        <!-- /.box-header -->
                        
                        <div class="box-body">

                            <?php if ($profile): ?>
                                <style>
                                    .progress {
                                        display: none;
                                        margin: 10px 0;
                                    }
                                    #imagePreview img{
                                        opacity: 0.3;
                                    }
                                    .imageview-container{
                                        display: inline-block;
                                        position: relative;
                                    }
                                    .imageview-container span.delete{
                                        display: inline-block;
                                        position: absolute;
                                        top: 10px;
                                        right: 10px;
                                        background-color: rgba(0,0,0,0.1);
                                        color: rgba(255, 255, 255, 0.50);
                                        padding: 3px 10px;
                                        border-radius: 3px;
                                        font-weight: bold;
                                        cursor: pointer;
                                    }
                                    .imageview-container:hover span.delete{
                                        background-color: rgba(0,0,0,1);
                                        color: rgba(255, 255, 255, 1);
                                    }

                                    .imageview-container span.delete.uploading{
                                        display: none;
                                    }
                                </style>
                                <div class="form-group">
                                    <label for="image">Choose Profile Image</label>
                                    <input type="hidden" name="data[image]" id="image" value="<?php echo set_value('data[image]', $record->image); ?>">
                                    <input type="file" class="form-control" id="imageFile">
                                    <input type="hidden" id="UPLOAD_URL" value="<?php echo site_url( 'file_uploader/image/'.$record->id ); ?>">
                                    <input type="hidden" id="DELETE_URL" value="<?php echo site_url( 'file_uploader/delete_via_ajax/' ); ?>">
                                    <input type="hidden" id="RECORD_ID" value="<?php echo $record->id; ?>">
                                    <input type="hidden" id="MODEL" value="User">
                                    <input type="hidden" id="FOLDER" value="profile_images">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                            0%
                                        </div>
                                    </div>

                                </div>
                            <?php endif ?>

                            <div class="form-group <?php echo form_error('data[system_color]')? 'has-error':''; ?>">
                                <label for="system_color">System Colour:</label>
                                <div class="input-group my-colorpicker2 colorpicker-element">
                                    <div class="input-group-addon">
                                        <i style="background-color: rgb(104, 67, 67);"></i>
                                    </div>
                                    <input type="text" class="form-control" name="data[system_color]" id="system_color" value="<?php echo set_value('data[system_color]', $record->system_color); ?>" placeholder="System_ Color">
                                </div><!-- /.input group -->
                                <?php echo form_error('data[system_color]','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[base_rate]')? 'has-error':''; ?>">
                                <label for="base_rate">Base Rate:</label>
                                <input type="text" class="form-control" name="data[base_rate]" id="base_rate" value="<?php echo set_value('data[base_rate]', $record->base_rate); ?>" placeholder="Base Rate">
                                <?php echo form_error('data[base_rate]','<p class="error-msg">','</p>'); ?>
                            </div>

                        </div>

                        <!-- /.box-body -->
                        <div class="box-footer hidden-md hidden-lg">
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
<script src="<?php echo base_url('assets/plugins/colorpicker/bootstrap-colorpicker.min.js'); ?>"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
<?php if ($profile): ?>
<script src="<?php echo base_url('assets/dist/js/imageupload.js'); ?>"></script>
<?php endif; ?>
<script>


    var addressAutocomplete, kin_address_street;
    function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        addressAutocomplete = new google.maps.places.Autocomplete(document.getElementById('address_street'),
            {
                types: ['geocode'],
                componentRestrictions: {country: 'au'}
            });

        kin_address_street = new google.maps.places.Autocomplete(document.getElementById('kin_address_street'),
            {
                types: ['geocode'],
                componentRestrictions: {country: 'au'}
            });

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        addressAutocomplete.addListener('place_changed', fillInAddress);
        kin_address_street.addListener('place_changed', fillInKinAddress);
    }

    function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = addressAutocomplete.getPlace();
        var location = "{lat: ";
            location += place.geometry.location.lat();
            location += ", lng: ";
            location += place.geometry.location.lng();
            location += "}";

        $('#address_location').val(location);

        // console.log(place);

        $('#address').val(place.name);
        $('#address_street').val('').blur();

        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            switch(addressType){
                case 'administrative_area_level_1' :
                    $('#address_state').val(place.address_components[i].short_name);
                    $('#address_long_state').val(place.address_components[2].long_name);
                break;

                case 'postal_code':
                    $('#address_post_code').val(place.address_components[i].short_name);
                break;

                case 'locality':
                    $('#address_suburb').val(place.address_components[i].long_name);
                break;

                case '':
            }
        }
    }

    function fillInKinAddress() {

        // Get the place details from the autocomplete object.
        var place = kin_address_street.getPlace();
        var location = "{lat: ";
            location += place.geometry.location.lat();
            location += ", lng: ";
            location += place.geometry.location.lng();
            location += "}";

        $('#kin_address').val(place.name);
        $('#kin_address_street').val('').blur();

        $('#kin_address_location').val(location);

        // console.log(place);
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            switch(addressType){
                case 'administrative_area_level_1' :
                    $('#kin_address_state').val(place.address_components[i].short_name);
                    $('#kin_address_long_state').val(place.address_components[2].long_name);
                break;

                case 'postal_code':
                    $('#kin_address_post_code').val(place.address_components[i].short_name);
                break;

                case 'locality':
                    $('#kin_address_suburb').val(place.address_components[i].long_name);
                break;

                case '':
            }
        }
    }

</script>

<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAqnjObX9xybABsjKQYnwEPn88sc7Yhh9I&callback=initAutocomplete"></script>


<script>

$(function () {
    $('#datetimepicker,#datetimepicker2').datetimepicker({
         format: 'DD/MM/YYYY'
   });

    //Colorpicker
    $(".my-colorpicker2").colorpicker();
});

</script>
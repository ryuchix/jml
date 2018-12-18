<?php $this->load->view( 'partials/header' ); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><?php echo ucwords($class_name) ?> <small><?php echo $record->id? 'Edit':'New'; ?></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( $class_name ); ?>"><i class="fa fa-user"></i> <?php echo ucwords($class_name); ?></a></li>
            <li class="active"><?php echo $record->id? 'Edit':'New'; ?></li>
        </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content">
        
        <div class="row">

            <!-- form start -->
            <form role="form" method="post" action="<?php echo site_url( $class_name.'/save/'.$record->id ); ?>">
                
                <div class="col-sm-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?php echo $record->id? 'Edit ':'New '; echo ucfirst($class_name) ?></h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <div class="form-group <?php echo form_error('data[name]')? 'has-error':''; ?>">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="data[name]" id="name" placeholder="Name" value="<?php echo set_value('data[name]', $record->name); ?>">
                                <?php echo form_error('data[name]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[phone]')? 'has-error':''; ?>">
                                <label for="phone">Phone</label>
                                <input type="tel" class="form-control" name="data[phone]" id="phone" placeholder="Phone #" value="<?php echo set_value('data[phone]', $record->phone); ?>">
                                <?php echo form_error('data[phone]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[email]')? 'has-error':''; ?>">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="data[email]" id="email" placeholder="Email" value="<?php echo set_value('data[email]', $record->email); ?>">
                                <?php echo form_error('data[email]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group">
                                <label for="website">Website</label>
                                <input type="url" class="form-control" name="data[website]" id="website" placeholder="Website" value="<?php echo set_value('data[website]', $record->website); ?>">
                            </div>

                            <div class="form-group">
                                <label for="contact_name">Contact Name:</label>
                                <input type="text" class="form-control" name="data[contact_name]" id="contact_name" placeholder="Contact Name" value="<?php echo set_value('data[contact_name]', $record->contact_name); ?>">
                            </div>

                            <input type="hidden" name="data[address_location]" id="address_location" value="<?php echo set_value('data[address_location]', $record->address_location); ?>">
                            <input type="hidden" name="data[address_long_state]" id="address_long_state" value="<?php echo set_value('data[address_long_state]', $record->address_long_state); ?>">

                        </div>
                    </div>

                    <!-- Tenders -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">Tenders</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            
                            <?php 
                                $tender = ['url_address' => '', 'username' => '', 'password' => ''];
                                if ($record->tender) {
                                    $tender = (array)json_decode($record->tender);

                                }
                             ?>

                            <div class="form-group <?php echo form_error('data[tender][url_address]')? 'has-error':''; ?>">
                                <label for="name">Url Address</label>
                                <input type="text" class="form-control" name="data[tender][url_address]" id="url_address" placeholder="Url Address" value="<?php echo set_value('data[tender][url_address]', $tender['url_address']); ?>">
                                <?php echo form_error('data[tender][url_address]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[tender][username]')? 'has-error':''; ?>">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" name="data[tender][username]" id="username" placeholder="Username" value="<?php echo set_value('data[tender][username]', $tender['username']); ?>">
                                <?php echo form_error('data[tender][username]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[tender][password]')? 'has-error':''; ?>">
                                <label for="password">Password</label>
                                <input type="text" class="form-control" name="data[tender][password]" id="password" placeholder="Password" value="<?php echo set_value('data[tender][password]', $tender['password']); ?>">
                                <?php echo form_error('data[tender][password]','<p class="error-msg">','</p>') ?>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary hidden-xs hidden-sm" name="submit">Submit</button>
                        </div>
                    </div>

                    <!-- Waste Departments -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">Waste Department</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            
                            <?php 
                                $waste_department = ['surname' => '', 'name' => '', 'email' => '', 'phone' => '', 'role' => ''];
                                if ($record->waste_department) {
                                    $waste_department = (array)json_decode($record->waste_department);

                                }
                             ?>

                            <div class="form-group <?php echo form_error('data[waste_department][name]')? 'has-error':''; ?>">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="data[waste_department][name]" id="name" placeholder="Name" value="<?php echo set_value('data[waste_department][name]', $waste_department['name']); ?>">
                                <?php echo form_error('data[waste_department][name]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[waste_department][surname]')? 'has-error':''; ?>">
                                <label for="surname">Surname</label>
                                <input type="text" class="form-control" name="data[waste_department][surname]" id="surname" placeholder="Surname" value="<?php echo set_value('data[waste_department][surname]', $waste_department['surname']); ?>">
                                <?php echo form_error('data[waste_department][surname]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[waste_department][email]')? 'has-error':''; ?>">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="data[waste_department][email]" id="name" placeholder="Email" value="<?php echo set_value('data[waste_department][email]', $waste_department['email']); ?>">
                                <?php echo form_error('data[waste_department][email]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[waste_department][phone]')? 'has-error':''; ?>">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" name="data[waste_department][phone]" id="phone" placeholder="Phone" value="<?php echo set_value('data[waste_department][phone]', $waste_department['phone']); ?>">
                                <?php echo form_error('data[waste_department][phone]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[waste_department][role]')? 'has-error':''; ?>">
                                <label for="role">Role</label>
                                <input type="text" class="form-control" name="data[waste_department][role]" id="role" placeholder="Role" value="<?php echo set_value('data[waste_department][role]', $waste_department['role']); ?>">
                                <?php echo form_error('data[waste_department][role]','<p class="error-msg">','</p>') ?>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary hidden-xs hidden-sm" name="submit">Submit</button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="box box-primary">
                            <div class="box-header with-border">
                              <h3 class="box-title">Address Details</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">

                                <div class="form-group">
                                    <label for="address_street">Search Address:</label>
                                    <input type="text" class="form-control" name="address_street" id="address_street" placeholder="Search Address">
                                </div>

                                <div class="form-group <?php echo form_error('data[address]')? 'has-error':''; ?>">
                                    <label for="address_1">Address:</label>
                                    <input type="text" readonly class="form-control" name="data[address]" id="address_1" placeholder="Address" value="<?php echo set_value('data[address]', $record->address); ?>">
                                    <?php echo form_error('data[eaddressmail]','<p class="error-msg">','</p>') ?>
                                </div>

                                <div class="form-group <?php echo form_error('data[address_state]')? 'has-error':''; ?>">
                                    <label for="address_state">State:</label>
                                    <input type="text" class="form-control" name="data[address_state]" readonly id="address_state" placeholder="State" value="<?php echo set_value('data[address_state]', $record->address_state); ?>">
                                    <?php echo form_error('data[address_state]','<p class="error-msg">','</p>') ?>
                                </div>

                                <div class="form-group <?php echo form_error('data[address_suburb]')? 'has-error':''; ?>">
                                    <label for="address_suburb">Suburb:</label>
                                    <input type="text" class="form-control" name="data[address_suburb]" readonly id="address_suburb" placeholder="Suburb" value="<?php echo set_value('data[address_suburb]', $record->address_suburb); ?>">
                                    <?php echo form_error('data[address_suburb]','<p class="error-msg">','</p>') ?>
                                </div>

                                <div class="form-group <?php echo form_error('data[address_post_code]')? 'has-error':''; ?>">
                                    <label for="address_post_code">Postcode:</label>
                                    <input type="text" class="form-control" name="data[address_post_code]" readonly id="address_post_code" placeholder="Postcode" value="<?php echo set_value('data[address_post_code]', $record->address_post_code); ?>">
                                    <?php echo form_error('data[address_post_code]','<p class="error-msg">','</p>') ?>
                                </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary hidden-md hidden-lg" name="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <!-- /.row -->
    </section>
</div>

<?php $this->load->view( 'partials/footer' ); ?>

<script>
    var addressAutocomplete, billingAutocomplete;
    function initAutocomplete() {
        addressAutocomplete = new google.maps.places.Autocomplete(document.getElementById('address_street'),
            {
                types: ['geocode'],
                componentRestrictions: {country: 'au'}
            });

        addressAutocomplete.addListener('place_changed', fillInAddress);
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

        $('#address_1').val(place.name);
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
            }
        }
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAqnjObX9xybABsjKQYnwEPn88sc7Yhh9I&callback=initAutocomplete"></script>
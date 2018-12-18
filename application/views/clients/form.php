<?php $this->load->view( 'partials/header' ); ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--single {
        border-radius: 0;
        height: 34px;
        border-color: #d2d6de;
        padding-left: 0;
    }

    .select2-dropdown {
        border-radius: 0;
        border-color: #d2d6de;
    }
    span.select2.select2-container.select2-container--default {
        min-width: 100%;
    }

</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Clients <small><?php echo $record->id? 'Edit':'New'; ?></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( 'client/' ); ?>"><i class="fa fa-user"></i> Clients</a></li>
            <li class="active"><?php echo $record->id? 'Edit':'New'; ?></li>
        </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content">
        
        <div class="row">

            <!-- form start -->
            <form role="form" method="post" action="<?php echo site_url( 'client/save/'.$record->id ); ?>">
                <div class="col-sm-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?php echo $record->id? 'Edit':'New'; ?> Client</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            
                            <div class="form-group <?php echo form_error('data[is_prospect]')? 'has-error':''; ?>">
                                <label for="is_prospect">Select Client/Prospect:</label>
                                <?php 
                                echo form_dropdown('data[is_prospect]', array('Client', 'Prospect'), isset($_POST['data']['is_prospect'])?$_POST['data']['is_prospect']: $record->is_prospect, 'class="is_parent_choose form-control" id="is_prospect"'); ?>
                                <?php echo form_error('data[is_prospect]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[lead_type]')? 'has-error':''; ?>">
                                <label for="id_label_single">Lead Type:</label>
                                <?php echo form_dropdown('data[lead_type]', $lead_types, isset($_POST['data']['lead_type'])?$_POST['data']['lead_type']: $record->lead_type, 'class="is_parent_choose form-control" id="id_label_single"'); ?>
                                <?php echo form_error('data[lead_type]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[name]')? 'has-error':''; ?>">
                                <label for="name">Client Name</label>
                                <input type="text" class="form-control" name="data[name]" id="name" placeholder="Client Type" value="<?php echo set_value('data[name]', $record->name); ?>">
                                <?php echo form_error('data[name]','<p class="error-msg">','</p>') ?>
                            </div>
                            <div class="form-group <?php echo form_error('data[client_type]')? 'has-error':''; ?>">
                                <label for="id_label_single">Client Type:</label>
                                <?php echo form_dropdown('data[client_type]', $client_types, isset($_POST['data']['client_type'])?$_POST['data']['client_type']: $record->client_type, 'class="client_type form-control" id="id_label_single"'); ?>
                                <?php echo form_error('data[client_type]','<p class="error-msg">','</p>') ?>
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
                                <label for="website">Strata Plan</label>
                                <input type="text" class="form-control" name="data[strata_plan]" id="strata_plan" placeholder="Strata Plan" value="<?php echo set_value('data[strata_plan]', $record->strata_plan); ?>">
                            </div>

                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="data[is_parent]" <?php echo 
                                            isset($_POST['submit'])? 
                                                (isset($_POST['data']['is_parent']) && $_POST['data']['is_parent']==1)? 'checked': ''
                                            : ($record->is_parent==1)?"checked":'';
                                         ?>>Is parent?
                                    </label>
                                </div>
                            </div>

                            <div class="isnt-parent-condition" <?php echo 
                                            isset($_POST['submit'])? 
                                                (isset($_POST['data']['is_parent']) && $_POST['data']['is_parent']==1)? 'style="display: none;"':''
                                            :($record->is_parent==1)?'style="display: none;"':'';
                                         ?>">

                                <div class="form-group <?php echo form_error('data[child_of]')? 'has-error':''; ?>">
                                    <label for="child_of">Select Parent:</label>
                                    <?php echo form_dropdown('data[child_of]', $parent_clients, isset($_POST['data']['child_of'])?$_POST['data']['child_of']: $record->child_of, 'class="is_parent_choose form-control" id="child_of"'); ?>
                                    <?php echo form_error('data[child_of]','<p class="error-msg">','</p>') ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="address_street">Search Address:</label>
                                <input type="text" class="form-control" name="data[address_street]" id="address_street" placeholder="Search Address" value="<?php echo set_value('data[address_street]'); ?>">
                            </div>

                            <div class="form-group">
                                <label for="address_1">Address:</label>
                                <input type="text" class="form-control" name="data[address_1]" id="address_1" placeholder="Address" value="<?php echo set_value('data[address_1]', $record->address_1); ?>">
                            </div>

                            <div class="form-group">
                                <label for="address_state">State:</label>
                                <input type="text" class="form-control" name="data[address_state]" id="address_state" placeholder="State" value="<?php echo set_value('data[address_state]', $record->address_state); ?>">
                            </div>

                            <div class="form-group">
                                <label for="address_suburb">Suburb:</label>
                                <input type="text" class="form-control" name="data[address_suburb]" id="address_suburb" placeholder="State" value="<?php echo set_value('data[address_suburb]', $record->address_suburb); ?>">
                            </div>

                            <div class="form-group">
                                <label for="address_post_code">Postcode:</label>
                                <input type="text" class="form-control" name="data[address_post_code]" id="address_post_code" placeholder="State" value="<?php echo set_value('data[address_post_code]', $record->address_post_code); ?>">
                            </div>

                            <input type="hidden" name="data[address_location]" id="address_location" value="<?php echo set_value('data[address_location]', $record->address_location); ?>">
                            <input type="hidden" name="data[address_long_state]" id="address_long_state" value="<?php echo set_value('data[address_long_state]', $record->address_long_state); ?>">

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        </div>
                    </div>
                </div>
            
                <div class="col-sm-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">Billing Details</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <div class="form-group <?php echo form_error('data[attention]')? 'has-error':''; ?>">
                                <label for="attention">Attention</label>
                                <input type="text" class="form-control" name="data[attention]" id="attention" placeholder="Attention" value="<?php echo set_value('data[attention]', $record->attention); ?>">
                                <?php echo form_error('data[attention]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group">
                                <label for="co">C/O</label>
                                <input type="text" class="form-control" name="data[co]" id="co" placeholder="C/O" value="<?php echo set_value('data[co]', $record->co); ?>">
                            </div>

                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="data[same_billing_address]" <?php echo 
                                            isset($_POST['submit'])? 
                                                (isset($_POST['data']['same_billing_address']) && $_POST['data']['same_billing_address']==1)? 'checked': ''
                                            : ($record->same_billing_address==1)?"checked":'';
                                         ?>>Same address
                                    </label>
                                </div>
                            </div>

                            <div id="different_billing" <?php echo 
                                            isset($_POST['submit'])? 
                                                (isset($_POST['data']['same_billing_address']) && $_POST['data']['same_billing_address']==1)? 'style="display: none;"':''
                                            :($record->same_billing_address==1)?'style="display: none;"':'';
                                         ?>>

                                <div class="form-group">
                                    <label for="billing_address_street">Search Address:</label>
                                    <input type="text" class="form-control" name="data[billing_address_street]" id="billing_address_street" placeholder="Search Address" value="<?php echo set_value('data[billing_address_street]', $record->billing_address_street); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="billing_address_1">Address:</label>
                                    <input type="text" class="form-control" name="data[billing_address_1]" id="billing_address_1" placeholder="Address" value="<?php echo set_value('data[billing_address_1]', $record->billing_address_1); ?>">
                                </div>

                                <div class="form-group <?php echo form_error('data[billing_state]')? 'has-error':''; ?>">
                                    <label for="billing_state">State:</label>
                                    <input type="text" class="form-control" name="data[billing_state]" id="billing_state" placeholder="State" value="<?php echo set_value('data[billing_state]', $record->billing_state); ?>">
                                    <?php echo form_error('data[billing_state]','<p class="error-msg">','</p>') ?>
                                </div>

                                <div class="form-group <?php echo form_error('data[billing_suburb]')? 'has-error':''; ?>">
                                    <label for="billing_suburb">Suburb:</label>
                                    <input type="text" class="form-control" name="data[billing_suburb]" id="billing_suburb" placeholder="State" value="<?php echo set_value('data[billing_suburb]', $record->billing_suburb); ?>">
                                    <?php echo form_error('data[billing_suburb]','<p class="error-msg">','</p>') ?>
                                </div>

                                <div class="form-group <?php echo form_error('data[billing_post_code]')? 'has-error':''; ?>">
                                    <label for="billing_post_code">Postcode:</label>
                                    <input type="text" class="form-control" name="data[billing_post_code]" id="billing_post_code" placeholder="State" value="<?php echo set_value('data[billing_post_code]', $record->billing_post_code); ?>">
                                    <?php echo form_error('data[billing_post_code]','<p class="error-msg">','</p>') ?>
                                </div>

                                <input type="hidden" name="data[billing_address_location]" id="billing_address_location" value="<?php echo set_value('data[billing_address_location]'); ?>">
                                <input type="hidden" name="data[billing_long_state]" id="billing_long_state" value="<?php echo set_value('data[billing_long_state]'); ?>">

                            </div>

                        </div>
                    </div>
                </div>
            </form>

        </div>
        <!-- /.row -->
    </section>
</div>

<?php $this->load->view( 'partials/footer' ); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>


    var addressAutocomplete, billingAutocomplete;
    function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        addressAutocomplete = new google.maps.places.Autocomplete(document.getElementById('address_street'),
            {
                types: ['geocode'],
                componentRestrictions: {country: 'au'}
            });

        billingAutocomplete = new google.maps.places.Autocomplete(document.getElementById('billing_address_street'),
            {
                types: ['geocode'],
                componentRestrictions: {country: 'au'}
            });

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        addressAutocomplete.addListener('place_changed', fillInAddress);
        billingAutocomplete.addListener('place_changed', fillInBillingAddress);
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

                case '':
            }
        }
    }

    function fillInBillingAddress() {

        // Get the place details from the autocomplete object.
        var place = billingAutocomplete.getPlace();
        var location = "{lat: ";
            location += place.geometry.location.lat();
            location += ", lng: ";
            location += place.geometry.location.lng();
            location += "}";

        $('#billing_address_1').val(place.name);
        $('#billing_address_street').val('').blur();

        $('#billing_address_location').val(location);

        // console.log(place);
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            switch(addressType){
                case 'administrative_area_level_1' :
                    $('#billing_state').val(place.address_components[i].short_name);
                    $('#billing_long_state').val(place.address_components[2].long_name);
                break;

                case 'postal_code':
                    $('#billing_post_code').val(place.address_components[i].short_name);
                break;

                case 'locality':
                    $('#billing_suburb').val(place.address_components[i].long_name);
                break;

                case '':
            }
        }
    }

</script>

<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAqnjObX9xybABsjKQYnwEPn88sc7Yhh9I&callback=initAutocomplete"></script>

<script>

    $(function () {
    
        $(".client_type").select2({
            placeholder: "Select client type",
            allowClear: true
        });

        $(".is_parent_choose").select2({
          placeholder: "Select Parent Client",
          allowClear: true
        });
        
        var $isntParentCondition = $('.isnt-parent-condition');
        $("[name='data[is_parent]']").on('change', function(e){
            if( $(this).prop('checked') ){
                $isntParentCondition.slideUp();
            }else{
                if( $('#child_of option').length ){
                    $isntParentCondition.slideDown();
                }else{
                    alert("there is no Parent Client this must be parent");
                    $(this).prop('checked', true);
                }
            }
        });

        /* Billing addresss */
        var $differentBilling = $('#different_billing');
        $('[name="data[same_billing_address]"]').on('change', function (e) {
            
            if ( $(this).prop('checked') ) {
                $differentBilling.slideUp();
            }else{
                $differentBilling.slideDown();
            }

        });

    });

</script>
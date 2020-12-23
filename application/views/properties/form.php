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
        <h1><?php echo ucwords($class_name) ?> <?php echo $client_name; ?></h1>
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
            <form role="form" method="post" action="<?php echo site_url( $class_name.'/save/'.$record->id.$get_link ); ?>">
                
                <div class="col-sm-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?php echo $record->id? 'Edit ':'New '; echo ucfirst($class_name) ?></h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                        <?php if (isset($_GET['client']) && is_numeric($_GET['client'])): ?>
                            <div class="form-group <?php echo form_error('data[client_id]')? 'has-error':''; ?>" style="display: none;">
                                <label for="client_id">Choose Client:</label>
                                <?php echo form_dropdown('data[client_id]', $clients, $_GET['client'],
                                            'class="dropdown_lists form-control" id="client_id" data-placeholder="Choose Client"'); ?>
                                <?php echo form_error('data[client_id]','<p class="error-msg">','</p>') ?>
                            </div>
                        <?php else: ?>
                            <div class="form-group <?php echo form_error('data[client_id]')? 'has-error':''; ?>">
                                <label for="client_id">Choose Client:</label>
                                <?php echo form_dropdown('data[client_id]', $clients, 
                                                                            isset($_POST['data']['client_id'])? $_POST['data']['client_id']:$record->client_id
                                                                            , 'class="dropdown_lists form-control" id="client_id" data-placeholder="Choose Client"'); ?>
                                <?php echo form_error('data[client_id]','<p class="error-msg">','</p>') ?>
                            </div>
                        <?php endif; ?>

                            <div class="form-group <?php echo form_error('data[contact_id]')? 'has-error':''; ?>" id="contact_container">
                                <label for="contact_id">Choose Contact:</label>
                                <?php echo form_dropdown('data[contact_id]', $contacts, $record->contact_id, 'class="dropdown_lists form-control" id="contact_id" data-placeholder="Choose Contact"'); ?>
                                <?php echo form_error('data[contact_id]','<p class="error-msg">','</p>') ?>
                                <input type="hidden" id="contact_id_hidden" value="<?php echo set_value('data[contact_id]', $record->contact_id) ?>">
                            </div>

                            <div class="form-group <?php echo form_error('data[council_id]')? 'has-error':''; ?>" id="contact_container">
                                <label for="council_id">Choose Council:</label>
                                <?php echo form_dropdown('data[council_id]', $councils, $record->council_id, 'class="dropdown_lists form-control" id="council_id" data-placeholder="Choose Council"'); ?>
                                <?php echo form_error('data[council_id]','<p class="error-msg">','</p>') ?>
                                <input type="hidden" id="council_id_hidden" value="<?php echo set_value('data[council_id]', $record->council_id) ?>">
                            </div>

                            <div class="form-group <?php echo form_error('data[contact_id]')? 'has-error':''; ?>">
                                <button type="button" class="btn btn-primary btn-block btn-sm" style="display: none;" id="addContact"
                                            data-remote="false" data-toggle="modal" data-target="#myModal">Add Contact</button>
                                <?php echo form_error('data[contact_id]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group">
                                <label for="strata_plan">Strata Plan:</label>
                                <input type="text" class="form-control" name="data[strata_plan]" value="<?php echo set_value('data[strata_plan]', $record->strata_plan); ?>" name="services[]" id="strata_plan" placeholder="Strata Plan">
                            </div>

                            <div class="form-group">
                                <label>Notes</label>
                                <textarea class="form-control" rows="3" name="data[notes]" placeholder="Notes"><?php echo set_value('data[notes]', $record->notes); ?></textarea>
                            </div>

                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="allow_contractors" 
                                            <?php echo ((isset($_POST['allow_contractors']) && $_POST['allow_contractors'] == "1") || $record->allow_contractors)? 'checked': ''; ?>>
                                        Allow Contractors
                                    </label>
                                </div>
                            </div>

                            <div class="form-group <?php echo form_error('services[]')? 'has-error':''; ?>">
                                <label for="strata_plan">Choose Services</label>
                                <?php foreach ($services as $key => $value): ?>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="<?php echo $key; ?>" name="services[]" <?php echo 
                                                isset($_POST['submit'])? 
                                                    (isset($_POST['services'][$key]) && $_POST['services'][$key])? 'checked': ''
                                                : in_array($key, $selected_services)? "checked":'';
                                             ?>>
                                             <?php echo $value; ?>
                                        </label>
                                    </div>
                                <?php endforeach ?>
                                <?php echo form_error('services[]','<p class="error-msg">','</p>') ?>
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

                                <input type="hidden" name="data[address_location]" id="address_location" value="<?php echo set_value('data[address_location]', $record->address_location); ?>">
                                <input type="hidden" name="data[address_long_state]" id="address_long_state" value="<?php echo set_value('data[address_long_state]', $record->address_long_state); ?>">

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

<?php $this->load->view( 'clients/contact_pop_form' ); ?>

<?php $this->load->view( 'partials/footer' ); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script>
    
    $(function () {

        /* Add Contact Form */
        $('#contactForm').on('submit', function(event) {
            event.preventDefault();
            
            $.ajax({
                 url: $(this).attr('action'),
                 type: 'POST',
                 dataType: 'json',
                 data: $(this).serialize(),
             })
             .done(function(data) {
                 if(data.error){
                    var error = '<div class="alert alert-danger">'+
                                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+
                                '<strong>Errors</strong>'+ data.message +
                                '</div>';
                    $('#errorContainer').hide().html('').html(error).slideDown('slow');
                 }else{
                    
                    $('#contact_container').slideToggle().find('select').html('<option value="'+data.record.id+'" selected>'+data.record.contact_name+'</option>');
                    $('#contact_id_hidden').val(data.record.contact_name);
                    $('#addContact').slideToggle();

                    $('#contactForm')[0].reset();
                    $('#errorContainer').html('');
                    $('[data-dismiss="modal"]').trigger('click');                    
                 }
             })
             .fail(function() {
                 console.log("error");
             })
             .always(function() {
                 console.log("complete");
             }); 

        });

        $(".dropdown_lists").select2({
            placeholder: $(this).data('placeholder'),
            allowClear: true
        });

        $('#client_id').on('change', function(event) {
            event.preventDefault();
            var client_id = $(this).val();
            $('#client_hidden_value').val(client_id);
            $.ajax({
                url: '<?php echo site_url( 'property/get_client_contact/' ); ?>',
                type: 'POST',
                dataType: 'json',
                data: {'client_id': client_id },
            })
            .done(function(data) {
                if(Object.keys(data).length>1){

                    if ( !$('#contact_container').is(':visible') ) { $('#contact_container').slideToggle(); }
                    if ( $('#addContact').is(':visible') ) { $('#addContact').slideToggle(); }

                    var options = '';
                    for (var property in data) {
                        if (data.hasOwnProperty(property)) {
                            options += '<option value="'+property+'">'+data[property]+'</option>';
                        }
                    }
                    $('#contact_id').html($(options))
                        .val( $('#contact_id_hidden').val() );
                }else{
                    $('#contact_container, #addContact').slideToggle();
                }

            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });
            
        });

        if ( $('#client_id').val() ) {
            $('#client_id').trigger('change');
        }

        $('input[readonly]').on('blur', function(e){ $(this).prop('readonly', true) });
        $('input[readonly]').on('dblclick', function(e){ $(this).prop('readonly', false) });
    });

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
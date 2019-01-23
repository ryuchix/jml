<?php $this->load->view( 'partials/header' ); ?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css">

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

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Quote <small><?php echo $record->id? 'edit': 'new'; ?></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( $class_name ); ?>"><i class="fa fa-file-text-o"></i> Quotes</a></li>
            <li class="active"><?php echo $record->id? 'Edit': 'New'; ?></li>
        </ol>
    </section>
    <br>

    <!-- Main content -->
    <section class="content">
        
        <!-- form start -->
        <form role="form" method="post" action="<?php echo site_url( $class_name."/save/".$record->id ); ?>">
            <div class="row">
                <div class="col-sm-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?php echo $record->id? 'Edit': 'Add New'; echo ' '. ucfirst(str_replace('_', ' ', $class_name)); ?></h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            
                            <div class="form-group <?php echo form_error('date')? 'has-error':''; ?>">
                                <label for="date">Quote date:</label>
                                <div class='input-group date' id='datetimepicker'>
                                    <input type="text" class="form-control" name="date" id="date" placeholder="Quote Date" value="<?php echo set_value('date', $record->id? local_date($record->date): date('d/m/Y')); ?>">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                <?php echo form_error('date','<p class="error-msg">','</p>'); ?>
                            </div>
                            
                            <div class="form-group <?php echo form_error('data[quote_no]')? 'has-error':''; ?>">
                                <label for="quote_no">Quotation no.</label>
                                <input type="text" class="form-control" name="data[quote_no]" id="quote_no" placeholder="Quotation no." value="<?php echo set_value('data[quote_no]', $record->quote_no); ?>">
                                <?php echo form_error('data[quote_no]','<p class="error-msg">','</p>') ?>
                            </div>
                            
                            <div class="form-group <?php echo form_error('data[ref_no]')? 'has-error':''; ?>">
                                <label for="ref_no">Reference no.</label>
                                <input type="text" class="form-control" name="data[ref_no]" id="ref_no" placeholder="Reference no." value="<?php echo set_value('data[ref_no]', $record->ref_no); ?>">
                                <?php echo form_error('data[ref_no]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[client_id]')? 'has-error':''; ?>">
                                <label for="client_id">Choose Client:</label>
                                <input id="client_hidden_value" value="<?php echo set_value('data[client_id]', $record->client_id) ?>" type="hidden"/>
                                <?php echo form_dropdown('data[client_id]', $clients,
                                            isset($_POST['data']['client_id'])? $_POST['data']['client_id']:$record->client_id
                                            , 'class="dropdown_lists form-control" id="client_id" data-placeholder="Choose Client"'); ?>
                                <?php echo form_error('data[client_id]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[property_id]')? 'has-error':''; ?>">
                                <label for="property_id">Choose Property</label>
                                <input id="property_id_hidden" value="<?php echo set_value('data[property_id]', $record->property_id) ?>" type="hidden"/>
                                <?php echo form_dropdown('data[property_id]', $properties, 
                                            isset($_POST['data']['property_id'])? $_POST['data']['property_id']:$record->property_id
                                            , 'class="dropdown_lists form-control" id="property_id" data-placeholder="Choose Property"'); ?>
                                <?php echo form_error('data[property_id]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[contact]')? 'has-error':''; ?>">
                                <label for="contact">Choose Contact</label>
                                <input id="contact_hidden" value="<?php echo set_value('data[contact]', $record->contact) ?>" type="hidden"/>
                                <?php echo form_dropdown('data[contact]', $contacts, 
                                            isset($_POST['data']['contact'])? $_POST['data']['contact']:$record->contact
                                            , 'class="dropdown_lists form-control" id="contact" data-placeholder="Choose Contact"'); ?>
                                <?php echo form_error('data[contact]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[sales_rep]')? 'has-error':''; ?>">
                                <label for="sales_rep">Sales Rep:</label>
                                <?php echo form_dropdown('data[sales_rep]', $users, 
                                                                            isset($_POST['data']['sales_rep'])? $_POST['data']['sales_rep']:$record->sales_rep
                                                                            , 'class="dropdown_lists form-control" id="sales_rep" data-placeholder="Choose..."'); ?>
                                <?php echo form_error('data[sales_rep]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[frequency]')? 'has-error':''; ?>">
                                <label for="frequency">Frequency</label>
                                <?php $frequencies = get_frequency(); 
                                echo form_dropdown('data[frequency]', $frequencies, $record->frequency, ' id="frequency" class="form-control" data-placeholder="Choose..."');
                                ?>
                                <?php echo form_error('data[frequency]','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[amount]')? 'has-error':''; ?>">
                                <label for="amount">Amount</label>
                                <input type="text" class="form-control" name="data[amount]" id="amount" placeholder="Amount" value="<?php echo set_value('data[amount]', $record->amount); ?>">
                                <?php echo form_error('data[amount]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[yearly]')? 'has-error':''; ?>">
                                <label for="yearly">Yearly</label>
                                <input type="text" class="form-control" name="data[yearly]" id="yearly" placeholder="Yearly" value="<?php echo set_value('data[yearly]', $record->yearly); ?>">
                                <?php echo form_error('data[yearly]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[chance]')? 'has-error':''; ?>">
                                <label for="chance">Chance</label>
                                <?php $chances = array('' => 'Choose...', 10 => '10%', 20 => '20%', 30 => '30%', 40 => '40%', 50 => '50%', 60 => '60%', 70 => '70%', 80 => '80%', 90 => '90%', 100 => '100%');
                                echo form_dropdown('data[chance]', $chances, $record->chance, ' id="chance" class="form-control" data-placeholder="Choose..."');
                                ?>
                                <?php echo form_error('data[chance]','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[service_id]')? 'has-error':''; ?>">
                                <label for="service_id">Services:</label>
                                <?php echo form_dropdown('data[service_id]', $services, 
                                                                            isset($_POST['data']['service_id'])? $_POST['data']['service_id']:$record->service_id
                                                                            , 'class="dropdown_lists form-control" id="service_id" data-placeholder="Choose..."'); ?>
                                <?php echo form_error('data[service_id]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[status]')? 'has-error':''; ?>" id="status">
                                <label for="status">Status</label>
                                <?php $status = array(
                                    '' => 'Choose...',
                                    STATUS_PENDING => 'Pending',
                                    STATUS_WON => 'Won',
                                    STATUS_LOST => 'Lost'
                                ); 

                                echo form_dropdown('data[status]', $status, $record->status, ' id="status" class="form-control" data-placeholder="Choose..."');
                                ?>
                                <?php echo form_error('data[status]','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('quote_won')? 'has-error':''; ?>" id="quote_won" style="display: <?php echo $record->status == STATUS_WON? 'block': 'none'; ?>;">
                                <label for="date">Quote won:</label>
                                <div class='input-group date' id='datetimepicker'>
                                    <input type="text" class="form-control" name="quote_won" id="date" placeholder="Quote Won" value="<?php echo set_value('date', $record->quote_won? local_date($record->quote_won): ''); ?>">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                <?php echo form_error('quote_won','<p class="error-msg">','</p>'); ?>
                            </div>
                            
                            <div class="form-group <?php echo form_error('last_contact')? 'has-error':''; ?>">
                                <label for="last_contact">Last Contact:</label>
                                <div class='input-group date' id='datetimepicker'>
                                    <input type="text" class="form-control" name="last_contact" id="last_contact" placeholder="Last Contact" value="<?php echo set_value('last_contact', $record->id? local_date($record->last_contact): date('d/m/Y')); ?>">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                <?php echo form_error('last_contact','<p class="error-msg">','</p>'); ?>
                            </div>
                            
                            <div class="form-group <?php echo form_error('next_contact')? 'has-error':''; ?>">
                                <label for="next_contact">Next Contact:</label>
                                <div class='input-group date' id='datetimepicker'>
                                    <input type="text" class="form-control" name="next_contact" id="next_contact" placeholder="Next Contact" value="<?php echo set_value('next_contact', $record->id? local_date($record->next_contact): ''); ?>">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                <?php echo form_error('next_contact','<p class="error-msg">','</p>'); ?>
                            </div>
                            
                            <div class="form-group <?php echo form_error('expected_signoff')? 'has-error':''; ?>">
                                <label for="expected_signoff">Expected Signoff:</label>
                                <div class='input-group date' id='datetimepicker'>
                                    <input type="text" class="form-control" name="expected_signoff" id="expected_signoff" placeholder="Expected Signoff" value="<?php echo set_value('expected_signoff', $record->id? local_date($record->expected_signoff): ''); ?>">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                <?php echo form_error('expected_signoff','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group">
                                <label>Notes</label>
                                <textarea class="form-control" rows="3" name="data[notes]" placeholder="Notes..."><?php echo set_value('data[notes]', $record->notes); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="file">Choose Files</label>
                                <input type="hidden" name="data[file]" id="image" value="<?php echo set_value('data[file]', $record->file); ?>">
                                <input type="file" class="form-control" id="imageFile">
                                <input type="hidden" id="UPLOAD_URL" value="<?php echo site_url( 'quote/upload_quote_file/'.$record->id ); ?>">
                                <input type="hidden" id="DELETE_URL" value="<?php echo site_url( 'quote/delete_via_ajax/' ); ?>">
                                <input type="hidden" id="RECORD_ID" value="<?php echo $record->id; ?>">
                                <input type="hidden" id="FOLDER" value="quotes">
                                <input type="hidden" id="MODEL" value="Quote">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                        0%
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">Attachment</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body" id="imagePreview">

                            <?php if ($record->id && $record->file): ?>
                                
                                <div class="imageview-container">
                                    <span class="delete" data-image-name="<?php echo $record->file; ?>">X</span>
                                    <a href="<?php echo base_url('uploads/quotes/'.$record->file) ?>" 
                                    download="<?php echo base_url('uploads/quotes/'.$record->file) ?>">
                                        <?php echo $record->file; ?>
                                    </a>
                                </div>

                            <?php endif; ?>

                        </div> <!-- .body -->
                    </div> <!-- .box-primary -->
                </div> <!-- .col-sm-4 -->
            </div>
            <!-- /.row -->
        </form>

    </section>
</div>

<?php $this->load->view( 'partials/footer' ); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/js/fileupload.js"></script>
<script>
    
$(function () {

    $('#status').on('change', function(e){
        if($(this).find('option:selected').val() == <?php echo STATUS_WON; ?>)
        {
            $('#quote_won').slideDown();
        }
        else
        {
            $('#quote_won').slideUp();
        }
    });

    $('.date').datetimepicker({
         format: 'DD/MM/YYYY'
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
            url: '<?php echo site_url( 'client/get_properties_service/' ); ?>',
            type: 'POST',
            dataType: 'json',
            data: {'client_id': client_id },
        })
        .done(function(data) {
            if(Object.keys(data).length>1){

                var options = '';
                for (var property in data) {
                    if (data.hasOwnProperty(property)) {
                        options += '<option value="'+property+'">'+data[property]+'</option>';
                    }
                }
                $('#property_id').html($(options))
                    .val( $('#property_id_hidden').val() );
            }
        });
        
        $.ajax({
            url: '<?php echo site_url( 'client/get_contacts_service/' ); ?>',
            type: 'POST',
            dataType: 'json',
            data: {'client_id': client_id },
        })
        .done(function(data) {
            if(Object.keys(data).length>1){

                var options = '';
                for (var property in data) {
                    if (data.hasOwnProperty(property)) {
                        options += '<option value="'+property+'">'+data[property]+'</option>';
                    }
                }
                $('#contact').html($(options))
                    .val( $('#contact_hidden').val() );
            }

        });
    });

    

    if ( $('#client_id').val() ) {
        $('#client_id').trigger('change');
    }

});

</script>
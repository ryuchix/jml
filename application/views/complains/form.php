<?php $this->load->view( 'partials/header' ); ?>
<link rel="stylesheet" href="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css">
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
        <h1>Complaints <small><?php echo $record->id? 'edit': 'new'; ?></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( 'complaints/' ); ?>"><i class="fa fa-user"></i> Complaints</a></li>
            <li class="active"><?php echo $record->id? 'Edit': 'New'; ?></li>
        </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content">
        
        <div class="row">

            <!-- form start -->
            <form role="form" method="post" action="<?php echo site_url( "complaints/save/".$record->id ); ?>">
                <div class="col-sm-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?php echo $record->id? 'Edit': 'Add'; ?> Issue</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <h4>Customer Information</h4>
                            <hr>
                            <div class="form-group <?php echo form_error('data[client_id]')? 'has-error':''; ?>">
                                <label for="client_id">Choose Client</label>
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

                            <div class="form-group <?php echo form_error('data[reported_by]')? 'has-error':''; ?>">
                                <div class="form-group <?php echo form_error('data[reported_by]')? 'has-error':''; ?>">
                                    <label for="reported_by">Reported By</label>
                                    <input type="text" class="form-control" name="data[reported_by]" id="reported_by" placeholder="Reported By" value="<?php echo set_value('data[reported_by]', $record->reported_by); ?>">
                                    <?php echo form_error('data[reported_by]','<p class="error-msg">','</p>') ?>
                                </div>
                            </div>

                            <hr>
                            <h4>Issue / Complaint Information</h4>
                            <hr>

                            <div class="form-group <?php echo form_error('complain_date')? 'has-error':''; ?>">
                                <label for="complain_date">Issue / Complaint Date</label>
                                <div class='input-group date' id='datetimepicker'>
                                    <input type="text" class="form-control" name="complain_date" id="complain_date" placeholder="Issue / Complaint Date" value="<?php echo set_value('complain_date', $record->id? local_date($record->complain_date):date('d/m/Y')); ?>">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                <?php echo form_error('complain_date','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[complain_taken_by]')? 'has-error':''; ?>">
                                <label for="complain_taken_by">Issue / Complaint taken by</label>
                                <?php echo form_dropdown('data[complain_taken_by]', $users, 
                                                                            isset($_POST['data']['complain_taken_by'])? $_POST['data']['complain_taken_by']:$record->complain_taken_by
                                                                            , 'class="dropdown_lists form-control" id="complain_taken_by" data-placeholder="Issue / Complaint taken by"'); ?>
                                <?php echo form_error('data[complain_taken_by]','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[complain_details]')? 'has-error':''; ?>">
                                <label>Issue/Complaints Details</label>
                                <textarea class="form-control" rows="3" name="data[complain_details]" placeholder="Issue/Complaints Details..."><?php echo set_value('data[complain_details]', $record->complain_details); ?></textarea>
                                <?php echo form_error('data[complain_details]','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[first_response_corrective_action]')? 'has-error':''; ?>">
                                <label>First Response Corrective Action</label>
                                <textarea class="form-control" rows="3" name="data[first_response_corrective_action]" placeholder="First Response Corrective Action..."><?php echo set_value('data[first_response_corrective_action]', $record->first_response_corrective_action); ?></textarea>
                                <?php echo form_error('data[first_response_corrective_action]','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group">
                                <label>Suspected Cause</label>
                                <textarea class="form-control" rows="3" name="data[suspected_cause]" placeholder="Suspected Cause..."><?php echo set_value('data[suspected_cause]', $record->suspected_cause); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Corrective Action Response</label>
                                <textarea class="form-control" rows="3" name="data[corrective_action_response]" placeholder="Corrective Action Response..."><?php echo set_value('data[corrective_action_response]', $record->corrective_action_response); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Corrective Action Follow up</label>
                                <textarea class="form-control" rows="3" name="data[corrective_action_followup]" placeholder="Corrective Action Follow up..."><?php echo set_value('data[corrective_action_followup]', $record->corrective_action_followup); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>What steps should be considered to avoid a repeat of the problem</label>
                                <textarea class="form-control" rows="3" name="data[step_to_avoid_same_issue]" placeholder="What steps should be considered to avoid a repeat of the problem"><?php echo set_value('data[step_to_avoid_same_issue]', $record->step_to_avoid_same_issue); ?></textarea>
                            </div>

                            <div class="form-group <?php echo form_error('data[status]')? 'has-error':''; ?>">
                                <label for="status">Status</label>
                                <?php 
                                $statuses = array( ''=>'Choose status',STATUS_OPEN=>'Open', STATUS_ASSIGNED=>'Assigned', STATUS_RESOLVED=>'Resolved', STATUS_CLOSED=>'Closed' );
                                echo form_dropdown('data[status]', $statuses, 
                                                                            isset($_POST['data']['status'])? $_POST['data']['status']:$record->status
                                                                            , 'class="dropdown_lists form-control" id="status" data-placeholder="Choose Status"'); ?>
                                <?php echo form_error('data[status]','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[assigned_to]')? 'has-error':''; ?>">
                                <label for="assigned_to">Assigned</label>
                                <?php echo form_dropdown('data[assigned_to]', $users, 
                                                                            isset($_POST['data']['assigned_to'])? $_POST['data']['assigned_to']:$record->assigned_to
                                                                            , 'class="dropdown_lists form-control" id="assigned_to" data-placeholder="Choose User"'); ?>
                                <?php echo form_error('data[assigned_to]','<p class="error-msg">','</p>'); ?>
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
<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>

$(function () {

    $('#datetimepicker').datetimepicker({
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

});

</script>
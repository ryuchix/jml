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
        <h1>Vehicle Odometer <small><?php echo $record->id? 'edit': 'new'; ?></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( 'vehicle/' ); ?>"><i class="fa fa-car"></i> Vehicle</a></li>
            <li><a href="<?php echo site_url( "odometer/lists/$vehicle_id" ); ?>"><i class="fa fa-car"></i> Odometer</a></li>
            <li class="active"><?php echo $record->id? 'Edit': 'New'; ?></li>
        </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content">
        
        <div class="row">

            <!-- form start -->
            <form role="form" method="post" action="<?php echo site_url( "odometer/save/$vehicle_id/$record->id" ); ?>">
                <div class="col-sm-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?php echo $record->id? 'Edit': 'Add New'; ?> Odometer</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <div class="form-group <?php echo form_error('date')? 'has-error':''; ?>">
                                <label for="date">Date</label>
                                <div class='input-group date' id='datetimepicker'>
                                    <input type="text" class="form-control" name="date" id="date" placeholder="Date" value="<?php echo set_value('date', $record->id? local_date($record->date):''); ?>">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                                <?php echo form_error('date','<p class="error-msg">','</p>'); ?>
                            </div>
                            
                            <div class="form-group <?php echo form_error('data[start_time]')? 'has-error':''; ?>">
                                <label for="start_time">Start Time</label>
                                <input type="text" class="form-control" name="data[start_time]" id="start_time" placeholder="Start Time" value="<?php echo set_value('data[start_time]', $record->start_time); ?>">
                                <?php echo form_error('data[start_time]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[finish_time]')? 'has-error':''; ?>">
                                <label for="finish_time">Finish Time</label>
                                <input type="text" class="form-control" name="data[finish_time]" id="finish_time" placeholder="Finish Time" value="<?php echo set_value('data[finish_time]', $record->finish_time); ?>">
                                <?php echo form_error('data[finish_time]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[odometer_start]')? 'has-error':''; ?>">
                                <label for="odometer_start">Odometer Start</label>
                                <input type="text" class="form-control" name="data[odometer_start]" id="odometer_start" placeholder="Odometer Start" value="<?php echo set_value('data[odometer_start]', $record->odometer_start); ?>">
                                <?php echo form_error('data[odometer_start]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[odometer_finish]')? 'has-error':''; ?>">
                                <label for="odometer_finish">Odometer Finish</label>
                                <input type="text" class="form-control" name="data[odometer_finish]" id="odometer_finish" placeholder="Odometer Finish" value="<?php echo set_value('data[odometer_finish]', $record->odometer_finish); ?>">
                                <?php echo form_error('data[odometer_finish]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[purpose_of_trip]')? 'has-error':''; ?>">
                                <label for="purpose_of_trip">Purpose of trip</label>
                                <input type="text" class="form-control" name="data[purpose_of_trip]" id="purpose_of_trip" placeholder="Purpose of trip" value="<?php echo set_value('data[purpose_of_trip]', $record->purpose_of_trip); ?>">
                                <?php echo form_error('data[purpose_of_trip]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[driver]')? 'has-error':''; ?>">
                                <label for="driver">Name of Driver:</label>
                                <?php echo form_dropdown('data[driver]', $users, 
                                                                            isset($_POST['data']['driver'])? $_POST['data']['driver']:$record->driver
                                                                            , 'class="dropdown_lists form-control" id="driver" data-placeholder="Choose..."'); ?>
                                <?php echo form_error('data[driver]','<p class="error-msg">','</p>') ?>
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

    $('.date').datetimepicker({
         format: 'DD/MM/YYYY'
   });

    $(".dropdown_lists").select2({
        placeholder: $(this).data('placeholder'),
        allowClear: true
    });

});

</script>
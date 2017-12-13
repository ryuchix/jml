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
    .progress {
        display: none;
        margin: 10px 0;
    }
    #imagePreview img{
        opacity: 0.3;
    }
    .imageview-container{
        position: relative;
    }
    .imageview-container span.delete{
        display: inline-block;
        padding: 3px 10px;
        margin-right: 10px;
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
        <h1>Vehicle Services <small><?php echo $record->id? 'edit': 'new'; ?></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( 'vehicle/' ); ?>"><i class="fa fa-car"></i> Vehicle</a></li>
            <li><a href="<?php echo site_url( "vehicle_services/lists/$vehicle_id" ); ?>"><i class="fa fa-car"></i> Services</a></li>
            <li class="active"><?php echo $record->id? 'Edit': 'New'; ?></li>
        </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content">
        
        <div class="row">

            <!-- form start -->
            <form role="form" method="post" action="<?php echo site_url( "vehicle_services/save/$vehicle_id/$record->id" ); ?>">
                <div class="col-sm-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?php echo $record->id? 'Edit': 'Add New'; ?> Services</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <div class="form-group <?php echo form_error('date')? 'has-error':''; ?>">
                                <label for="date">Booked Date</label>
                                <div class='input-group date' id='datetimepicker'>
                                    <input type="text" class="form-control" name="date" id="date" placeholder="Booked Date" value="<?php echo set_value('date', $record->id? local_date($record->date):''); ?>">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                                <?php echo form_error('date','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[odometer]')? 'has-error':''; ?>">
                                <label for="odometer">Odometer</label>
                                <input type="text" class="form-control" name="data[odometer]" id="odometer" placeholder="Odometer" value="<?php echo set_value('data[odometer]', $record->odometer); ?>">
                                <?php echo form_error('data[odometer]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[cost]')? 'has-error':''; ?>">
                                <label for="cost">Cost</label>
                                <input type="text" class="form-control" name="data[cost]" id="cost" placeholder="Cost" value="<?php echo set_value('data[cost]', $record->cost); ?>">
                                <?php echo form_error('data[cost]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[next_service_odo]')? 'has-error':''; ?>">
                                <label for="next_service_odo">Next Service Odo</label>
                                <input type="text" class="form-control" name="data[next_service_odo]" id="next_service_odo" placeholder="Next Service Odo" value="<?php echo set_value('data[next_service_odo]', $record->next_service_odo); ?>">
                                <?php echo form_error('data[next_service_odo]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('next_service_date')? 'has-error':''; ?>">
                                <label for="next_service_date">Next Service Date</label>
                                <div class='input-group next_service_date' id='next_service_datetimepicker'>
                                    <input type="text" class="form-control" name="next_service_date" id="next_service_date" placeholder="Next Service Date" value="<?php echo set_value('next_service_date', $record->id? local_date($record->next_service_date):''); ?>">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                                <?php echo form_error('next_service_date','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group">
                                <label for="image">Choose File</label>
                                <input type="hidden" name="data[report]" id="image" value="<?php echo set_value('data[report]', $record->report); ?>">
                                <input type="file" class="form-control" id="imageFile">
                                <input type="hidden" id="UPLOAD_URL" value="<?php echo site_url( 'vehicle_services/upload/'.$record->id ); ?>">
                                <input type="hidden" id="DELETE_URL" value="<?php echo site_url( 'vehicle_services/delete_file/' ); ?>">
                                <input type="hidden" id="RECORD_ID" value="<?php echo $record->id; ?>">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                        0%
                                    </div>
                                </div>
                            </div>

                            <div class="form-group <?php echo form_error('data[supplier_id]')? 'has-error':''; ?>">
                                <label for="supplier_id">Supplier:</label>
                                <?php echo form_dropdown('data[supplier_id]', $suppliers, 
                                                                            isset($_POST['data']['supplier_id'])? $_POST['data']['supplier_id']:$record->supplier_id
                                                                            , 'class="dropdown_lists form-control" id="supplier_id" data-placeholder="Choose..."'); ?>
                                <?php echo form_error('data[supplier_id]','<p class="error-msg">','</p>') ?>
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

                            <?php if ($record->id && $record->report): ?>
                                
                                <div class="imageview-container">
                                    <span class="delete" data-image-name="<?php echo $record->report; ?>">X</span>
                                    <a href="<?php echo base_url('uploads/vehivle_services/'.$record->report) ?>" 
                                    download="<?php echo base_url('uploads/vehivle_services/'.$record->report) ?>">
                                        <?php echo $record->report; ?>
                                    </a>
                                </div>

                            <?php endif; ?>

                        </div> <!-- .body -->
                    </div> <!-- .box-primary -->
                </div> <!-- .col-sm-4 -->

            </form>

        </div>
        <!-- /.row -->
    </section>
</div>

<?php $this->load->view( 'partials/footer' ); ?>
<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/js/fileupload.js"></script>
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
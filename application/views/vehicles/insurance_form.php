<?php $this->load->view( 'partials/header' ); ?>
<link rel="stylesheet" href="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css">
<style>
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
        <h1>Vehicle Finance <small><?php echo $record->id? 'edit': 'new'; ?></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( 'vehicle/' ); ?>"><i class="fa fa-car"></i> Vehicle</a></li>
            <li class="active"><i class="fa fa-money"></i> Finance</li>
        </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content">
        
        <div class="row">

            <!-- form start -->
            <form role="form" method="post" action="<?php echo site_url( "vehicle/insurance/$record->id" ); ?>">
                <div class="col-sm-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">Insurance</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            
                            <div class="form-group <?php echo form_error('data[insurance_company]')? 'has-error':''; ?>">
                                <label for="insurance_company">Insurance Company</label>
                                <input type="text" class="form-control" name="data[insurance_company]" id="insurance_company" placeholder="Insurance Company" value="<?php echo set_value('data[insurance_company]', $record->insurance_company); ?>">
                                <?php echo form_error('data[insurance_company]','<p class="error-msg">','</p>') ?>
                            </div>
                            
                            <div class="form-group <?php echo form_error('data[insurance_number]')? 'has-error':''; ?>">
                                <label for="insurance_number">Insurance Number</label>
                                <input type="text" class="form-control" name="data[insurance_number]" id="insurance_number" placeholder="Insurance Number" value="<?php echo set_value('data[insurance_number]', $record->insurance_number); ?>">
                                <?php echo form_error('data[insurance_number]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('insurance_date')? 'has-error':''; ?>">
                                <label for="insurance_date">Insurance Date</label>
                                <div class='input-group date' id='datetimepicker'>
                                    <input type="text" class="form-control" name="insurance_date" id="insurance_date" placeholder="Insurance Date" value="<?php echo set_value('insurance_date', $record->id? local_date($record->insurance_date):''); ?>">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                                <?php echo form_error('insurance_date','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('insurance_expiry_date')? 'has-error':''; ?>">
                                <label for="insurance_expiry_date">Insurance Expiry Date</label>
                                <div class='input-group date' id='datetimepicker'>
                                    <input type="text" class="form-control" name="insurance_expiry_date" id="insurance_expiry_date" placeholder="Insurance Expiry Date" value="<?php echo set_value('insurance_expiry_date', $record->id? local_date($record->insurance_expiry_date):''); ?>">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                                <?php echo form_error('insurance_expiry_date','<p class="error-msg">','</p>'); ?>
                            </div>
                            
                            <div class="form-group <?php echo form_error('data[insurance_monthly_payment]')? 'has-error':''; ?>">
                                <label for="insurance_monthly_payment">Monthly Payment</label>
                                <input type="text" class="form-control" name="data[insurance_monthly_payment]" id="insurance_monthly_payment" placeholder="Monthly Payment" value="<?php echo set_value('data[insurance_monthly_payment]', $record->insurance_monthly_payment); ?>">
                                <?php echo form_error('data[insurance_monthly_payment]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group">
                                <label>Insurance Notes</label>
                                <textarea class="form-control" rows="3" name="data[insurance_notes]" placeholder="Insurance Notes..."><?php echo set_value('data[insurance_notes]', $record->insurance_notes); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="image">Choose File</label>
                                <input type="hidden" name="data[insurance_file]" id="image" value="<?php echo set_value('data[insurance_file]', $record->insurance_file); ?>">
                                <input type="file" class="form-control" id="imageFile">
                                <input type="hidden" id="UPLOAD_URL" value="<?php echo site_url( "vehicle/upload/$record->id/insurance_file" ); ?>">
                                <input type="hidden" id="DELETE_URL" value="<?php echo site_url( 'vehicle/delete_file/insurance_file/' ); ?>">
                                <input type="hidden" id="RECORD_ID" value="<?php echo $record->id; ?>">
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

                            <?php if ($record->id && $record->insurance_file): ?>
                                
                                <div class="imageview-container">
                                    <span class="delete" data-image-name="<?php echo $record->insurance_file; ?>">X</span>
                                    <a href="<?php echo base_url('uploads/vehivles/'.$record->insurance_file) ?>" 
                                    download="<?php echo base_url('uploads/vehivles/'.$record->insurance_file) ?>">
                                        <?php echo $record->insurance_file; ?>
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
<script src="<?php echo base_url(); ?>assets/dist/js/fileupload.js"></script>
<script>
    
$(function () {

    $('.date').datetimepicker({
         format: 'DD/MM/YYYY'
   });

});

</script>
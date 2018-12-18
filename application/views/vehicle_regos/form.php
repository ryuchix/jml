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
        <h1>Vehicle Rego <small><?php echo $record->id? 'edit': 'new'; ?></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( 'vehicle/' ); ?>"><i class="fa fa-car"></i> Vehicle</a></li>
            <li><a href="<?php echo site_url( "vehicle_rego/index/$vehicle_id" ); ?>"><i class="fa fa-car"></i> Rego</a></li>
            <li class="active"><?php echo $record->id? 'Edit': 'New'; ?></li>
        </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content">
        
        <div class="row">

            <!-- form start -->
            <form role="form" method="post" action="<?php echo site_url( "vehicle_rego/save/$vehicle_id/$record->id" ); ?>">
                <div class="col-sm-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?php echo $record->id? 'Edit': 'Add New'; ?> Rego</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            
                            <div class="form-group <?php echo form_error('data[rate]')? 'has-error':''; ?>">
                                <label for="rate">Rate</label>
                                <input type="text" class="form-control" name="data[rate]" id="rate" placeholder="Rate" value="<?php echo set_value('data[rate]', $record->rate); ?>">
                                <?php echo form_error('data[rate]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('due_date')? 'has-error':''; ?>">
                                <label for="due_date">Payment due before</label>
                                <div class='input-group date' id='datetimepicker'>
                                    <input type="text" class="form-control" name="due_date" id="due_date" placeholder="Expiry Date" value="<?php echo set_value('due_date', $record->id? local_date($record->due_date):''); ?>">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                                <?php echo form_error('due_date','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('expiry_date')? 'has-error':''; ?>">
                                <label for="expiry_date">Expiry Date</label>
                                <div class='input-group date' id='datetimepicker'>
                                    <input type="text" class="form-control" name="expiry_date" id="expiry_date" placeholder="Expiry Date" value="<?php echo set_value('expiry_date', $record->id? local_date($record->expiry_date):''); ?>">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                                <?php echo form_error('expiry_date','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[status]')? 'has-error':''; ?>">
                                <label for="status">Status</label>
                                <?php $status = array(
                                    '' => 'Choose...',
                                    STATUS_DUE => 'Due',
                                    STATUS_PAID => 'Paid',
                                ); 

                                echo form_dropdown('data[status]', $status, $this->input->post('data[status]')?$this->input->post('data[status]'): $record->status, ' id="status" class="form-control" data-placeholder="Choose..."');
                                ?>
                                <?php echo form_error('data[status]','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="hidable">
                                
                                <div class="form-group <?php echo form_error('paid_date')? 'has-error':''; ?>">
                                    <label for="paid_date">Paid Date</label>
                                    <div class='input-group date' id='datetimepicker'>
                                        <input type="text" class="form-control" name="paid_date" id="paid_date" placeholder="Paid Date" value="<?php echo set_value('paid_date', $record->id? local_date($record->paid_date):''); ?>">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                    <?php echo form_error('paid_date','<p class="error-msg">','</p>'); ?>
                                </div>
                                
                                <div class="form-group <?php echo form_error('data[receipt_no]')? 'has-error':''; ?>">
                                    <label for="receipt_no">Receipt No.</label>
                                    <input type="text" class="form-control" name="data[receipt_no]" id="receipt_no" placeholder="Receipt No." value="<?php echo set_value('data[receipt_no]', $record->receipt_no); ?>">
                                    <?php echo form_error('data[receipt_no]','<p class="error-msg">','</p>') ?>
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="image">Choose File</label>
                                <input type="hidden" name="data[file]" id="image" value="<?php echo set_value('data[file]', $record->file); ?>">
                                <input type="file" class="form-control" id="imageFile">
                                <input type="hidden" id="UPLOAD_URL" value="<?php echo site_url( 'vehicle_rego/upload/'.$record->id ); ?>">
                                <input type="hidden" id="DELETE_URL" value="<?php echo site_url( 'vehicle_rego/delete_file/' ); ?>">
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

                            <?php if ($record->id && $record->file): ?>
                                
                                <div class="imageview-container">
                                    <span class="delete" data-image-name="<?php echo $record->file; ?>">X</span>
                                    <a href="<?php echo base_url('uploads/vehivle_regos/'.$record->file) ?>" 
                                    download="<?php echo base_url('uploads/vehivle_regos/'.$record->file) ?>">
                                        <?php echo $record->file; ?>
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
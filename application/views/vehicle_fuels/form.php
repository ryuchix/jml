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
        <h1>Vehicle Fuel <small><?php echo $record->id? 'edit': 'new'; ?></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( 'vehicle/' ); ?>"><i class="fa fa-car"></i> Vehicle</a></li>
            <li><a href="<?php echo site_url( "vehicle_fuel/lists/$vehicle_id" ); ?>"><i class="fa fa-car"></i> Fuel</a></li>
            <li class="active"><?php echo $record->id? 'Edit': 'New'; ?></li>
        </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content">
        
        <div class="row">

            <!-- form start -->
            <form role="form" method="post" action="<?php echo site_url( "vehicle_fuel/save/$vehicle_id/$record->id" ); ?>">
                <div class="col-sm-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?php echo $record->id? 'Edit': 'Add New'; ?> Fuel</h3>
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

                            <div class="form-group <?php echo form_error('data[volume]')? 'has-error':''; ?>">
                                <label for="volume">Volume</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="data[volume]" id="volume" placeholder="Volume" value="<?php echo set_value('data[volume]', $record->volume); ?>">
                                    <span class="input-group-addon">L</span>
                                </div>
                                <?php echo form_error('data[volume]','<p class="error-msg">','</p>') ?>
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
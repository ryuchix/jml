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
        <h1>Vehicle <small><?php echo $record->id? 'edit': 'new'; ?></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( $class_name ); ?>"><i class="fa fa-car"></i> Vehicles</a></li>
            <li class="active"><?php echo $record->id? 'Edit': 'New'; ?></li>
        </ol>
    </section>
    <br>

    <!-- Main content -->
    <section class="content">
        
        <div class="row">

            <!-- form start -->
            <form role="form" method="post" action="<?php echo site_url( $class_name."/save/".$record->id ); ?>">
                <div class="col-sm-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?php echo $record->id? 'Edit': 'Add New'; echo ' '. ucfirst(str_replace('_', ' ', $class_name)); ?></h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            
                            <div class="form-group <?php echo form_error('data[license_plate]')? 'has-error':''; ?>">
                                <label for="license_plate">License Plate</label>
                                <input type="text" class="form-control" name="data[license_plate]" id="license_plate" placeholder="License Plate" value="<?php echo set_value('data[license_plate]', $record->license_plate); ?>">
                                <?php echo form_error('data[license_plate]','<p class="error-msg">','</p>') ?>
                            </div>
                            
                            <div class="form-group <?php echo form_error('data[make]')? 'has-error':''; ?>">
                                <label for="make">Make</label>
                                <input type="text" class="form-control" name="data[make]" id="make" placeholder="Make" value="<?php echo set_value('data[make]', $record->make); ?>">
                                <?php echo form_error('data[make]','<p class="error-msg">','</p>') ?>
                            </div>
                            
                            <div class="form-group <?php echo form_error('data[model]')? 'has-error':''; ?>">
                                <label for="model">Model</label>
                                <input type="text" class="form-control" name="data[model]" id="model" placeholder="Model" value="<?php echo set_value('data[model]', $record->model); ?>">
                                <?php echo form_error('data[model]','<p class="error-msg">','</p>') ?>
                            </div>
                            
                            <div class="form-group <?php echo form_error('data[year]')? 'has-error':''; ?>">
                                <label for="year">Year</label>
                                <input type="text" class="form-control" name="data[year]" id="year" placeholder="Year" value="<?php echo set_value('data[year]', $record->year); ?>">
                                <?php echo form_error('data[year]','<p class="error-msg">','</p>') ?>
                            </div>
                            
                            <div class="form-group <?php echo form_error('data[vin_no]')? 'has-error':''; ?>">
                                <label for="vin_no">Vin no.</label>
                                <input type="text" class="form-control" name="data[vin_no]" id="vin_no" placeholder="Vin no." value="<?php echo set_value('data[vin_no]', $record->vin_no); ?>">
                                <?php echo form_error('data[vin_no]','<p class="error-msg">','</p>') ?>
                            </div>
                            
                            <div class="form-group <?php echo form_error('data[color]')? 'has-error':''; ?>">
                                <label for="color">Colour</label>
                                <input type="text" class="form-control" name="data[color]" id="color" placeholder="Colour" value="<?php echo set_value('data[color]', $record->color); ?>">
                                <?php echo form_error('data[color]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[gas_type]')? 'has-error':''; ?>">
                                <label for="gas_type">Gasoline Type</label>
                                <?php 
                                $fuel_types = get_fuel_types(); 
                                echo form_dropdown('data[gas_type]', $fuel_types, $record->gas_type, ' id="gas_type" class="form-control dropdown-list" data-placeholder="Choose..."');
                                ?>
                                <?php echo form_error('data[gas_type]','<p class="error-msg">','</p>'); ?>
                            </div>
                            
                            <div class="form-group <?php echo form_error('data[garagge]')? 'has-error':''; ?>">
                                <label for="garagge">Garage</label>
                                <input type="text" class="form-control" name="data[garagge]" id="garagge" placeholder="Garage" value="<?php echo set_value('data[garagge]', $record->garagge); ?>">
                                <?php echo form_error('data[garagge]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[assign_to]')? 'has-error':''; ?>">
                                <label for="assign_to">Assign to</label>
                                <?php
                                echo form_dropdown('data[assign_to]', $users, $record->assign_to, 'id="assign_to" class="form-control dropdown-list" data-placeholder="Choose..."');
                                ?>
                                <?php echo form_error('data[assign_to]','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" rows="3" name="data[description]" placeholder="Description..."><?php echo set_value('data[description]', $record->description); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="image">Choose Files</label>
                                <input type="hidden" name="data[image]" id="image" value="<?php echo set_value('data[image]', $record->image); ?>">
                                <input type="file" class="form-control" id="imageFile">
                                <input type="hidden" id="UPLOAD_URL" value="<?php echo site_url( 'vehicle/upload/'.$record->id ); ?>">
                                <input type="hidden" id="DELETE_URL" value="<?php echo site_url( 'vehicle/delete_file/' ); ?>">
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
                          <h3 class="box-title">Image Preview</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body" id="imagePreview">

                            <?php if ($record->id && $record->image): ?>
                                
                                <div class="imageview-container">
                                    <span class="delete" data-image-name="<?php echo $record->image; ?>">X</span>
                                    <img class="img-responsive" src="<?php echo base_url('uploads/vehicles/'.$record->image) ?>" alt="Bin Attachemtn Preview" style="opacity: 1;">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/js/imageupload.js"></script>
<script>
    
$(function () {

    $(".dropdown-list").select2({
        placeholder: $(this).data('placeholder'),
        allowClear: true
    });

});

</script>
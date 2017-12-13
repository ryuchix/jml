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
        <h1><?php echo ucwords($class_name) ?> <small><?php echo $record->id? 'Edit':'New'; ?></small></h1>
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
            <form role="form" method="post" action="<?php echo site_url( $class_name.'/save/'.$record->id ); ?>">
                
                <div class="col-sm-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?php echo $record->id? 'Edit ':'New '; echo ucwords($class_name); ?></h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <div class="form-group <?php echo form_error('data[name]')? 'has-error':''; ?>">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="data[name]" id="name" placeholder="Name" value="<?php echo set_value('data[name]', $record->name); ?>">
                                <?php echo form_error('data[name]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[supplier_id]')? 'has-error':''; ?>">
                                <label for="id_label_single">Supplier</label>
                                <?php echo form_dropdown('data[supplier_id]', $suppliers, isset($_POST['data']['supplier_id'])?$_POST['data']['supplier_id']: $record->supplier_id, 'class="is_parent_choose form-control" id="id_label_single"'); ?>
                                <?php echo form_error('data[supplier_id]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[ref_code]')? 'has-error':''; ?>">
                                <label for="ref_code">Ref Code</label>
                                <input type="text" class="form-control" name="data[ref_code]" id="ref_code" placeholder="Ref Code" value="<?php echo set_value('data[ref_code]', $record->ref_code); ?>">
                                <?php echo form_error('data[ref_code]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[description]')? 'has-error':''; ?>">
                                <label>Description</label>
                                <textarea class="form-control" rows="3" name="data[description]" placeholder="Description..."><?php echo set_value('data[description]', $record->description); ?></textarea>
                                <?php echo form_error('data[description]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[price]')? 'has-error':''; ?>">
                                <label for="price">Price per box</label>
                                <input type="text" class="form-control" name="data[price]" id="price" placeholder="Price Per Box" value="<?php echo set_value('data[price]', $record->price); ?>">
                                <?php echo form_error('data[price]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[unit_per_box]')? 'has-error':''; ?>">
                                <label for="unit_per_box">No units per box</label>
                                <input type="number" class="form-control" name="data[unit_per_box]" id="unit_per_box" placeholder="No. of units per box" value="<?php echo set_value('data[unit_per_box]', $record->unit_per_box); ?>">
                                <?php echo form_error('data[unit_per_box]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group">
                                <label for="image">Choose Files</label>
                                <input type="hidden" name="data[image]" id="image" value="<?php echo set_value('data[image]', $record->image); ?>">
                                <input type="file" class="form-control" id="imageFile">
                                <input type="hidden" id="UPLOAD_URL" value="<?php echo site_url( 'file_uploader/image/'.$record->id ); ?>">
                                <input type="hidden" id="DELETE_URL" value="<?php echo site_url( 'file_uploader/delete_via_ajax/' ); ?>">
                                <input type="hidden" id="MODEL" value="<?php echo $class_name; ?>">
                                <input type="hidden" id="RECORD_ID" value="<?php echo $record->id; ?>">
                                <input type="hidden" id="FOLDER" value="<?php echo $class_name; ?>">
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
                                    <img class="img-responsive" src="<?php echo base_url('uploads/consumable/'.$record->image) ?>" alt="Consumable Image Preview" style="opacity: 1;">
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

<script src="<?php echo base_url(); ?>assets/dist/js/imageupload2.js"></script>

<script>
    $(function () {

    });
</script>
<?php $this->load->view( 'partials/header' ); ?>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/colorpicker.css">

<style>
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
        <h1>Bin Types<small><?php echo $record->id? 'edit': 'new'; ?></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( 'bin_type/' ); ?>"><i class="fa fa-user"></i> Bin Type</a></li>
            <li><a href="<?php echo site_url( 'bin_type/' ); ?>"><i class="fa fa-user"></i> lists</a></li>
            <li class="active"><?php echo $record->id? 'Edit': 'New'; ?> Bin Type</li>
        </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content">
        
        <div class="row">

            <!-- form start -->
            <form role="form" method="post" action="<?php echo site_url( "bin_type/save/".$record->id ); ?>">
                <div class="col-sm-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?php echo $record->id? 'Edit': 'Add New'; ?> Bin Type</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            
                            <div class="form-group <?php echo form_error('data[type]')? 'has-error':''; ?>">
                                <label for="type">Bin Type</label>
                                <input type="text" class="form-control" name="data[type]" id="type" placeholder="Bin type" value="<?php echo set_value('data[type]', $record->type); ?>">
                                <?php echo form_error('data[type]','<p class="error-msg">','</p>') ?>
                            </div>
                            
                            <div class="form-group <?php echo form_error('data[size]')? 'has-error':''; ?>">
                                <label for="size">Bin Size</label>
                                <input type="text" class="form-control" name="data[size]" id="size" placeholder="Bin size" value="<?php echo set_value('data[size]', $record->size); ?>">
                                <?php echo form_error('data[size]','<p class="error-msg">','</p>') ?>
                            </div>
                            
                            <div class="form-group <?php echo form_error('data[color]')? 'has-error':''; ?>">
                                <label for="color">Bin Lid Color</label>
                                <input type="text" class="form-control" name="data[color]" id="color" placeholder="Bin Lid Color" value="<?php echo set_value('data[color]', $record->color); ?>">
                                <?php echo form_error('data[color]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" rows="3" name="data[description]" placeholder="Description..."><?php echo set_value('data[description]', $record->description); ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="image">Choose Files</label>
                                <input type="hidden" name="data[image]" id="image" value="<?php echo set_value('data[image]', $record->image); ?>">
                                <input type="file" class="form-control" id="imageFile">
                                <input type="hidden" id="UPLOAD_URL" value="<?php echo site_url( 'file_uploader/image/'.$record->id ); ?>">
                                <input type="hidden" id="DELETE_URL" value="<?php echo site_url( 'file_uploader/delete_via_ajax/' ); ?>">
                                <input type="hidden" id="RECORD_ID" value="<?php echo $record->id; ?>">
                                <input type="hidden" id="MODEL" value="Bin_type">
                                <input type="hidden" id="FOLDER" value="bin_types">
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
                                    <img class="img-responsive" src="<?php echo base_url('uploads/bin_types/'.$record->image) ?>" alt="Bin Attachemtn Preview" style="opacity: 1;">
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
<script src="<?php echo base_url(); ?>assets/dist/js/colorpicker.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/js/imageupload.js"></script>
<script>
    
$(function () {
     $('#color').ColorPicker({
        'onChange': function (hsb, hex, rgb, el) {
            $('#color').val('#'+hex);
        }
     });

});

</script>
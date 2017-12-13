<?php $this->load->view( 'partials/header' ); ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
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
        <h1>Keys<small><?php echo $record->id? 'edit': 'new'; ?></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( 'property/' ); ?>"><i class="fa fa-user"></i> Property</a></li>
            <li><a href="<?php echo site_url( "property/keys/$property_id/lists" ); ?>"><i class="fa fa-user"></i> Keys</a></li>
            <li class="active"><?php echo $record->id? 'Edit': 'New'; ?></li>
        </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content">
        
        <div class="row">

            <!-- form start -->
            <form role="form" method="post" action="<?php echo site_url( "property/keys/$property_id/save/".$record->id ); ?>">
                <div class="col-sm-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?php echo $record->id? 'Edit': 'Add New'; ?> Key</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            
                            <div class="form-group">
                                <label for="id">Key No:</label>
                                <input type="text" class="form-control" readonly name="id" id="id" placeholder="Key No" value="<?php echo set_value('id', $record->id? 'key-'.$record->id:$expected_id); ?>">
                            </div>

                            <div class="form-group">
                                <label for="key_type">Key Types</label>
                                <?php echo form_dropdown('data[key_type_id]', $key_types, $record->key_type_id, 'class="form-control" id="key_type"'); ?>

                            </div>
                            
                            <div class="form-group <?php echo form_error('data[description]')? 'has-error':''; ?>">
                                <label for="description">Description</label>
                                <textarea class="form-control" rows="3" name="data[description]" placeholder="description..."><?php echo set_value('data[description]', $record->description); ?></textarea>
                                <?php echo form_error('data[description]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group">
                                <label for="image">Choose Files</label>
                                <input type="hidden" name="data[image]" id="image" value="<?php echo set_value('data[image]', $record->image); ?>">
                                <input type="file" class="form-control" id="imageFile">
                                
                                <input type="hidden" id="UPLOAD_URL" value="<?php echo site_url( 'file_uploader/image/'.$record->id ); ?>">
                                <input type="hidden" id="DELETE_URL" value="<?php echo site_url( 'file_uploader/delete_via_ajax/' ); ?>">
                                <input type="hidden" id="RECORD_ID" value="<?php echo $record->id; ?>">
                                <input type="hidden" id="MODEL" value="Property_keys">
                                <input type="hidden" id="FOLDER" value="property_keys">

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

                            <?php if ($record->id && $record->image): ?>
                                
                                <div class="imageview-container">
                                    <span class="delete" data-image-name="<?php echo $record->image; ?>">X</span>
                                    <img class="img-responsive" src="<?php echo base_url('uploads/property_keys/'.$record->image) ?>" alt="Key Attachemtn Preview" style="opacity: 1;">
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
<script src="<?php echo base_url(); ?>assets/dist/js/imageupload.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>
    
$(function () {

    $("#key_type").select2({
        placeholder: "Select Property Type",
        allowClear: true
    });

});

</script>
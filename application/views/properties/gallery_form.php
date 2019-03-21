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
        <h1>Gallery<small><?php echo $record->id? 'edit': 'new'; ?></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( 'property/' ); ?>"><i class="fa fa-user"></i> Property</a></li>
            <li><a href="<?php echo site_url( "property/gallery/$property_id/lists" ); ?>"><i class="fa fa-user"></i> Gallery</a></li>
            <li class="active"><?php echo $record->id? 'Edit': 'New'; ?></li>
        </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content">
        
        <div class="row">
            <?php $action_url = $record->id? site_url( "property/edit_gallery/".$record->id ): site_url( "property/gallery/$property_id/save/" ); ?>
            <!-- form start -->
            <form role="form" method="post" action="<?php echo $action_url; ?>" enctype="multipart/form-data">
                <div class="col-sm-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?php echo $record->id? 'Edit': 'Add New'; ?> Gallery</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            
                            <div class="form-group <?php echo form_error('data[name]')? 'has-error':''; ?>">
                                <label for="name">Gallery Name</label>
                                <input type="text" class="form-control" name="data[name]" id="name" placeholder="Gallery Name" value="<?php echo set_value('data[name]', $record->name); ?>">
                                <?php echo form_error('data[name]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[gallery_type]')? 'has-error':''; ?>">
                                <label for="gallery_type">Gallery Type</label>
                                <?php echo form_dropdown('data[gallery_type]', $gallery_types, $record->gallery_type, 'class="form-control" id="gallery_type"'); ?>
                            </div>
                            
                            <div class="form-group <?php echo form_error('data[description]')? 'has-error':''; ?>">
                                <label for="description">Description</label>
                                <textarea class="form-control" rows="3" name="data[description]" placeholder="description..."><?php echo set_value('data[description]', $record->description); ?></textarea>
                                <?php echo form_error('data[description]','<p class="error-msg">','</p>') ?>
                            </div>
                            <?php if (!$record->id): ?>
                            <div class="form-group">
                                <label for="image">Choose Files</label>
                                <input type="file" class="form-control" id="imageFile" name="upl_files[]" multiple>
                            </div>
                            <?php endif ?>

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>
    
$(function () {

    $("#gallery_type").select2({
        placeholder: "Select Gallery Type",
        allowClear: true
    });

});

</script>
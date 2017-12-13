<?php $this->load->view( 'partials/header' ); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Gallery<small><?php echo $record->id? 'edit': 'new'; ?></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( $context ); ?>"><i class="fa fa-user"></i> <?php echo ucfirst($context); ?></a></li>
            <li><a href="<?php echo site_url( "gallery/index/$context/$context_id" ); ?>"><i class="fa fa-user"></i> Gallery</a></li>
            <li class="active"><?php echo $record->id? 'Edit': 'New'; ?></li>
        </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content">
        
        <div class="row">
            <!-- form start -->
            <form role="form" method="post" action="<?php echo site_url( "gallery/append_gallery/$record->id" ); ?>" enctype="multipart/form-data">
                <div class="col-sm-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">Add Gallery Images</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <div class="form-group">
                                <label for="image">Choose Files</label>
                                <input type="file" class="form-control" id="imageFile" name="upl_files[]" multiple>
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
                          <h3 class="box-title">Add Gallery Images</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <?php foreach ($images as $image): ?>
                                <div class="image">
                                    <h4>
                                        <?php echo $image->title; ?> 
                                        <button type="button" class="btn btn-danger pull-right deleteImage" data-image="<?php echo $image->id; ?>"><i class="fa fa-times"></i></button>
                                    </h4>
                                    <img src="<?php echo base_url("uploads/gallery/$image->image"); ?>" alt="<?php echo $image->title ?>" class="img-responsive img-thumbnail">
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <!-- /.row -->
    </section>
</div>

<?php $this->load->view( 'partials/footer' ); ?>
<script>
    
$(function () {

    $('.deleteImage').on('click', function(event) {
        event.preventDefault();
        var $that = $(this);
        if (!confirm('Please make sure you want to delete this photo.!')) { return; }
        
        $.ajax({
            url: '<?php echo site_url( 'gallery/delete_gallery_image' ); ?>',
            type: 'POST',
            dataType: 'json',
            data: {image_id: $(this).data('image')},
        })
        .done(function(data) {
            if(data.status){
                $that.parent().parent().fadeOut('slow', function() {
                    $(this).remove();
                });;
            }
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });

    });

});

</script>
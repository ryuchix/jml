<?php $this->load->view( 'partials/header' ); ?>

<style>
    .image {
        position: relative;
    }

    .image>h4 {
        display: inline-block;
        position: absolute;
        right: 10px;
        top: 2px;
    }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Gallery<small>Image Description</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( 'property/' ); ?>"><i class="fa fa-user"></i> Property</a></li>
            <li><a href="<?php echo site_url( "property/gallery/$property_id/lists" ); ?>"><i class="fa fa-user"></i> Gallery</a></li>
            <li class="active"><?php echo $record->id? 'Edit': 'New'; ?></li>
        </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content ">
        
        <!-- form start -->
        <form role="form" method="post" action="<?php echo site_url( "property/gallery_description/$record->id" ); ?>">
            <div class="row grid">
                <?php foreach ($images as $image): ?>
                    <div class="col-sm-4 grid-item">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                              <h3 class="box-title"><?php echo $image->title; ?> </h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                            
                                <div class="image">
                                    <h4>
                                        <button type="button" class="btn btn-default pull-right deleteImage" data-image="<?php echo $image->id; ?>"><i class="fa fa-times"></i></button>
                                    </h4>
                                    <img src="<?php echo base_url("uploads/gallery/$image->image"); ?>" alt="<?php echo $image->title ?>" class="img-responsive img-thumbnail">
                                    <br>
                                    <div class="form-group">
                                        <label for="image-<?php echo $image->id ?>">Image Title:</label>
                                        <input type="text" class="form-control" name="data[<?php echo $image->id ?>][title]" id="image-<?php echo $image->id ?>" placeholder="Image Title" value="<?php echo set_value('data[<?php echo $image->id ?>][title]', $image->title) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" rows="2" name="data[<?php echo $image->id ?>][description]" placeholder="Description..."><?php echo set_value('data[<?php echo $image->id ?>][description]', $image->description); ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                <?php endforeach ?>
                
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    </div>
                </div>
            </div>
        </form>

    </section>
</div>

<?php $this->load->view( 'partials/footer' ); ?>
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script>
    
$(function () {

    $('.grid').masonry({
      // options
      itemSelector: '.grid-item',
    });

    $('.deleteImage').on('click', function(event) {
        event.preventDefault();
        var $that = $(this);
        if (!confirm('Please make sure you are not do this accidently.!')) { return; }
        
        $.ajax({
            url: '<?php echo site_url( 'property/delete_gallery_image' ); ?>',
            type: 'POST',
            dataType: 'json',
            data: {image_id: $(this).data('image')},
        })
        .done(function(data) {
            if(data.status){
                $that.parents('.col-sm-4').fadeOut('slow', function() {
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
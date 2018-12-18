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
        <h1>Bins<small><?php echo $record->id? 'edit': 'new'; ?></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( 'property/' ); ?>"><i class="fa fa-user"></i> Property</a></li>
            <li><a href="<?php echo site_url( "property/bins/$property_id/lists" ); ?>"><i class="fa fa-user"></i> Bin</a></li>
            <li class="active"><?php echo $record->id? 'Edit': 'New'; ?></li>
        </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content">
        
        <div class="row">

            <!-- form start -->
            <form role="form" method="post" action="<?php echo site_url( "property/bins/$property_id/save/".$record->id ); ?>">
                <div class="col-sm-8 col-sm-offset-2">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?php echo $record->id? 'Edit': 'Add New'; ?> Bin</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <div class="form-group <?php echo form_error('data[bin_type]')? 'has-error':''; ?>">
                                <label for="bin_type">Bin Types</label>
                                <input type="hidden" id="bin_type_id" value="<?php echo $record->bin_type; ?>">
                                
                                <!-- select name="data[bin_type]" class="form-control" id="bin_type">
                                </select> -->

                                <?php echo form_dropdown('data[bin_type]', [], $record->bin_type, 'class="form-control" id="bin_type"'); ?>
                                <?php echo form_error('data[bin_type]','<p class="error-msg">','</p>') ?>
                            </div>
                            
                            <div class="form-group <?php echo form_error('data[qty]')? 'has-error':''; ?>">
                                <label for="qty">Quantity</label>
                                <input type="text" class="form-control" name="data[qty]" id="qty" placeholder="Bin qty" value="<?php echo set_value('data[qty]', $record->qty); ?>">
                                <?php echo form_error('data[qty]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[notes]')? 'has-error':''; ?>">
                                <label for="note">Special Note</label>
                                <textarea class="form-control" rows="3" name="data[notes]" placeholder="Special Note..."><?php echo set_value('data[notes]', $record->notes); ?></textarea>
                                <?php echo form_error('data[notes]','<p class="error-msg">','</p>') ?>
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
<!-- <script src="<?php echo base_url(); ?>assets/dist/js/imageupload.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>
    
$(function () {

    <?php 
    $types = [];
    foreach ($bin_types as $bin):
        // x($bin);
        $tem = "{ id: $bin->id, text: '<div>$bin->type - $bin->size L<div class=\"pull-right\" style=\"background-color:$bin->color; width: 30px; height: 25px; margin: 0 10px;\"></div></div>' }"; 
        // echo $tem;
        $types[] = $tem; 

    endforeach ?>

    var data = [
        <?php echo join(',', $types); ?>
    ];

    $("#bin_type").select2({
        placeholder: "Select Bin Type",
        allowClear: true,
        data: data,
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
      
    });

    $('#bin_type').val($('#bin_type_id').val()).trigger('change');

});

</script>
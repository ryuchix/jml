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

</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><?php echo ucwords($class_name) ?> Consumable<small><?php echo $record->id? 'Edit':'New'; ?></small></h1>
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
            <form role="form" method="post" action="<?php echo site_url( $class_name."/consumables/$property_id/save/$record->id" ); ?>">
                
                <div class="col-sm-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?php echo $record->id? 'Edit ':'New '; echo ucfirst($class_name) ?> Consumable</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <input type="hidden" name="data[property_id]" value="<?php echo set_value('data[property_id]'); ?>">
                            <div class="form-group <?php echo form_error('data[consumable_id]')? 'has-error':''; ?>">
                                <label for="consumable_id">Choose Consumable:</label>
                                <?php echo form_dropdown('data[consumable_id]', $consumables, 
                                                                            isset($_POST['data']['consumable_id'])? $_POST['data']['consumable_id']:$record->consumable_id
                                                                            , 'class="dropdown_lists form-control" id="consumable_id" data-placeholder="Choose Consumable"'); ?>
                                <?php echo form_error('data[consumable_id]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group">
                                <label for="name">Consumable name:</label>
                                <input type="text" readonly class="form-control" name="name" value="<?php echo set_value('name', $cons->name); ?>" name="name" id="name" placeholder="Consumable name">
                            </div>

                            <div class="form-group">
                                <label for="price">Price Per Box:</label>
                                <input type="text" readonly class="form-control" name="price" value="<?php echo set_value('price', $cons->price); ?>" name="price" id="price" placeholder="Price Per Box">
                            </div>

                            <div class="form-group">
                                <label for="unit_per_box">Number of units per box:</label>
                                <input type="text" readonly class="form-control" name="unit_per_box" value="<?php echo set_value('unit_per_box', $cons->unit_per_box); ?>" name="unit_per_box" id="unit_per_box" placeholder="Number of units per box">
                            </div>

                            <div class="form-group">
                                <label for="unit_price">Price Per Unit:</label>
                                <input type="text" readonly class="form-control" name="unit_price" value="<?php echo set_value('unit_price', $record->id?($cons->price/$cons->unit_per_box):''); ?>" name="unit_price" id="unit_price" placeholder="Price Per Unit">
                            </div>

                            <div class="form-group <?php echo form_error('data[markup]')? 'has-error':''; ?>">
                                <label for="markup">Markup:</label>
                                <input type="text" class="form-control" name="data[markup]" value="<?php echo set_value('data[markup]', $record->markup?$record->markup:0); ?>" name="data[markup]" id="markup" placeholder="Markup">
                                <?php echo form_error('data[markup]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[soled_price_per_box]')? 'has-error':''; ?>">
                                <label for="soled_price_per_box">Price Sold Per Box:</label>
                                <input type="text" readonly class="form-control" name="data[soled_price_per_box]" value="<?php echo set_value('data[soled_price_per_box]', $record->soled_price_per_box); ?>" id="soled_price_per_box" placeholder="Price Sold Per Box">
                            </div>

                            <div class="form-group <?php echo form_error('data[soled_price_per_unit]')? 'has-error':''; ?>">
                                <label for="soled_price_per_unit">Price Sold Per Unit:</label>
                                <input type="text" readonly class="form-control" name="data[soled_price_per_unit]" value="<?php echo set_value('data[soled_price_per_unit]', $record->soled_price_per_unit); ?>" id="soled_price_per_unit" placeholder="Price Sold Per Unit">
                            </div>

                            <div class="form-group">
                                <label>Notes</label>
                                <textarea class="form-control" rows="3" name="data[notes]" placeholder="Notes"><?php echo set_value('data[notes]', $record->notes); ?></textarea>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary hidden-xs hidden-sm" name="submit">Submit</button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">Consumable Image</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div>
                                <img src="<?php echo $record->id? base_url("uploads/consumable/$cons->image"):'' ?>" alt="Consumable" id="img" class="img-thumbnail" <?php echo !$record->id? 'style="display: none;"':''; ?>>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary hidden-md hidden-lg" name="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <!-- /.row -->
    </section>
</div>

<?php $this->load->view( 'clients/contact_pop_form' ); ?>

<?php $this->load->view( 'partials/footer' ); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script>

    function calculatePrice() {
        var markup = parseFloat($("#markup").val()),
            price = parseFloat($("#price").val()),
            unit_per_box = parseFloat($("#unit_per_box").val());

        if ( markup && price ) {
            var soled_price_per_box = (price/100*markup)+price;
            $("#soled_price_per_box").val(soled_price_per_box.toFixed(2));
            $("#soled_price_per_unit").val((soled_price_per_box/unit_per_box).toFixed(2));
        }else{
            $("#soled_price_per_box").val(price);
            $("#soled_price_per_unit").val(price);
        }
    }
    
    $(function () {
        calculatePrice();

        $('#markup').on('keyup', function(event) {
            event.preventDefault();
            calculatePrice();
        });

        /* Populate Consumable by it's ID */
        var imageBaseUrl = '<?php echo base_url('uploads/consumable/'); ?>'
        $('#consumable_id').on('change', function(event) {
            event.preventDefault();
            
            $.ajax({
                 url: '<?php echo site_url("consumable/get_consumable_service") ?>',
                 type: 'POST',
                 dataType: 'json',
                 data: { 'consumable_id' : $(this).val() },
             })
             .done(function(data) {
                 console.log(data);
                 $('#img').attr('src', imageBaseUrl+data.image).slideDown('slow');
                 $('#name').val(data.name);
                 $('#unit_per_box').val(data.unit_per_box);
                 $('#price').val(data.price);
                 $('#unit_price').val(data.price/data.unit_per_box);
                 calculatePrice();
             })
             .fail(function() {
                 console.log("error");
             })
             .always(function() {
                 console.log("complete");
             }); 

        });

        $(".dropdown_lists").select2({
            placeholder: $(this).data('placeholder'),
            allowClear: true
        });

    });

</script>
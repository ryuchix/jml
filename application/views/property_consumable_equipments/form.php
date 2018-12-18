<?php $this->load->view( 'partials/header' ); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Property Consumable Equipment</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( 'property/' ); ?>"><i class="fa fa-user"></i> Property</a></li>
            <li><a href="<?php echo site_url( "property_consumable_equipment/index/$property_id" ); ?>"><i class="fa fa-user"></i> Consumable Equipment</a></li>
        </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content">
        
        <div class="row">

<!-- form start -->
<form role="form" method="post" action="<?php echo site_url( "property_consumable_equipment/save/$property_id" ); ?>">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $property->address . ', ' . $property->address_suburb . ', ' . $property->address_post_code ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                
                <input type="hidden" name="data[property_id]" value="<?php echo set_value("data[property_id]", $property_id); ?>">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group <?php echo form_error('equipment_types[]')? 'has-error':''; ?>">
                            <label for="strata_plan">Equipment Types</label>
                            <?php foreach ($equipment_types as $id => $row): ?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="<?php echo $row->id; ?>" name="equipment_types[<?php echo $id; ?>]" 
                                            <?php echo in_array($id, $equipment_types_ids)? "checked":'';
                                             ?>>
                                         <?php echo $row->type; ?>
                                    </label>
                                </div>
                            <?php endforeach ?>
                            <?php echo form_error('equipment_types[]','<p class="error-msg">','</p>') ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group <?php echo form_error('consumables[]')? 'has-error':''; ?>">
                            <label for="strata_plan">Consumables</label>
                            <?php foreach ($consumables as $id => $row): ?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="<?php echo $row->id; ?>" name="consumables[<?php echo $id; ?>]" <?php echo in_array($id, $consumables_ids)? "checked":'';
                                             ?>>
                                         <?php echo $row->name; ?>
                                    </label>
                                </div>
                            <?php endforeach ?>
                            <?php echo form_error('consumables[]','<p class="error-msg">','</p>') ?>
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

</form>

        </div>
        <!-- /.row -->
    </section>
</div>

<?php $this->load->view( 'partials/footer' ); ?>
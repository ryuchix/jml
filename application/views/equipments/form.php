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
    }    .select2-container--default .select2-selection--single {
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
        <h1>Equipment<small><?php echo $record->id? 'edit': 'new'; ?></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( $class_name ); ?>"><i class="fa fa-user"></i> Equipment</a></li>
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

                            <div class="form-group <?php echo form_error('data[equipment_type_id]')? 'has-error':''; ?>">
                                <label for="equipment_type_id">Equipment Type:</label>
                                <?php echo form_dropdown('data[equipment_type_id]', $equipment_types,
                                            isset($_POST['data']['equipment_type_id'])? $_POST['data']['equipment_type_id']:$record->equipment_type_id
                                            , 'class="dropdown_lists form-control" id="equipment_type_id" data-placeholder="Choose Equipment Type"'); ?>
                                <?php echo form_error('data[equipment_type_id]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[name]')? 'has-error':''; ?>">
                                <label for="name">Equipment Name</label>
                                <input type="text" class="form-control" name="data[name]" id="name" placeholder="Equipment Name" value="<?php echo set_value('data[name]', $record->name); ?>">
                                <?php echo form_error('data[name]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[serial_no]')? 'has-error':''; ?>">
                                <label for="serial_no">Serial no.</label>
                                <input type="text" class="form-control" name="data[serial_no]" id="serial_no" placeholder="Serial no." value="<?php echo set_value('data[serial_no]', $record->serial_no); ?>">
                                <?php echo form_error('data[serial_no]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group">
                                <label for="image">Choose Files</label>
                                <input type="hidden" name="data[image]" id="image" value="<?php echo set_value('data[image]', $record->image); ?>">
                                <input type="file" class="form-control" id="imageFile">
                                <input type="hidden" id="UPLOAD_URL" value="<?php echo site_url( 'file_uploader/image/'.$record->id ); ?>">
                                <input type="hidden" id="DELETE_URL" value="<?php echo site_url( 'file_uploader/delete_via_ajax/' ); ?>">
                                <input type="hidden" id="RECORD_ID" value="<?php echo $record->id; ?>">
                                <input type="hidden" id="MODEL" value="Equipment">
                                <input type="hidden" id="FOLDER" value="equipments">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                        0%
                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" rows="3" name="data[description]" placeholder="Description..."><?php echo set_value('data[description]', $record->description); ?></textarea>
                            </div>

                            <div class="form-group <?php echo form_error('data[supplier_id]')? 'has-error':''; ?>">
                                <label for="supplier_id">Supplier:</label>
                                <?php echo form_dropdown('data[supplier_id]', $suppliers,
                                                isset($_POST['data']['supplier_id'])? $_POST['data']['supplier_id']:$record->supplier_id
                                                , 'class="dropdown_lists form-control" id="supplier_id" data-placeholder="Choose Supplier"'); ?>
                                <?php echo form_error('data[supplier_id]','<p class="error-msg">','</p>') ?>
                            </div>
                            
                            <div class="form-group <?php echo form_error('purchased_date')? 'has-error':''; ?>">
                                <label for="purchased_date">Purchased Date:</label>
                                <div class='input-group date' id='datetimepicker'>
                                    <input type="text" class="form-control" name="purchased_date" id="purchased_date" placeholder="Purchased Date" value="<?php echo set_value('purchased_date', $record->id? local_date($record->purchased_date): date('d/m/Y')); ?>">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                <?php echo form_error('purchased_date','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[initial_cost]')? 'has-error':''; ?>">
                                <label for="initial_cost">Initial Cost.</label>
                                <input type="text" class="form-control" name="data[initial_cost]" id="initial_cost" placeholder="Initial Cost." value="<?php echo set_value('data[initial_cost]', $record->initial_cost); ?>">
                                <?php echo form_error('data[initial_cost]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[assigned]')? 'has-error':''; ?>">
                                <label for="assigned">Assigned:</label>
                                <?php echo form_dropdown('data[assigned]', $users,
                                                isset($_POST['data']['assigned'])? $_POST['data']['assigned']:$record->assigned
                                                , 'class="dropdown_lists form-control" id="assigned" data-placeholder="Choose assigned"'); ?>
                                <?php echo form_error('data[assigned]','<p class="error-msg">','</p>') ?>
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
                                    <img class="img-responsive" src="<?php echo base_url('uploads/equipments/'.$record->image) ?>" alt="Equipment Attachemnt Preview" style="opacity: 1;">
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
<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
<script src="<?php echo base_url('assets/dist/js/imageupload.js'); ?>"></script>
<script>
    
    $(function () {

        $('#datetimepicker').datetimepicker({
             format: 'DD/MM/YYYY'
        });

        $('.qty').on('keyup', function(event) {
            var $this = $(this),
                qty = parseFloat($this.val()),
                price =  parseFloat($this.parents('tr').find('td:eq(1)').text()),
                total =  $this.parents('tr').find('td:eq(3)');
                if (qty) {
                    total.text((qty*price).toFixed(2));
                }else{
                    total.text('-');
                }
        });

        $(".dropdown_lists").select2({
            placeholder: $(this).data('placeholder'),
            allowClear: true
        });

        $('#requestForm').on('submit', function(event) {
            var $qty = $('#itemsContainer tbody input.qty'),
                ret = true;
            if( !$qty.size() ){
                ret = false;
                alert('There should be at least one setting.');
            }else{
                $.each($qty, function(index, el) {
                    if ( ! $.trim( $(el).val() ) ){
                        ret = false;
                        alert("Make Sure you put QTY for "+$(el).parents('tr').find('td:eq(0) label').text());
                    }
                });
            }
            if (!ret) {
                event.preventDefault();
            }
            
        });

    });

</script>
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

        <h1>Equipment Serivce/Tag <small><?php echo $record->id? 'edit': 'new'; ?></small></h1>

        <ol class="breadcrumb">

            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>

            <li><a href="<?php echo site_url( "equipments/" ); ?>"><i class="fa fa-user"></i> Equipment</a></li>

            <li class="active"><?php echo $record->id? 'Edit': 'New'; ?></li>

        </ol>

    </section>

    <br>

    <!-- Main content -->
    <section class="content">
        
        <div class="row">

            <!-- form start -->
            <form role="form" method="post" action="<?php echo site_url( "$class_name/save/$equipment_id/$record->id" ); ?>">
                
                <input type="hidden" name="data[equipment_id]" value="<?php echo set_value('data[equipment_id]', $equipment_id); ?>">
                
                <div class="col-sm-8">
                
                    <div class="box box-primary">
                
                        <div class="box-header with-border">
                
                          <h3 class="box-title"><?php echo $record->id? 'Edit': 'Add New'; echo ' '. ucfirst(str_replace('_', ' ', $class_name)); ?></h3>
                
                        </div>
                
                        <!-- /.box-header -->
                        <div class="box-body">
                            
                            <div class="form-group <?php echo form_error('booked_date')? 'has-error':''; ?>">
                
                                <label for="booked_date">Tagged Date:</label>
                
                                <div class='input-group date' id='datetimepicker'>
                
                                    <input type="text" class="form-control" name="booked_date" id="booked_date" placeholder="Tagged Date" value="<?php echo set_value('booked_date', $record->id? local_date($record->booked_date): date('d/m/Y')); ?>">
                
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                
                                </div>
                
                                <?php echo form_error('booked_date','<p class="error-msg">','</p>'); ?>
                
                            </div>

                            <div class="form-group <?php echo form_error('data[cost]')? 'has-error':''; ?>">
                             
                                <label for="cost">Cost</label>
                             
                                <input type="text" class="form-control" name="data[cost]" id="cost" placeholder="Cost" value="<?php echo set_value('data[cost]', $record->cost); ?>">
                             
                                <?php echo form_error('data[cost]','<p class="error-msg">','</p>') ?>
                            
                            </div>

                            <div class="form-group">
                                <label for="file">Choose Files</label>
                                <input type="hidden" name="data[file]" id="image" value="<?php echo set_value('data[file]', $record->file); ?>">
                                <input type="file" class="form-control" id="imageFile">
                                <input type="hidden" id="UPLOAD_URL" value="<?php echo site_url( 'equipment_tags/upload_equipment_tag_file/'.$record->id ); ?>">
                                <input type="hidden" id="DELETE_URL" value="<?php echo site_url( 'equipment_tags/delete_via_ajax/' ); ?>">
                                <input type="hidden" id="RECORD_ID" value="<?php echo $record->id; ?>">
                                <input type="hidden" id="FOLDER" value="equipment_tags">
                                <input type="hidden" id="MODEL" value="Equipment_tags">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                        0%
                                    </div>
                                </div>

                            </div>
                            
                            <div class="form-group <?php echo form_error('next_service_date')? 'has-error':''; ?>">
                                
                                <label for="next_service_date">Tagged Date:</label>
                                
                                <div class='input-group date' id='datetimepicker'>
                                
                                    <input type="text" class="form-control" name="next_service_date" id="next_service_date" placeholder="Tagged Date" value="<?php echo set_value('next_service_date', $record->id? local_date($record->next_service_date):''); ?>">
                                
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                
                                </div>
                                
                                <?php echo form_error('next_service_date','<p class="error-msg">','</p>'); ?>
                            
                            </div>

                            <div class="form-group <?php echo form_error('data[supplier_id]')? 'has-error':''; ?>">
                            
                                <label for="supplier_id">Supplier:</label>
                            
                                <?php echo form_dropdown('data[supplier_id]', $suppliers,
                                                isset($_POST['data']['supplier_id'])? $_POST['data']['supplier_id']:$record->supplier_id
                                                , 'class="dropdown_lists form-control" id="supplier_id" data-placeholder="Choose Supplier"'); ?>
                            
                                <?php echo form_error('data[supplier_id]','<p class="error-msg">','</p>') ?>
                            
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

                            <?php if ($record->id && $record->file): ?>
                                
                                <div class="imageview-container">
                              
                                    <span class="delete" data-image-name="<?php echo $record->file; ?>">X</span>
                              
                                    <a href="<?php echo base_url('uploads/equipment_tags/'.$record->file) ?>" 
                                    download="<?php echo base_url('uploads/equipment_tags/'.$record->file) ?>">
                                        <?php echo $record->file; ?>
                                    </a>
                              
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
<script src="<?php echo base_url('assets/dist/js/fileupload.js'); ?>"></script>
<script>
    
    $(function () {

        $('.date').datetimepicker({
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

    });

</script>
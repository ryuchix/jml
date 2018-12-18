<?php $this->load->view( 'partials/header' ); ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css">

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
        <h1>Manage Bin Liner<small><?php echo $record->id? 'edit': 'new'; ?></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( $class_name ); ?>"><i class="fa fa-trash"></i> Bin Liner</a></li>
            <li><a href="<?php echo site_url( "$class_name/record_list" ); ?>"><i class="fa fa-trash"></i> Manage</a></li>
            <li class="active"><?php echo $record->id? 'Edit': 'New'; ?></li>
        </ol>
    </section>
    <br>

    <!-- Main content -->
    <section class="content">
        
        <div class="row">

            <!-- form start -->
            <form role="form" id="requestForm" method="post" action="<?php echo site_url( $class_name."/save/".$record->id ); ?>">
                <div class="col-sm-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?php echo $record->id? 'Edit': 'Add New'; echo ' '. ucfirst(str_replace('_', ' ', $class_name)); ?></h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            
                            <div class="form-group <?php echo form_error('date')? 'has-error':''; ?>">
                                <label for="date">Request date:</label>
                                <div class='input-group date' id='datetimepicker'>
                                    <input type="text" class="form-control" name="date" id="date" placeholder="Request Date" value="<?php echo set_value('date', $record->id? local_date($record->date): date('d/m/Y')); ?>">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                <?php echo form_error('date','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[property_id]')? 'has-error':''; ?>">
                                <label for="property_id">Choose Property:</label>
                                <?php echo form_dropdown('data[property_id]', $properties, 
                                                                            isset($_POST['data']['property_id'])? $_POST['data']['property_id']:$record->property_id
                                                                            , 'class="dropdown_lists form-control" id="property_id" data-placeholder="Choose Property"'); ?>
                                <?php echo form_error('data[property_id]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[staff]')? 'has-error':''; ?>">
                                <label for="staff">Choose Staff:</label>
                                <?php echo form_dropdown('data[staff]', $users, 
                                                                            isset($_POST['data']['staff'])? $_POST['data']['staff']:$record->staff
                                                                            , 'class="dropdown_lists form-control" id="staff" data-placeholder="Choose Staff"'); ?>
                                <?php echo form_error('data[staff]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group">
                                <label>Notes</label>
                                <textarea class="form-control" rows="3" name="data[notes]" placeholder="Notes..."><?php echo set_value('data[notes]', $record->notes); ?></textarea>
                            </div>

                            <div class="form-group <?php echo form_error('items[]')? 'has-error':''; ?>">
                                <label for="strata_plan">Choose Bin Liners</label>
                                <div class="table-responsive">
                                <table id="itemsContainer" class="table table-bordered table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>QTY</th>
                                            <th>Total Price</th>
                                        </tr>                                
                                    </thead>
                                    <tbody>
                                    <?php foreach ($bin_liners as $item): // x($liner_qty) // x($bin_liners); x($this->input->post("items")); ?>
                                        <tr>
                                            <td>
                                                <div class="checkbox"><label><?php echo $item->name; ?></label></div>
                                            </td>
                                            <td>
                                                <?php echo $item->price ?>
                                            </td>
                                            <td class=" <?php echo form_error("items[$item->id]")? 'has-error':''; ?>">
                                                <input type="text" name="items[<?php echo $item->id; ?>]" class="form-control qty"

                                                <?php if (isset($_POST['submit'])): ?>

                                                    value="<?php echo $this->input->post("items[$item->id]"); ?>"
                                                      
                                                <?php elseif(isset($liner_qty[$item->id])): ?>

                                                    value="<?php echo $liner_qty[$item->id]; ?>"
                                                    
                                                <?php else: ?>
                                                    
                                                    value="0"

                                                <?php endif ?>
                                                />
                                            </td>
                                            <td><?php echo isset($liner_total[$item->id])?$liner_total[$item->id]:'' ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                    </tbody>
                                </table>
                                    <div class="form-group <?php echo form_error("items[$item->id]")? 'has-error':''; ?>">
                                        <?php echo form_error("items[$item->id]",'<p class="error-msg">','</p>'); ?>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
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
            if( !$qty.size() )
            {
                ret = false;
                alert('There should be at least one setting.');
            }
            else if ( $qty.size() == 1 && !parseFloat( $($qty[0]).val() ) ) 
            {
                ret = false;
                alert('Quantity Value Must be greater than 0');
            }
            else{
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
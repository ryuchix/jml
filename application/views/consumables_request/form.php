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
        <h1>Consumable Request <small><?php echo $record->id? 'Edit':'New'; ?></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( $class_name ); ?>"><i class="fa fa-user"></i> Consumable Request</a></li>
            <li class="active"><?php echo $record->id? 'Edit':'New'; ?></li>
        </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content">
        
        <div class="row">

            <!-- form start -->
            <form role="form" id="requestForm" method="post" action="<?php echo site_url( $class_name.'/save/'.$record->id ); ?>">
                
                <div class="col-sm-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?php echo $record->id? 'Edit ':'New '; ?> Consumable Request</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <div class="form-group <?php echo form_error('data[property_id]')? 'has-error':''; ?>">
                                <label for="property_id">Choose Property:</label>
                                <?php echo form_dropdown('data[property_id]', $properties, 
                                                                            isset($_POST['data']['property_id'])? $_POST['data']['property_id']:$record->property_id
                                                                            , 'class="dropdown_lists form-control" id="property_id" data-placeholder="Choose Property"'); ?>
                                <?php echo form_error('data[property_id]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group">
                                <label for="client_name">Client name:</label>
                                <input type="text" readonly class="form-control" name="client_name" value="<?php echo set_value('client_name', $client->name); ?>" name="client_name" id="client_name" placeholder="Client name">
                            </div>

                            <div class="form-group">
                                <label for="property_address">Property Address:</label>
                                <input type="text" readonly class="form-control" name="property_address" value="<?php echo set_value('property_address', $property->address); ?>" name="property_address" id="property_address" placeholder="Property Address">
                            </div>
                            <?php if ($this->session->userdata('user_role')==ADMIN_ROLE): ?>
                                
                            <div class="form-group <?php echo form_error('data[request_by]')? 'has-error':''; ?>">
                                <label for="request_by">Request By:</label>
                                <?php echo form_dropdown('data[request_by]', $users, 
                                                                            isset($_POST['data']['request_by'])? $_POST['data']['request_by']:$record->request_by
                                                                            , 'class="dropdown_lists form-control" id="request_by" data-placeholder="Choose User"'); ?>
                                <?php echo form_error('data[request_by]','<p class="error-msg">','</p>') ?>
                            </div>
                            <?php else: ?>
                                <input type="hidden" name="data[request_by]" value="<?php echo set_value('data[request_by]', $this->session->userdata('user_id')); ?>">
                            <?php endif; ?>

                            <div class="form-group <?php echo form_error('request_date')? 'has-error':''; ?>">
                                <label for="request_date">Request date:</label>
                                <div class='input-group date' id='datetimepicker'>
                                    <input type="text" class="form-control" name="request_date" id="request_date" placeholder="Request Date" value="<?php echo set_value('request_date', $record->id? local_date($record->date): date('d/m/Y')); ?>">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                <?php echo form_error('request_date','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[status]')? 'has-error':''; ?>">
                                <label for="status">Status:</label>
                                <?php 
                                $status = [ STATUS_OPEN => 'Open', STATUS_CLOSED => 'Closed', STATUS_VOID => 'Void' ];
                                echo form_dropdown('data[status]', $status, 
                                                        isset($_POST['data']['status'])? $_POST['data']['status']:$record->status
                                                        , 'class="dropdown_lists form-control" id="status" data-placeholder="Choose Status"'); ?>
                                <?php echo form_error('data[status]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[po_no]')? 'has-error':''; ?>">
                                <label for="po_no">Purchase Order No.</label>
                                <input type="text" class="form-control" name="data[po_no]" value="<?php echo set_value('data[po_no]', $record->po_no); ?>" name="data[po_no]" id="po_no" placeholder="Purchase Order No">
                                <?php echo form_error('data[po_no]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('items[]')? 'has-error':''; ?>">
                                <label for="strata_plan">Choose Consumables</label>
                                <div class="table-responsive">
                                <table id="itemsContainer" class="table table-bordered table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Code</th>
                                            <th>Supplier</th>
                                            <th>QTY</th>
                                            <th>Unit/Box</th>
                                        </tr>                                
                                    </thead>
                                    <tbody>
                                    <?php foreach ($items as $item): ?>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" 
                                                            value="<?php echo $item->id; ?>" 
                                                            name="items[<?php echo $item->id; ?>][id]" 
                                                            <?php echo 
                                                            isset($_POST['submit'])? 
                                                                $item->id==$this->input->post("items[$item->id][id]")? 'checked': ''
                                                            : is_checked_item($item->id, $selected_items)? "checked":'';
                                                         ?>>
                                                         <span><?php echo $item->name; ?></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <?php echo $item->code ?>
                                            </td>
                                            <td>
                                                <?php echo $item->supplier ?>
                                            </td>
                                            <td>
                                                <input type="text" name="items[<?php echo $item->id; ?>][qty]" class="form-control"
                                                value="<?php echo 
                                                    isset($_POST['submit'])? 
                                                        $this->input->post("items[$item->id][qty]"):
                                                        get_checked_item_qty($item->id, 'qty', $selected_items); ?>">
                                            </td>
                                            <td>
                                                <select name="items[<?php echo $item->id; ?>][unit]" class="form-control">
                                                    <option value="unit"
                                                    <?php echo 
                                                            isset($_POST['submit'])? 
                                                                ($this->input->post("items[$item->id][unit]") == "unit")?"selected": ""
                                                                : get_checked_item_qty($item->id, 'unit', $selected_items)=='unit'? 'selected':''; ?>
                                                        >Unit</option>
                                                    <option value="box"
                                                    <?php echo 
                                                            isset($_POST['submit'])? 
                                                                ($this->input->post("items[$item->id][unit]") == "box")?"selected": ""
                                                                : get_checked_item_qty($item->id, 'unit', $selected_items)=='box'? 'selected':''; ?>
                                                        >Box</option>
                                                </select>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                    </tbody>
                                </table>
                                    <?php echo form_error('item[<?php echo $item->id; ?>]','<p class="error-msg">','</p>'); ?>
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary hidden-xs hidden-sm" name="submit">Submit</button>
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
<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
<script>
    
    $(function () {

        $('#datetimepicker').datetimepicker({
             format: 'DD/MM/YYYY'
        });

        /* Add Contact Form */
        $('#property_id').on('change', function(event) {
            event.preventDefault();
            
            $.ajax({
                 url: '<?php echo site_url( "consumable_request/get_consumable_items_service" ); ?>',
                 type: 'POST',
                 dataType: 'json',
                 data: { 'property_id' : $(this).val() },
            })
            .done(function(data) {
                var info = data[0];
                $('#client_name').val(info.client);
                $('#property_address').val(info.address);
                var items = '';
                jQuery.each(data, function(index, item) {
                    // console.log(item);
                items += '<tr>' +
                            '<td>' +
                                '<div class="checkbox">' +
                                    '<label>' +
                                        '<input type="checkbox" value="2" name="items['+item.id+'][id]">' +
                                         '<span>'+item.name+'</span>'+
                                    '</label>' +
                                '</div>' +
                            '</td>' +
                            '<td>' +
                                item.code +
                            '</td>' +
                            '<td>' +
                                item.supplier +
                            '</td>' +
                            '<td>' +
                                '<input type="text" name="items['+item.id+'][qty]" class="form-control">'+
                            '</td>' +
                            '<td>' +
                                '<select name="items['+item.id+'][unit]" class="form-control">' +
                                    '<option value="unit">Unit</option>' +
                                    '<option value="box">Box</option>' +
                                '</select>' +
                            '</td>' +
                        '</tr>';

                });
                $('#itemsContainer tbody').html(items);

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

        $('#requestForm').on('submit', function(event) {
            var $checkedItems = $('#itemsContainer tbody').find('input[type=checkbox]:checked'),
                ret = true;
            if( !$checkedItems.size() ){
                ret = false;
                alert('Please Select Consumable Item which need to Request.');
            }else{
                $.each($checkedItems, function(index, el) {
                    if ( !$.trim($(el).parents('tr').find('td:eq(3) input').val()) ){
                        ret = false;
                        alert("Make Sure you put QTY for "+$(el).next().text());
                    }
                });
            }
            if (!ret) {
                event.preventDefault();
            }
            
        });

    });

</script>
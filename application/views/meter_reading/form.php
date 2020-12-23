<?php $this->load->view( 'partials/header' ); ?>
<link rel="stylesheet" href="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css">
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
    #lineItemTable .select2-container--default .select2-selection--single {
        border: none;
    }

    #lineItemTable td {
        padding: 0;
    }

    #lineItemTable input.form-control {
        border: none;
    }
    #lineItemTable tr td:nth-child(4) .form-group{
        position: relative;
    }
    span.deleteRow {
        position: absolute;
        right: 5px;
        top: 2px;
        color: red;
        font-size: 1.5em;
        cursor: pointer;
        display: none;
    }

    td.selected {
        background: #77b0d0;
        color: white;
    }
    [name*=selected_date_of_month],
    [name*=selected_date_of_week]{
        display: none;
    }

</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Jobs <small><?php echo $record->id? 'edit': 'new'; ?></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( 'jobs' ); ?>"><i class="fa fa-user"></i> Job</a></li>
            <li class="active"><?php echo $record->id? 'Edit': 'New'; ?></li>
        </ol>
    </section>
    <br>

    <!-- Main content -->
    <section class="content">
        
        <div class="row">
            <!-- form start -->
            <form role="form" id="form" method="post" action="<?php echo site_url( $class_name."/save/".$record->id ); ?>" enctype="multipart/form-data">
                <div class="col-sm-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?php echo $record->id? 'Edit ': 'Add New '; 
                          echo $record->id? get_job_types($record->job_type?$record->job_type:1):'';
                          echo ' '. ucfirst(str_replace(['_','s'], ' ', $class_name)); echo  $record->id? " # ($record->id) ":''; ?></h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            
                            <div class="form-group <?php echo form_error('data[job_category]')? 'has-error':''; ?>">
                                <label for="job_category">Job Category:</label>
                                <?php echo form_dropdown('data[job_category]', $categoies, 
                                           isset($_POST['data']['job_category'])? $_POST['data']['job_category']:$record->job_category
                                           , 'class="dropdown_lists form-control" id="job_category" data-placeholder="Job Category"'); ?>
                                <?php echo form_error('data[job_category]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[job_title]')? 'has-error':''; ?>">
                                <label for="job_title">Job Title</label>
                                    <input type="text" class="form-control" name="data[job_title]" id="job_title" placeholder="Job Title" value="<?php echo set_value('data[job_title]', $record->job_title); ?>">
                                <?php echo form_error('data[job_title]','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[instruction]')? 'has-error':''; ?>">
                                <label for="instruction">Instructions</label>
                                <textarea class="form-control" name="data[instruction]" id="instruction" placeholder="Instructions..." rows="3"><?php echo set_value('data[instruction]', $record->instruction); ?></textarea>
                                <?php echo form_error('data[instruction]','<p class="error-msg">','</p>'); ?>
                            </div>
                            
                            <div class="form-group <?php echo form_error('data[client_id]')? 'has-error':''; ?>">
                                <label for="client_id">Choose Client:</label>
                                <input id="client_hidden_value" value="<?php echo set_value('data[client_id]', $record->client_id) ?>" type="hidden"/>
                                <?php 
                                $readonly = $record->id? "disabled":'';
                                echo form_dropdown('data[client_id]', $clients, 
                                                                            isset($_POST['data']['client_id'])? $_POST['data']['client_id']:$record->client_id
                                                                            , 'class="dropdown_lists form-control" id="client_id" 
                                                                            '. $readonly .' data-placeholder="Choose Client"'); ?>
                                <?php echo form_error('data[client_id]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[property_id]')? 'has-error':''; ?>">
                                <label for="property_id">Choose Property</label>
                                <input id="property_id_hidden" value="<?php echo set_value('data[property_id]', $record->property_id) ?>" type="hidden"/>
                                <?php echo form_dropdown('data[property_id]', $properties, 
                                            isset($_POST['data']['property_id'])? $_POST['data']['property_id']:$record->property_id
                                            , 'class="dropdown_lists form-control" id="property_id" 
                                                                            '. $readonly . ' data-placeholder="Choose Property"'); ?>
                                <?php echo form_error('data[property_id]','<p class="error-msg">','</p>') ?>
                            </div>
                            <div class="form-group <?php echo form_error('data[job_type]')? 'has-error':''; ?>">
                                <label for="job_type">Job Type:</label>
                                <?php 
                                if(((int)$record->job_type === 1))
                                {
                                    $dropdown = '';
                                    $readonly = 'disabled';
                                    echo '<input type="hidden" name="data[job_type]" value"' . (isset($_POST['data']['job_type'])? $_POST['data']['job_type']:(int) $record->job_type) . '">';
                                }else{
                                    $dropdown = 'dropdown_lists';
                                    $readonly = '';
                                }
                                
                                echo form_dropdown('data[job_type]', get_job_types(), 
                                                                            isset($_POST['data']['job_type'])? $_POST['data']['job_type']:(int) $record->job_type
                                                                            , 'class="' . $dropdown . ' form-control" '. $readonly .' id="job_type" data-placeholder="Job Type"'); ?>
                                <?php echo form_error('data[job_type]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group <?php echo form_error('start_date')? 'has-error':''; ?>">
                                <label for="start_date">Start Date</label>
                                <div class='input-group date' id='datetimepicker'>
                                    <input type="text" class="form-control" name="start_date" id="start_date" placeholder="Start Date" value="<?php echo set_value('start_date', $record->id? local_date($record->start_date):date('d/m/Y')); ?>">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                <?php echo form_error('start_date','<p class="error-msg">','</p>'); ?>
                            </div>
                            <?php // if (!$record->id && $record->job_type == 1): ?>
                            <div class="form-group <?php echo form_error('end_date')? 'has-error':''; ?>">
                                <label for="end_date">End Date</label>
                                <div class='input-group date' id='datetimepicker'>
                                    <input type="text" class="form-control" name="end_date" id="end_date" placeholder="End Date" value="<?php echo set_value('end_date', $record->id? local_date($record->end_date):''); ?>">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                <?php echo form_error('end_date','<p class="error-msg">','</p>'); ?>
                            </div>
                            <?php // endif ?>
                            <?php // if (!$record->id) { ?>

                            <div class="form-group <?php echo form_error('data[duration]')? 'has-error':''; ?>">
                                <label for="duration">Duration</label>
                                <div class="" id="input-group-toggle">
                                    <input type="text" class="form-control" name="data[duration]" id="duration" placeholder="Duration" value="<?php echo set_value('data[duration]', $record->duration); ?>">
                                    <div class="input-group-btn" style="display: none;">
                                        <input type="hidden" name="data[duration_schedule]" 
                                        value="<?php echo set_value('data[duration_schedule]', $record->duration_schedule); ?>" id="duration_recurring">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo set_value('data[duration_schedule]', $record->duration_schedule); ?> <span class="caret"></span></button>
                                        <ul class="dropdown-menu" id="recurringOptions">
                                            <li><a href="#">Days</a></li>
                                            <li><a href="#">Months</a></li>
                                            <li><a href="#">Weeks</a></li>
                                            <li><a href="#">Years</a></li>
                                        </ul>
                                    </div><!-- /btn-group -->
                                </div>
                                <?php echo form_error('data[duration]','<p class="error-msg">','</p>'); ?>
                            </div>
                            <div class="form-group <?php echo form_error('data[visit_frequency]')? 'has-error':''; ?>">
                                <label for="visit_frequency">Visit Frequency:</label>
                                <?php 
                                $day = date('l');
                                $engDay = date('jS');
                                $freq = [
                                    "Weekly on $day"=>"Weekly on $day", 
                                    "Every two weeks on $day"=>"Every two weeks on $day",
                                    "Monthly on the $engDay day of the month"=>"Monthly on the $engDay day of the month",
                                    'custom'=>'Custom Schedule'
                                ];
                                echo form_dropdown('data[visit_frequency]', $freq, 
                                        isset($_POST['data']['visit_frequency'])? $_POST['data']['visit_frequency']: $record->visit_frequency
                                        , 'class="form-control" id="visit_frequency" data-placeholder="Job Category"'); ?>
                                <?php echo form_error('data[visit_frequency]','<p class="error-msg">','</p>') ?>
                            </div>
                            <?php // } ?>
                            <div class="form-group <?php echo form_error('data[start_time]')? 'has-error':''; ?>">
                                <label for="start_time">Start Time</label>
                                <input type="text" class="form-control" name="data[start_time]" id="start_time" placeholder="Start Time" value="<?php echo set_value('data[start_time]', $record->start_time); ?>">
                                <?php echo form_error('data[start_time]','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[end_time]')? 'has-error':''; ?>">
                                <label for="end_time">End Time</label>
                                <input type="text" class="form-control" name="data[end_time]" id="end_time" placeholder="End Time" value="<?php echo set_value('data[end_time]', $record->end_time); ?>">
                                <?php echo form_error('data[end_time]','<p class="error-msg">','</p>'); ?>
                            </div>

                            <div class="form-group <?php echo form_error('data[internal_notes]')? 'has-error':''; ?>">
                                <label for="internal_notes">Internal Notes</label>
                                <textarea class="form-control" name="data[internal_notes]" id="internal_notes" placeholder="Internal Notes..." rows="3"><?php echo set_value('data[internal_notes]', $record->internal_notes); ?></textarea>
                                <?php echo form_error('data[internal_notes]','<p class="error-msg">','</p>'); ?>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">Crew</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <input type="hidden" name="shouldRegenerateUsers" id="shouldRegenerateUsers" value="false">
                            <div class="form-group <?php echo form_error('users[]')? 'has-error':''; ?>">
                                <label for="strata_plan">Crew Members</label>
                                <?php 
                                // x($crew_users);
                                foreach ($users as $id => $name): ?>
                                    <div class="checkbox">
                                        <label>
                                            <input class="crews-checkbox" type="checkbox" value="<?php echo $id; ?>" name="users[<?php echo $id; ?>]" 
                                                <?php echo $this->input->post("users[$id]") == $id? 'checked':
                                                in_array($id, $crew_users)? "checked":'';
                                                 ?>>
                                             <?php echo $name; ?>
                                        </label>
                                    </div>
                                <?php endforeach ?>
                                <?php echo form_error('users[]','<p class="error-msg">','</p>') ?>
                            </div>

                        </div>
                    </div>
                </div>
            
                <?php // if (!$record->id) { 
                        $this->load->view('jobs/custom_schedule_form');    
                    //} ?>

                <div class="col-sm-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">Line Items</h3>
                          <div class="btn-group btn-group-sm pull-right">
                              <?php echo anchor('#', '<i class="fa fa-plus"></i>', 'class="btn btn-sm btn-info" id="addItem"'); ?>
                              <?php echo anchor('#', '<i class="fa fa-trash"></i>', 'class="btn btn-sm btn-danger" id="deleteItem"'); ?>
                          </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="preloader-container">
                                <div class="preloader">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </div>
                            <table class="table table-bordered" id="lineItemTable">
                                <thead>
                                    <tr>
                                        <th>Service/Description</th>
                                        <th>Qty</th>
                                        <th>Unit Cost</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $this->load->view('jobs/form_partial_line_item'); ?>
                                </tbody>

                            </table>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <?php if ($record->id): ?>
                                
                            <div class="alert alert-warning" style="display: none;" id="warning">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <strong>Warning! </strong> Editing this schedule will clear all incomplete visits from this job and new visits will be created using the updated information.
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="checkbox btn btn-default">
                                            <label>
                                                <input type="checkbox" value="yes" id="confirmation" name="regenerate_visits">
                                                I Understand
                                            </label>
                                        </div>
                                    </div><!-- /.col-lg-6 -->
                                </div>
                            </div>

                            <?php endif ?>

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


<?php if( $record->id ): ?>
<script>

function arraysEqual(a, b) {
    a.sort();
    b.sort();
  if (a === b) return true;
  if (a == null || b == null) return false;
  if (a.length != b.length) return false;
  for (var i = 0; i < a.length; ++i) {
    if (a[i] !== b[i]) return false;
  }
  return true;
}

$(function(){
    var existingUsers = [ <?php echo join(', ', $crew_users); ?> ];
    var selectedUsers = [];
    $('.crews-checkbox').on('change', function(){    
        var selectedUsers = [];
        $('.crews-checkbox:checked').each(function(){
            selectedUsers.push(parseInt($(this).val()));
        });

        if(!arraysEqual(existingUsers, selectedUsers))
        {
            showWarning(true);
        }else{
            showWarning(false);        
        }

    });
});

</script>
<?php endif; ?>

<script>

$('.date').datetimepicker({
    format: 'DD/MM/YYYY'
})/* .on('dp.change', function(e){
    
}) */;

$('#form').on('submit', function() {
    $('.dropdown_lists').prop('disabled', false);
});
    
$(".dropdown_lists").select2({
    placeholder: $(this).data('placeholder'),
    allowClear: true
});

$('#client_id').on('change', function(event) {
    event.preventDefault();
    var client_id = $(this).val();
    $('#client_hidden_value').val(client_id);
    $.ajax({
        url: '<?php echo site_url( 'client/get_properties_service/' ); ?>',
        type: 'POST',
        dataType: 'json',
        data: {'client_id': client_id },
    })
    .done(function(data) {
        if(Object.keys(data).length>1){
            var options = '';
            for (var property in data) {
                if (data.hasOwnProperty(property)) {
                    options += '<option value="'+property+'">'+data[property]+'</option>';
                }
            }
            $('#property_id').html($(options))
                .val( $('#property_id_hidden').val() );
        }

    });
});

if ( $('#client_id').val() ) {
    $('#client_id').trigger('change');
}

var lineItemList = 
{
    service_id: $('.serviceDD'),
    lineItemTable: $('#lineItemTable tbody'),

    init: function() {
        var that = this;
        this.lineItemTable.on('change', '.serviceDD', function(event) {
            event.preventDefault();
            var $row = $(this).parents('tr');
            that.service_id = $(this);
            that.getData(that.service_id.val(), $row);
            that.calculateTotal($row);
            $(this).parents('.box-body').find('.preloader-container').show();
        });

        this.lineItemTable.on('keyup change', '.itemQty, .itemCost', function(event) {
            
            event.preventDefault();

            that.calculateTotal($(this).parents('tr'));

        });
    },
    getData: function (service_id, $row) {
        var that = this;
        $.ajax({
            url: '<?php echo site_url( 'services/get_service_by_id' ); ?>',
            type: 'POST',
            dataType: 'json',
            data: {'service_id': service_id},
        })
        .done(function(data) {
            if (data.status) {
                that.populateData(data.service);
                that.calculateTotal($row);
            }else{
                console.log("Something went wrong.!");
            }
        });
    },
    populateData: function (data) {
        var $row = this.service_id.parents('tr');
        $row.find('td:first-child textarea').val(data.description);
        $row.find('td:eq(2) input').val(data.rate);
        $row.parents('.box-body').find('.preloader-container').hide();
    },
    calculateTotal: function (row) {
        var qty = $(row).find('.itemQty').val(),
            cost = $(row).find('.itemCost').val(),
            total = $(row).find('td:last-child input');
        if (parseFloat(qty) && parseFloat(cost)) {
            total.val('$'+(qty*cost));
        }else{
            total.val(0);
        }
        
        <?php if($record->id): ?>
        showWarning(true);
        <?php endif;?>
    }
};

lineItemList.init();

$('#recurringOptions a').on('click', function(event) {
    event.preventDefault();
    var $this = $(this),
        text = $this.text();
    $this.parents('ul').prev().html( text +" <span class=\"caret\"></span>");
    $('#duration_recurring').val(text);

    <?php if($record->id): ?>
    var currentRecurringOption = '<?php echo $record->duration_schedule ?>';
    if(text != currentRecurringOption)
        showWarning(true);
    else 
        showWarning(false);
    <?php endif; ?>
});

$('#job_type').on('change', function(event) {
    event.preventDefault();
    if ($(this).val() == '2'){
        $('#duration').parents('.form-group').show();
        $('.input-group-btn').show();
        $('#input-group-toggle').addClass('input-group');
        $('#end_date').val('').parents('.form-group').hide();
        $('#visit_frequency').parents('.form-group').show();
    }
    else{
        $('#duration').parents('.form-group').hide();
        $('.input-group-btn').hide();
        $('#input-group-toggle').removeClass('input-group');
        $('#end_date').parents('.form-group').show();
        $('#visit_frequency').parents('.form-group').hide();
    }
}).trigger('change');

var rowNumber = <?php $this->input->post('line_items[]')? (count($this->input->post('line_items[]'))-1) : 0; ?> 0;
$('#addItem').on('click', function(event) {
    event.preventDefault();
    rowNumber = parseInt($('#lineItemTable tbody tr:last td:first select').attr('name').match(/\d+/).shift()) + 1;
    var row = '<tr>'+
        '<td>' +
            '<div class="form-group ">'+
                '<select name="line_items['+rowNumber+'][service_id]" class="dropdown_lists serviceDD form-control" data-placeholder="Choose Service"> id="serviceSelect-'+rowNumber+'"'+
                    <?php foreach ($services as $key => $value) { ?>
                        '<option value="<?php echo $key ?>"><?php echo $value ?></option>'+
                    <?php } ?>
                '</select>'+
                '<textarea class="form-control" rows="2" name="line_items['+rowNumber+'][description]" placeholder="Description..."></textarea>'+
            '</div>'+
        '</td>'+
        '<td>'+
            '<div class="form-group ">'+
                '<input type="text" class="form-control itemQty" name="line_items['+rowNumber+'][qty]" placeholder="Quantity">'+
            '</div>'+
        '</td>'+
        '<td>'+
            '<div class="form-group ">'+
                '<input type="text" class="form-control itemCost" name="line_items['+rowNumber+'][unit_cost]" placeholder="Unit Cost">'+
            '</div>'+
        '</td>'+
        '<td>'+
            '<div class="form-group delRow">'+
                '<input type="text" class="form-control" name="line_items['+rowNumber+'][total]" placeholder="Total">'+
                '<span class="deleteRow"><i class="fa fa-trash"></i></span>'+
            '</div>'+
        '</td>'+
        '</tr>';
    $('#lineItemTable tbody').append($(row));
    $('#lineItemTable').find('.deleteRow').fadeOut('fast');
    var x = "#serviceSelect"+rowNumber;
    $(".dropdown_lists").select2({
        placeholder: $(this).data('placeholder'),
        allowClear: true
    });

    <?php if($record->id): ?>
    showWarning(true);
    <?php endif;?>
});

var deleteShowing = false;
$('#deleteItem').on('click', function(event) {
    event.preventDefault();
    if ($('#lineItemTable tbody').find('tr').length == 1) { return }
    $('#lineItemTable').find('.deleteRow').fadeToggle('fast');
});

$('#lineItemTable').on('click', '.deleteRow', function(event) {
    event.preventDefault();
    $(this).parents('tr').fadeOut('slow', function() {
        $(this).remove();
        $('#lineItemTable').find('.deleteRow').fadeOut('fast');
        <?php if($record->id): ?>
        showWarning(true);
        <?php endif;?>
    });
});

/************** Visit Frecquency **************/

$('#visit_frequency').on('change', function(event) {
    if ($(this).val() == 'custom') {
        $('#custom_schedule_container').slideDown()
        .addClass('animated tada');
    }else{
        $('#custom_schedule_container').slideUp();
    }
}).trigger('change');
// .val('custom').trigger('change');

$('#frequency').on('change', function(event) {
    event.preventDefault();

    <?php if($record->id): ?>
    var currentFrequency = '<?php echo $record->frequency; ?>';

    if (currentFrequency !== $(this).val())
    {
        showWarning(true);
    }else{
        showWarning(false);
    }

    <?php endif; ?>
    switch($(this).val()){
        case 'Daily':
            $('.carousel-indicators li:eq(0)').trigger('click');
            // $('.Daily').find('input').prop('disabled', false)
                    // .siblings().find('input').prop('disabled', true);
        break;
        case 'Weekly':
            $('.carousel-indicators li:eq(1)').trigger('click');
            // $('.Weekly').find('input').prop('disabled', false)
                    // .siblings().find('input').prop('disabled', true);
        break;
        case 'Monthly':
            $('.carousel-indicators li:eq(2)').trigger('click');
            // $('.Monthly').find('input').prop('disabled', false)
                    // .siblings().find('input').prop('disabled', true);
        break;
        case 'Yearly':
            $('.carousel-indicators li:eq(3)').trigger('click');
            // $('.Yearly').find('input').prop('disabled', false)
                    // .siblings().find('input').prop('disabled', true);
        break;
    }
}).trigger('change');
var dirty = false;
$('#dayOfMonth td').not(".not").click(function() {
    var $this = $(this);
    $this.toggleClass('selected');
    dirty = <?php echo $record->id? 'true':'false'; ?>;
    checkWarning();
    var t = new Array();
    $this.find('input[type=checkbox]').prop('checked', $this.hasClass('selected'));
    $this.parents('table').find('td.selected').each(function(index, el) {
        t.push($(this).text()+"th");
    });
    var last_element = (t.length>1)? ' and '+t.pop():'';
    $this.parents('table').next('p').html('<strong>Summary: </strong>Monthly on the '+t.join(', ')+last_element);
});

$('.nav-tabs li a').click(function(event) {
    if ($(this).attr('aria-controls')=='day_of_week') {
        $('#day_or_week_of_month').val('Day of Week');
    }else{
        $('#day_or_week_of_month').val('Day of Month');
    }
});
var $start_date = $('#start_date'),
    dateArray = $start_date.val().split('/'),
    start_date_value = new Date(dateArray[2],dateArray[1],dateArray[0]);

$('.date').on('dp.change', function(event) {
    // event.preventDefault();
    checkWarning(event);
});

function checkWarning(e) 
{
    if(e)
    {
        <?php if($record->id): ?>
        var sd = '<?php echo $record->start_date; ?>';
        if(sd !== e.date.format('YYYY-MM-DD'))
        {
            showWarning(true);
        }else{
            showWarning(false);
        }
        <?php endif; ?>
    }
    else{
        var dateArray = $start_date.val().split('/'),
        selected_date_value = new Date(dateArray[2],dateArray[1],dateArray[0]);

        if ( (selected_date_value < start_date_value) || dirty) {
            $('#warning').slideDown('slow');
            $('button[type=submit]').prop('disabled', true);
            $('#confirmation').prop('disabled', false);
        }else{
            $('#warning').slideUp('slow');
            $('button[type=submit]').prop('disabled', false);
            $('#confirmation').prop('disabled', true);
        }
    }

}

$('#duration').on('change', function(){
    <?php if($record->id): ?>
    var duration = <?php echo $record->duration ?>;
    if(duration != $(this).val())
        showWarning(true);
    else
        showWarning(false);
    <?php endif; ?>
});

$('#duration').on('change', function(){
    <?php if($record->id): ?>
    var duration = <?php echo $record->duration ?>;
    if(duration != $(this).val())
        showWarning(true);
    else
        showWarning(false);
    <?php endif; ?>
});

function showWarning(boolean){
    $('#warning')[boolean? 'slideDown': 'slideUp']('slow');
    $('button[type=submit]').prop('disabled', boolean);
    $('#confirmation').prop('disabled', !boolean);
}

$('#confirmation').on('change', function() {
    if ($(this).is(':checked')) {
        $('button[type=submit]').prop('disabled', false);
    }else{
        $('button[type=submit]').prop('disabled', true);
    }
});

</script>
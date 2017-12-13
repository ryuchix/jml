
$('.date').datetimepicker({
     format: 'DD/MM/YYYY'
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
    }
};

lineItemList.init();

$('#recurringOptions a').on('click', function(event) {
    event.preventDefault();
    var $this = $(this),
        text = $this.text();
    $this.parents('ul').prev().html( text +" <span class=\"caret\"></span>");
    $('#duration_recurring').val(text);
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
    rowNumber++;
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
});

var deleteShowing = false;
$('#deleteItem').on('click', function(event) {
    event.preventDefault();
    if ($('#lineItemTable tbody').find('tr').length == 1) { return }
    console.log('clicked');
    $('#lineItemTable').find('.deleteRow').fadeToggle('fast');
});

$('#lineItemTable').on('click', '.deleteRow', function(event) {
    event.preventDefault();
    $(this).parents('tr').fadeOut('slow', function() {
        $(this).remove();
        $('#lineItemTable').find('.deleteRow').fadeOut('fast');
    });
});

$('a .badge').on('click', function(event) {
    $that = $(this);
    event.preventDefault();
    if (confirm('do you want do delete attachment?')) {
        var url = '<?php echo site_url( "jobs/delete_attachment" ); ?>';
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {'file_id': $(this).data('file_id')},
        })
        .done(function(data) {
            console.log(data);
            if (data.status) {
                $that.parents('.list-group-item').fadeOut('slow', function() {
                    $(this).remove();
                });
            }
        });
        
    }
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
});

$('#dayOfMonth td').not(".not").click(function() {
    var $this = $(this);
    $this.toggleClass('selected');
    var t = new Array();
    $this.find('input[type=checkbox]').prop('checked', $this.has('selected'));
    console.log( $this.find('input[type=checkbox]').attr('name') );
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
    start_date_value = $start_date.val();
$('.date').on('dp.change', function(event) {
    // event.preventDefault();
    if ( $start_date.val() != start_date_value ) {
        $('#warning').slideDown('slow');
        $('button[type=submit]').prop('disabled', true);
        $('#confirmation').prop('disabled', false);
    }else{
        $('#warning').slideUp('slow');
        $('button[type=submit]').prop('disabled', false);
        $('#confirmation').prop('disabled', true);
    }
});

$('#confirmation').on('change', function() {
    if ($(this).is(':checked')) {
        $('button[type=submit]').prop('disabled', false);
    }else{
        $('button[type=submit]').prop('disabled', true);
    }
});

console.log($('#confirmations'));
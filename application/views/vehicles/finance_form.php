<?php $this->load->view( 'partials/header' ); ?>

<link rel="stylesheet" href="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css">

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
    tr.current-row{
        background-color: blue;
    }
    table.table>tbody>tr>td {
        padding: 2px;
    }
</style>

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">

        <h1>Vehicle Finance <small><?php echo $record->id? 'edit': 'new'; ?></small></h1>

        <ol class="breadcrumb">

            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>

            <li><a href="<?php echo site_url( 'vehicle/' ); ?>"><i class="fa fa-car"></i> Vehicle</a></li>

            <li class="active"><i class="fa fa-money"></i> Finance</li>

        </ol>

    </section>
    <br>

    <!-- Main content -->
    <section class="content">
        
        <div class="row">

            <!-- form start -->
            <form role="form" method="post" action="<?php echo site_url( "vehicle/finance/$record->id" ); ?>">

                <div class="col-sm-8">

                    <div class="box box-primary">

                        <div class="box-header with-border">

                          <h3 class="box-title">Finance (<?php echo $record->license_plate ?>)</h3>

                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">

                            <div class="form-group <?php echo form_error('data[finance_status]')? 'has-error':''; ?>">
                            
                                <label for="status">Status</label>
                            
                                <?php $status = array( '' => 'Choose...', STATUS_LOAN => 'Loan', STATUS_PAID => 'Paid' );
                                    echo form_dropdown('data[finance_status]', 
                                        $status, $this->input->post('data[finance_status]')?$this->input->post('data[finance_status]'): $record->finance_status, ' id="status" class="form-control" data-placeholder="Choose..."');
                                ?>
                            
                                <?php echo form_error('data[finance_status]','<p class="error-msg">','</p>'); ?>
                            
                            </div>
                            
                            <div class="form-group <?php echo form_error('data[finance_company]')? 'has-error':''; ?>">
                            
                                <label for="finance_company">Company</label>
                            
                                <input type="text" class="form-control" name="data[finance_company]" id="finance_company" placeholder="Company" value="<?php echo set_value('data[finance_company]', $record->finance_company); ?>">
                            
                                <?php echo form_error('data[finance_company]','<p class="error-msg">','</p>') ?>
                            
                            </div>
                            
                            <div class="form-group <?php echo form_error('data[finance_amount]')? 'has-error':''; ?>">
                            
                                <label for="finance_amount">Amount</label>
                            
                                <input type="text" class="form-control" name="data[finance_amount]" id="finance_amount" placeholder="Amount" value="<?php echo set_value('data[finance_amount]', $record->finance_amount); ?>">
                            
                                <?php echo form_error('data[finance_amount]','<p class="error-msg">','</p>') ?>
                            
                            </div>
                            
                            <div class="form-group <?php echo form_error('data[finance_monthly_payment]')? 'has-error':''; ?>">
                            
                                <label for="finance_monthly_payment">Monthly Payment</label>
                            
                                <input type="text" class="form-control" name="data[finance_monthly_payment]" id="finance_monthly_payment" placeholder="Monthly Payment" value="<?php echo set_value('data[finance_monthly_payment]', $record->finance_monthly_payment); ?>">
                            
                                <?php echo form_error('data[finance_monthly_payment]','<p class="error-msg">','</p>') ?>
                            
                            </div>
                            
                            <div class="form-group">
                            
                                <label for="finance_term">Terms</label>
                            
                                <input type="text" class="form-control" name="data[finance_term]" id="finance_term" placeholder="Terms" value="<?php echo set_value('data[finance_term]', $record->finance_term); ?>">
                            
                            </div>

                            <div class="form-group">
                            
                                <label for="finance_start_date">Start Date</label>
                            
                                <div class='input-group date' id='datetimepicker'>
                            
                                    <input type="text" class="form-control" name="finance_start_date" id="finance_start_date" placeholder="Start Date" value="<?php echo set_value('finance_start_date', $record->id? local_date($record->finance_start_date):''); ?>">
                            
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            
                                </div>
                            
                            </div>
                            
                            <div class="form-group">
                                
                                <label for="finance_balloon">Balloon</label>
                                
                                <input type="text" class="form-control" name="data[finance_balloon]" id="finance_balloon" placeholder="Balloon" value="<?php echo set_value('data[finance_balloon]', $record->finance_balloon); ?>">
                            
                            </div>

                            <?php $this->load->view('vehicles/links_form'); ?>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">

                            <button type="submit" class="btn btn-primary" name="submit">Save</button>

                        </div>

                    </div>

                </div>

            </form>

        </div>
        <!-- /.row -->

    </section>

</div>

<?php $this->load->view( 'partials/footer' ); ?>

<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>

<script src="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>

<script src="<?php echo base_url(); ?>assets/dist/js/fileupload.js"></script>

<script>
    
$(function () {

    $('.date').datetimepicker({

         format: 'DD/MM/YYYY'

    });

    var linkTable = {

        table: undefined,

        addRowBtn: undefined,

        deleteRowBtn: undefined,

        currentRowClass: 'bg-primary',

        rowCounter: 0,

        init: function (table, addRow, deleteRow) {

            this.table = $(table);

            this.addRowBtn = $(addRow);

            this.deleteRowBtn = $(deleteRow);

            this.table.on('click', 'tr, input', this.setCurrentRow);

            this.addRowBtn.on('click', this.addRow);

            if( !linkTable.table.find('tbody tr').size() ){
                this.addRowBtn.trigger('click');
            }

            this.deleteRowBtn.on('click', this.deleteRow);
        },

        setCurrentRow: function () 
        {
            $(this)
                .parents('tr')
                    .addClass(linkTable.currentRowClass)
                        .siblings().removeClass(linkTable.currentRowClass);
        },

        addRow: function () 
        {
            $.ajax({
                url: "<?php echo site_url('vehicle_links/draft'); ?>",
                type: 'POST',
                success: function(link_id) {

                    linkTable.rowCounter++;
            
                    var row = '<tr style="display:none;">'+
                        '<td>'+
                            '<input type="hidden" name="links['+ linkTable.rowCounter +'][pk]" value="' + link_id + '">'+
                            '<input type="text" class="form-control" name="links['+ linkTable.rowCounter +'][name]" placeholder="Name">'+
                        '</td>'+
                        '<td>'+
                            '<input type="text" class="form-control" name="links['+ linkTable.rowCounter +'][url]" placeholder="URL">'+
                        '</td><td></td>'+
                    '</tr>';

                    linkTable.table.find('tbody').append($(row).fadeIn());
                }
            });

        },

        deleteRow: function () {
            
            $tableBody = linkTable.table.find('tbody');

            if($tableBody.find('tr').size() <= 1){

                alert('atleast one link must be there!');

                return;
            }

            var selectedRow = $tableBody.find('.' + linkTable.currentRowClass)

            if (!selectedRow.size()) {

                alert('Please Select row to delete');

                return;
            }

            if (!confirm('Do you want to delete selected row?')) {

                return;
            }

            $.ajax({
                url: "<?php echo site_url('vehicle_links/delete'); ?>",
                type: 'POST',
                data: {pk: selectedRow.find('input[type="hidden"]').val()},
            })
            .done(function(data) {
                
                console.log(data);

                selectedRow.fadeOut(function(){

                    $(this).remove();

                });

            });
            


        }

    };

    linkTable.init('table', '#addRow', '#deleteRow');

});

</script>
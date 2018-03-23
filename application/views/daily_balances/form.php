<?php $this->load->view( 'partials/header' ); ?>

<link rel="stylesheet" href="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css">

<div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
        
        <h1>Daily Balances<small><?php echo $record->id? 'edit': 'new'; ?></small></h1>
        
        <ol class="breadcrumb">
        
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        
            <li><a href="<?php echo site_url( 'daily_balances' ); ?>"><i class="fa fa-balance-scale"></i> Daily Balances</a></li>
        
            <li class="active"><?php echo $record->id? 'Edit': 'New'; ?></li>
        
        </ol>
    
    </section>
    
    <br>

    <!-- Main content -->
    <section class="content">
        
        <div class="row">

            <!-- form start -->
            <form role="form" method="post" action="<?php echo site_url( "daily_balances/save/".$record->id ); ?>">

                <div class="col-sm-8 col-sm-offset-2">

                    <div class="box box-primary">

                        <div class="box-header with-border">

                          <h3 class="box-title"><?php echo $record->id? 'Edit': 'Add New'; ?> Daily Balances</h3>

                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">

                            <div class="form-group <?php echo form_error('data[date]')? 'has-error':''; ?>">

                                <label for="date">Date</label>

                                <div class='input-group date' id='datetimepicker'>

                                    <input type="text" class="form-control" name="data[date]" id="date" placeholder="Date" value="<?php echo set_value('data[date]', $record->id? local_date($record->date):date('d/m/Y')); ?>">

                                    <span class="input-group-addon">

                                        <span class="glyphicon glyphicon-calendar"></span>

                                    </span>

                                </div>

                                <?php echo form_error('data[balance]','<p class="error-msg">','</p>'); ?>

                            </div>
                            
                            <div class="form-group <?php echo form_error('data[balance]')? 'has-error':''; ?>">
                                <label for="balance">Balance</label>
                                <input type="text" class="form-control" name="data[balance]" id="balance" placeholder="Balance" value="<?php echo set_value('data[balance]', $record->balance); ?>">
                                <?php echo form_error('data[balance]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group">
                                <label>Notes</label>
                                <textarea class="form-control" rows="3" name="data[notes]" placeholder="Notes..."><?php echo set_value('data[notes]', $record->notes); ?></textarea>
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

<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>

<script src="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>

<script>

$(function(){

    $('#datetimepicker').datetimepicker({

         format: 'DD/MM/YYYY'

    });

});

</script>
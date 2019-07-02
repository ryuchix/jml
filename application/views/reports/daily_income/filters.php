<?php $this->load->view( 'partials/header' ); ?>
<link rel="stylesheet" href="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css">

<style>
@media (min-width: 992px){
    .modal-lg {
        width: 1280px;
    }
}
</style>

<div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
    
        <h1>Daily Income Report</h1>
    
        <ol class="breadcrumb">
    
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    
            <li><a href="<?php echo site_url( 'reports/' ); ?>"><i class="fa fa-user"></i> Reports</a></li>
    
            <li><a href="<?php echo site_url( 'reports/daily-income/filters' ); ?>"><i class="fa fa-user"></i> Daily Income Report</a></li>
    
        </ol>
    
    </section>

    <br>
    <!-- Main content -->
    <section class="content">
        
        <div class="row">

            <!-- form start -->
            <form role="form" id="filterForm" action="" autocomplete="off">

                <div class="col-sm-6 col-sm-offset-3">

                    <div class="box box-primary">
                        
                        <div class="box-header with-border">
                        
                            <h3 class="box-title">Criteria</h3>
                        
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">

                            <div class="row">
                                
                                <div class="col-sm-12">
                                    
                                    <div class="form-group">

                                        <label for="date">Date:</label>
                                        <div class='input-group date' id='date'>
                                            <input required type="text" class="form-control" name="date" id="date" placeholder="Date From" value="<?php echo set_value('date', ''); ?>">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                        <?php echo form_error('date','<p class="error-msg">','</p>') ?>

                                    </div>

                                </div>

                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">

                            <button type="submit" class="btn btn-primary">Submit</button>

                        </div>

                    </div>

                </div>

            </form>

        </div>
        <!-- /.row -->

    </section>

</div>


<!-- <a class="btn btn-primary" data-toggle="modal" href='#binlinerReport'>Trigger modal</a> -->
<div class="modal fade" id="dailyIncomeReport">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Daily Income Report</h4>
            </div>
            <div class="modal-body">
                
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

                <iframe id="reportIframe" src="" frameborder="0" style="width: 100%; min-height: 550px;"></iframe>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view( 'partials/footer' ); ?>

<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
<script>
    
    $(function () {

        $('.date').datetimepicker({
             format: 'DD/MM/YYYY'
        });

        $('#filterForm').on('submit', function (e) {
            e.preventDefault();
            
            $('.preloader-container').show();
            $('#dailyIncomeReport').modal({});
            var param = $(this).serialize().toString();
            var url = '<?php echo site_url('reports/daily-income'); ?>';
            $('#reportIframe').attr('src', url + '?' + param)
            .load(function() {
                $('.preloader-container').hide();
            });
        })

    });

</script>
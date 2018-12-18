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
    
        <h1>Bin Liners Management Report</h1>
    
        <ol class="breadcrumb">
    
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    
            <li><a href="<?php echo site_url( 'reports/' ); ?>"><i class="fa fa-user"></i> Reports</a></li>
    
            <li><a href="<?php echo site_url( 'reports/bin-liner-management' ); ?>"><i class="fa fa-user"></i> Bin Liner Management Report</a></li>
    
        </ol>
    
    </section>

    <br>
    <!-- Main content -->
    <section class="content">
        
        <div class="row">

            <!-- form start -->
            <form role="form" id="filterForm" action="" autocomplete="off">

                <div class="col-sm-12">

                    <div class="box box-primary">
                        
                        <div class="box-header with-border">
                        
                            <h3 class="box-title">Criteria</h3>
                        
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">

                            <div class="row">
                                
                                <div class="col-sm-6">
                                    
                                    <div class="form-group">

                                        <label for="date_from">Date From:</label>
                                        <div class='input-group date' id='date_from'>
                                            <input type="text" class="form-control" name="date_from" id="date_from" placeholder="Date From" value="<?php echo set_value('date_from', ''); ?>">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                        <?php echo form_error('date_from','<p class="error-msg">','</p>') ?>

                                    </div>

                                    <div class="form-group">

                                        <label for="id_label_single">Property:</label>

                                        <?php echo form_dropdown('property', $properties, isset($_GET['property'])?$_GET['property']: 'All', 'class="property form-control" id="id_label_single"'); ?>

                                        <?php echo form_error('property','<p class="error-msg">','</p>') ?>

                                    </div>


                                </div>

                                <div class="col-sm-6">
                                    
                                    <div class="form-group">

                                        <label for="date_to">Date To:</label>
                                        <div class='input-group date' id='date_to'>
                                            <input type="text" class="form-control" name="date_to" id="date_to" placeholder="Date From" value="<?php echo set_value('date_to', ''); ?>">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>

                                        <?php echo form_error('date_to','<p class="error-msg">','</p>') ?>

                                    </div>

                                    <div class="form-group <?php echo form_error('size')? 'has-error':''; ?>">

                                        <label for="id_label_single">Size:</label>

                                        <?php echo form_dropdown('size', $sizes, isset($_GET['size'])?$_GET['size']: 'All', 'class="is_parent_choose form-control" id="id_label_single"'); ?>

                                        <?php echo form_error('size','<p class="error-msg">','</p>') ?>

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
<div class="modal fade" id="binlinerReport">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Bin liners Report</h4>
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
            $('#binlinerReport').modal({});
            var param = $(this).serialize().toString();
            var url = '<?php echo site_url('reports/bin-liner-management'); ?>';
            $('#reportIframe').attr('src', url + '?' + param).load(function() {
                $('.preloader-container').hide();
            });
        })

    });

</script>
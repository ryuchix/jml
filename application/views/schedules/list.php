<?php $this->load->view( 'partials/header' ); ?>
<link rel="stylesheet" href="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css">

<style>
@media (min-width: 992px){
    .modal-lg {
        width: 1280px;
    }
}
.table>tbody>tr>td{
    vertical-align: middle;
}
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Schedule List</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( 'reports/' ); ?>"><i class="fa fa-user"></i> Schedule</a></li>
            <li><a href="<?php echo site_url( 'schedule/list' ); ?>"><i class="fa fa-user"></i> List</a></li>
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
                                        <label for="id_label_single">Date:</label>
                                        <input type="text" name="date" class="form-control date" value="<?php echo isset($_GET['date'])? $_GET['date']: date('d/m/Y'); ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group <?php echo form_error('size')? 'has-error':''; ?>">
                                        <label for="id_label_single">Staff members:</label>
                                        <?php echo form_dropdown('staff', ['All'] + $users->toArray(), isset($_GET['staff'])?$_GET['staff']: 'All', 'class="is_parent_choose form-control" id="id_label_single"'); ?>
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

                <div class="col-sm-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Jobs</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Property Address</th>
                                                <th>Category job</th>
                                                <th>Job title</th>
                                                <th>Assigned to</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($job_visits as $visit): ?>
                                            <tr>
                                                <td><?php echo $visit->job->property->full_address ?></td>
                                                <td><?php echo $visit->job->category->type; ?></td>
                                                <td><?php echo $visit->job->job_title . ' ' . ($visit->job->job_type == JOB_TYPE_RECURRING? "(R)": "(O)"); ?></td>
                                                <td>
                                                    <?php // echo $job->crews->implode('name', ',   '); ?>
                                                    <?php 
                                                    $i = 0;
                                                    if($visit->crews->count()):
                                                    echo '<ul class="crews-list">';
                                                    foreach($visit->crews as $user):?>
                                                        <?php
                                                        echo '<li class="crew-item" data-toggle="tooltip" title="' . $user->first_name . ' ' . $user->last_name . '" style="color: white;background-color: ' . $user->system_color . '">' . substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1) . '</li>';
                                                        ?>
                                                    <?php 
                                                    endforeach;
                                                    echo '</ul>';
                                                    endif; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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

    $(function () {

        $('.date').datetimepicker({
             format: 'DD/MM/YYYY'
        });

    });

</script>
<?php $this->load->view( 'partials/header' ); ?>

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

</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Clients Service<small>new</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( 'client/' ); ?>"><i class="fa fa-user"></i> Clients</a></li>
            <li><a href="<?php echo site_url( 'client/' ); ?>"><i class="fa fa-user"></i> lists</a></li>
            <li class="active">New Service</li>
        </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content">
        
        <div class="row">

            <!-- form start -->
            <form role="form" method="post" action="<?php echo site_url( "client/service/$client_id/add/" ); ?>">
                <div class="col-sm-8 col-sm-offset-2">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">Add New Service</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            
                            <div class="form-group <?php echo form_error('serivce_id')? 'has-error':''; ?>">
                                <label for="id_label_single">
                                  Choose Services:
                                </label>
                                <?php echo form_dropdown('serivce_id', $services, '', 'class="services_list form-control" id="id_label_single"'); ?>
                                <?php echo form_error('serivce_id','<p class="error-msg">','</p>') ?>
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
<script>
    
    $(function () {
        $(".services_list").select2({
            placeholder: "Choose Service",
            allowClear: true
        });
    })

</script>
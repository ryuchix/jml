<?php $this->load->view( 'partials/header' ); ?>

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
    
        <h1>Quotes No. (<?php echo $record->quote_no; ?>) History <small></small></h1>
    
        <ol class="breadcrumb">
    
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    
            <li><a href="<?php echo site_url( "quote/" ); ?>"><i class="fa fa-life-ring"></i> Quotes</a></li>
    
            <li><a href="<?php echo site_url( "quote/" ); ?>"><i class="fa fa-lists-ul"></i> List</a></li>
            
            <li class="active">History</li>
    
        </ol>
    
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">

            <div class="col-md-12">
                <div class="box box-default <?php echo form_error('description')? '':'collapsed-box'; ?>">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Custom History</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-<?php echo form_error('description')? 'minus':'plus'; ?>"></i></button>
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                      
                        <form action="<?php echo site_url( 'quote/history/'.$quote_id ); ?>" method="POST">
                            <div class="form-group <?php echo form_error('description')? 'has-error':''; ?>">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control" cols="30" rows="10" placeholder="Description"><?php echo set_value('description'); ?></textarea>
                                <?php echo form_error('description','<p class="error-msg">','</p>') ?>
                            </div>
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        </form>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>

            <div class="col-xs-12">

                <div class="box">

                    <div class="box-body">

                        <?php echo $table; ?>

                    </div>
                    <!-- /.box-body -->

                </div>
                <!-- /.box -->

            </div>
            <!-- /.col -->

        </div>
        <!-- /.row -->

    </section>

</div>

<?php $this->load->view( 'partials/footer' ); ?>

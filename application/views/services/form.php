<?php $this->load->view( 'partials/header' ); ?>

<style>
    .progress {
        display: none;
        margin: 10px 0;
    }
    #imagePreview img{
        opacity: 0.3;
    }
    .imageview-container{
        display: inline-block;
        position: relative;
    }
    .imageview-container span.delete{
        display: inline-block;
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: rgba(0,0,0,0.1);
        color: rgba(255, 255, 255, 0.50);
        padding: 3px 10px;
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
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Service <small>new</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( 'services/' ); ?>"><i class="fa fa-life-ring"></i> Services</a></li>
            <li class="active">new</li>
        </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content">
        
        <div class="row">

            <!-- form start -->
            <form role="form" method="post" action="<?php echo site_url( 'services/save/'.$record->id ); ?>">
                <div class="col-sm-7">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">Add New Service</h3>
                        </div>
                        <!-- /.box-header -->
                        
                        <div class="box-body">
                            
                            <div class="form-group <?php echo form_error('data[name]')? 'has-error':''; ?>">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="data[name]" id="name" placeholder="Service Name" value="<?php echo set_value('data[name]',$record->name); ?>">
                                <?php echo form_error('data[name]', '<p class="error-msg">', '</p>') ?>
                            </div>
                            
                            <div class="form-group <?php echo form_error('data[rate]')? 'has-error':''; ?>">
                                <label for="rate">Rate</label>
                                <input type="text" class="form-control" name="data[rate]" id="rate" placeholder="Rate" value="<?php echo set_value('data[rate]', $record->rate ); ?>">
                                <?php echo form_error('data[rate]', '<p class="error-msg">', '</p>') ?>
                            </div>
                            
                            <div class="form-group">
                                <label for="rate">Hour/Job</label>
                                <?php
                                $type = array(''=>'Choose Hour/job','Hour'=>'Hour','Job'=>'Job');

                                echo form_dropdown('data[job_type]', $type, isset($_POST['data']['job_type'])? $_POST['data']['job_type']: $record->job_type, ' class="form-control"' );
                                 ?>
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" rows="3" name="data[description]" placeholder="Description..."><?php echo set_value('data[description]'); ?><?php echo $record->description; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="image">Choose Files</label>
                                <input type="hidden" name="data[image]" id="image" value="<?php echo set_value('data[image]', $record->image); ?>">
                                <input type="file" class="form-control" id="imageFile">
                                <input type="hidden" id="UPLOAD_URL" value="<?php echo site_url( 'file_uploader/image/'.$record->id ); ?>">
                                <input type="hidden" id="DELETE_URL" value="<?php echo site_url( 'file_uploader/delete_via_ajax/' ); ?>">
                                <input type="hidden" id="RECORD_ID" value="<?php echo $record->id; ?>">
                                <input type="hidden" id="MODEL" value="Service">
                                <input type="hidden" id="FOLDER" value="services">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                        0%
                                    </div>
                                </div>

                            </div>

                        </div>
                        
                        <!-- /.box-body -->
                        
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        </div>

                    </div>
                </div>

                <div class="col-sm-5">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">Image Preview</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body" id="imagePreview">

                            <?php if ($record->id && $record->image): ?>
                                <div class="imageview-container">
                                    <span class="delete" data-image-name="<?php echo $record->image; ?>">X</span>
                                    <img class="img-responsive" src="<?php echo base_url('uploads/services/'.$record->image) ?>" alt="Bin Attachemtn Preview" style="opacity: 1;">
                                </div>

                            <?php endif; ?>

                        </div> <!-- .body -->
                    </div> <!-- .box-primary -->
                </div> <!-- .col-sm-4 -->
            
            </form>

        </div>
        <!-- /.row -->

    </section>
</div>

<?php $this->load->view( 'partials/footer' ); ?>
<script src="<?php echo base_url(); ?>assets/dist/js/imageupload.js"></script>
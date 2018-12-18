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
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Notes<small><?php echo $record->id? 'edit': 'new'; ?></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( 'client/' ); ?>"><i class="fa fa-user"></i> Clients</a></li>
            <li><a href="<?php echo site_url( "client/notes/$client_id" ); ?>"><i class="fa fa-user"></i> Notes</a></li>
            <li class="active"><?php echo $record->id? 'Edit': 'New'; ?></li>
        </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content">
        
        <div class="row">

            <!-- form start -->
            <form role="form" method="post" action="<?php echo site_url( "client/notes/$client_id/save/".$record->id ); ?>">
                <div class="col-sm-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?php echo $record->id? 'Edit': 'Add New'; ?> Notes</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            
                            <div class="form-group">
                                <label for="user_role">Document Type</label>
                                <?php echo form_dropdown('data[document_type]', $document_types, $record->document_type, 'class="form-control"'); ?>

                            </div>
                            
                            <div class="form-group <?php echo form_error('data[user_roles][]')? 'has-error':''; ?>">
                                <label for="notes">User Role</label>
                                <?php 
                                $i = 0;
                                $roles = array(
                                    ADMIN_ROLE => 'Admin',
                                    STAFF_ROLE => 'Staff/Contractor',
                                    OFFICE_MANAGER_ROLE => 'Office Manager',
                                    OPERATION_MANAGER_ROLE => 'Operation Manager'
                                );
                                $selected_roles = $record->id? explode(',', $record->user_roles): [];
                                foreach ($roles as $key=>$role): 

                                    echo sprintf('<div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" value="%s" %s name="data[user_roles][]">
                                                        %s
                                                    </label>
                                                </div>',
                                                $key,
                                                ($record->id)? 
                                                    (in_array($key, $selected_roles))? 'checked': ''
                                                    : ((++$i)==1)? 'checked':''
                                                ,
                                                $role);

                                endforeach;
                                ?>
                                <?php echo form_error('data[user_roles][]','<p class="error-msg">','</p>') ?>
                            </div>
                            
                            <div class="form-group <?php echo form_error('data[notes]')? 'has-error':''; ?>">
                                <label for="notes">Notes</label>
                                <textarea class="form-control" rows="3" name="data[notes]" placeholder="Notes..."><?php echo set_value('data[notes]', $record->notes); ?></textarea>
                                <?php echo form_error('data[notes]','<p class="error-msg">','</p>') ?>
                            </div>

                            <div class="form-group">
                                <label for="image">Choose Files</label>
                                <input type="hidden" name="data[image]" id="image" value="<?php echo set_value('data[image]', $record->image); ?>">
                                <input type="file" class="form-control" id="imageFile">
                                <input type="hidden" id="UPLOAD_URL" value="<?php echo site_url( 'client/upload_client_note/'.$record->id ); ?>">
                                <input type="hidden" id="DELETE_URL" value="<?php echo site_url( 'client/delete_via_ajax/' ); ?>">
                                <input type="hidden" id="RECORD_ID" value="<?php echo $record->id; ?>">
                                <input type="hidden" id="FOLDER" value="client_notes">
                                <input type="hidden" id="MODEL" value="Client_note">
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
                <div class="col-sm-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">Attachment</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body" id="imagePreview">

                            <?php if ($record->id && $record->image): ?>
                                
                                <div class="imageview-container">
                                    <span class="delete" data-image-name="<?php echo $record->image; ?>">X</span>
                                    <a href="<?php echo base_url('uploads/bin_types/'.$record->image) ?>" 
                                    download="<?php echo base_url('uploads/bin_types/'.$record->image) ?>">
                                        <?php echo $record->image; ?>
                                    </a>
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
<script src="<?php echo base_url(); ?>assets/dist/js/fileupload.js"></script>
<script>
    
$(function () {



});

</script>
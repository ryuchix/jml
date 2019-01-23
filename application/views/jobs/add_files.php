<?php $this->load->view( 'partials/header' ); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/basic.min.css">

<style>

.dropzone .dz-preview {
    display: none;
}
.dz-default.dz-message {
    display: flex;
    justify-content: center;
    margin: auto;
    flex: 1;
    height: 100%;
    position: absolute;
    width: 100%;
    left: 0;
    top: 0;
    align-items: center;
    font-size: 28px;
    color: #505da3;
    font-weight: bold;
}

#my-dropzone.dz-started.dz-uploading:after {
    content: "File uploading...";
}

#my-dropzone.dz-started:after {
    display: flex;
    content: "Drop files here to upload";
    text-align: center;
    position: absolute;
    width: 100%;
    height: 100%;
    justify-content: center;
    align-items: center;
    top: 0;
    left: 0;
    font-size: 28px;
    color: #505da3;
}

#my-dropzone {
    background: #f1f1f1;
    border: 5px dashed #ccc;
    min-height: 200px;
}

</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Add File</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url( 'jobs/' ); ?>"><i class="fa fa-user"></i> Jobs</a></li>
            <li class="active">Add File</li>
        </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-sm-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Job name: <?php echo $job->job_title; ?></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        
                        <form action="<?php echo site_url("/job_files/file_upload/$job->id"); ?>" class="dropzone" id="my-dropzone" enctype="multipart/form-data">
                            <div class="fallback">
                                <input name="file" type="file" multiple />
                            </div>
                        </form>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Uploaded Files</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" id="Vue">
                        
                        <ul class="list-group">
                            <li class="list-group-item" v-for="(file, index) in files" v-key="index">
                                <a :href="'<?php echo site_url('/uploads/job_attachments/') ?>' + file.name">{{ file.name }}</a>
                            </li>
                        </ul>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </section>
</div>

<?php $this->load->view( 'partials/footer' ); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.21/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
<script>

    new Vue({
        el: "#Vue",
        data: {
            files: [],
            job_id: <?php echo $job->id; ?>
        },
        methods: {

            loadFiles: function(){
                axios.get('<?php echo site_url("/job_files/get_files/") ?>' + this.job_id)
                .then(function(data){
                    for(file in data.data.files){
                        this.files.push(data.data.files[file]);
                    }
                }.bind(this))
            }

        },
        created: function(){

            this.loadFiles();

            Dropzone.autoDiscover = false;
            var myDropzone = new Dropzone("#my-dropzone");
            myDropzone.on("error", function(file, error) {
                console.log(file, error);
            });

            myDropzone.on("uploadprogress", function(file) {
                $("#my-dropzone").addClass('dz-uploading');
            });

            myDropzone.on("complete", function(file, s) {
                this.files.push({'name': file.name })
                $("#my-dropzone").removeClass('dz-uploading');
            }.bind(this));
        }
    });

    
</script>
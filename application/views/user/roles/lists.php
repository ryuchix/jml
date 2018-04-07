<?php $this->load->view( 'partials/header' ); ?>

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">

        <h1>Users <small></small></h1>

        <ol class="breadcrumb">

            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
  
            <li><a href="<?php echo site_url('users'); ?>"><i class="fa fa-users"></i> Users</a></li>
  
            <li><a href="<?php echo site_url('roles'); ?>"><i class="fa fa-keys"></i> Roles</a></li>

            <li class="active">List</li>

        </ol>

    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">

            <div class="col-xs-12">

                <div class="box">

                    <div class="box-body">

                        <?php $this->load->view('user/roles/table', array('records'=>$records)); ?>
                                    
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



<!-- Default modal -->
<div class="modal fade" id="permissionsModel" tabindex="-1" role="dialog" aria-labelledby="photoModelLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="permissionsModelLabel">Permissions</h4>
            </div>

            <div class="modal-body">
            
            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>

            </div>

        </div>

    </div>

</div>

<?php $this->load->view( 'partials/footer' ); ?>

<script>
    
    $('.delete').on('click',function (e) {
        if (!confirm("do you really want to delete this user?")) {
            e.preventDefault();
        }
    });


    $("#permissionsModel").on("show.bs.modal", function(e)
    {
        var $link = $(e.relatedTarget);

        $('#permissionsModelLabel').text( $link.parents('tr').find('td:eq(0)').text() );

        $(this).find(".modal-body").load($link.attr("href"));

    });

</script>
<?php $this->load->view( 'partials/header' ); ?>

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
    
        <h1>Client <small>list</small></h1>
    
        <ol class="breadcrumb">
    
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    
            <li><a href="<?php echo site_url( "client/" ); ?>"><i class="fa fa-life-user"></i> Clients</a></li>

            <li><a href="<?php echo site_url( "client/contact/$client_id/list" ); ?>"><i class="fa fa-file-text"></i> Contacts</a></li>
    
            <li class="active">List</li>
    
        </ol>
    
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">

            <div class="col-xs-12">

                <div class="box">

                    <div class="box-body">

                        <a href="<?php echo site_url( "client/service/$client_id/add" ); ?>" style="display: inline;"><i class="fa fa-plus"></i></a>

                        <table id="example2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Service Name</th>

                                    <th>Description</th>

                                    <th>Action</th>

                                </tr>

                            </thead>

                            <tbody>

                            <?php foreach($records as $row){ ?>
                            <tr>

                                <td><?php echo $row->name; ?></td>

                                <td><?php echo $row->description; ?></td>

                                <td>

                                  <div class="btn-group">

                                        <button data-toggle="dropdown" class="dropdown-toggle btn btn-icon-toggle btn-default ink-reaction">

                                          <i class="fa fa-ellipsis-v "></i>

                                        </button>

                                        <ul class="dropdown-menu">

                                            <li><?php echo anchor(site_url("client/service/".$row->id."/remove/"),'<i class="fa fa-remove"></i> Remove', 'confirmation')?></li>
                                        
                                        </ul>

                                    </div>

                                </td>

                            </tr>

                            <?php } ?>

                            </tbody>

                        </table>

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

<script>

    $('.confirmation').on('click', function (e) {
        if (!confirm("do you really want to remove this service?")) { e.preventDefault(); }
    });

</script>
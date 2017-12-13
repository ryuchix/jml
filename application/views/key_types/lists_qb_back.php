<?php $this->load->view( 'partials/header' ); ?>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Services <small>list</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-life-ring"></i> Services</a></li>
            <li class="active">List</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">

        <div class="row">

            <div class="col-xs-12">

                <div class="box">

                    <div class="box-body">

                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Fully Qualified Name</th>
                                    <th>Unit Price</th>
                                    <th>Active</th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php foreach($records as $row){ ?>
                            <tr>
                                <td><?php echo $row->Name; ?></td>
                                <td><?php echo $row->Description; ?></td>
                                <td><?php echo $row->FullyQualifiedName; ?></td>
                                <td><?php echo $row->UnitPrice; ?></td>
                                <td><i class="fa fa-<?php echo $row->Active? 'check':''; ?>"></i></td>
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
    
    $('.delete').on('click',function (e) {
        if (!confirm("do you really want to delete this Service?")) {
            e.preventDefault();
        }
    });

    $('.disable').on('click', function (e) {
        if (!confirm("do you really want to disable this Service?")) {
            e.preventDefault();
        }
    });

</script>
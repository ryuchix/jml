<div class="row">

    <div class="col-xs-12">

        <div class="box">

            <div class="box-body">

                <table id="example1" class="table table-bordered table-striped">

                    <thead>

                        <tr>

                            <th>Permission</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php foreach($permissions as $row){ ?>

                        <tr>

                            <td><?php echo $row->label; ?></td>

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
<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>User Name</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($records as $row){ ?>
    <tr>
        <td><?php echo $row->first_name.' '.$row->last_name; ?></td>
    </tr>
    <?php } ?>

    </tbody>

</table>
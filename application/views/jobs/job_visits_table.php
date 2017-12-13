<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Visit Date</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($records as $row){ ?>
    <tr>
        <td><?php echo local_date($row->date); ?></td>
    </tr>
    <?php } ?>

    </tbody>

</table>
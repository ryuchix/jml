<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Line Item</th>
            <th>Quantity</th>
            <th>Cost</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($records as $row){ ?>
    <tr>
        <td><?php echo $row->name; ?></td>
        <td><?php echo $row->qty; ?></td>
        <td><?php echo $row->unit_cost; ?></td>
        <td>$<?php echo $row->total; ?></td>
    </tr>
    <?php } ?>

    </tbody>

</table>
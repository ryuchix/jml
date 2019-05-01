<table id="firstDateSort" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Cost title</th>
            <th>Monthly Cost</th>
            <th>Daily Cost</th>
            <th>Notes</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($records as $row): ?>
    <tr>
        <td><?= $row->id; ?></td>
        <td><?= $row->cost_title; ?></td>
        <td>
            <?= "$$row->monthly_cost"; ?>
        </td>
        <td>
            <?= "$" . number_format($row->daily_cost, 2); ?>
        </td>
        <td><?= $row->notes; ?></td>
        <td>
            <div class="btn-group">
                <button data-toggle="dropdown" class="dropdown-toggle btn btn-icon-toggle btn-default ink-reaction">
                  <i class="fa fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><?php echo anchor(site_url("bin-cleaning-costing/$row->id/edit"),'<i class="fa fa-pencil"></i> Edit')?></li>
                    <li><?php echo anchor(site_url("bin-cleaning-costing/$row->id/delete"),'<i class="fa fa-trash"></i> Delete', 'onclick="return confirm(\'Do you want to delete this record?\');"')?></li>
                </ul>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<table id="firstDateSort" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Cost title</th>
            <th>Monthly Cost</th>
            <th>Daily Cost</th>
            <th>Notes</th>
            <!-- <th>Action</th> -->
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
            <?= "$$row->daily_cost"; ?>
        </td>
        <td><?= $row->notes; ?></td>
        <!-- <td>
            <div class="btn-group">
                <button data-toggle="dropdown" class="dropdown-toggle btn btn-icon-toggle btn-default ink-reaction">
                  <i class="fa fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><?php echo anchor(site_url("daily_balances/save/$row->id"),'<i class="fa fa-pencil"></i> Edit')?></li>
                </ul>
            </div>
        </td> -->
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
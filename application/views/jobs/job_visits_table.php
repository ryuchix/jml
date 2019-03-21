<table  id="firstDateSort" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Visit Date</th>
            <th>Assignee</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($records as $row){ ?>
    <tr>
        <td>
            <label class="checkbox-inline">
            <?php if ($row->completed): ?>
                <input type="checkbox" checked disabled="disabled">
                <?php echo local_date($row->date); ?>
            <?php else: ?>
                <form action="<?php echo site_url('jobs/close_visit'); ?>" method="post">
                    <input type="checkbox" name="visit_id" value="<?php echo $row->id; ?>" onchange="">
                    <?php echo local_date($row->date); ?>
                </form>
            <?php endif ?>
            </label>
        </td>
        <td>
            <?php echo $row->assignee; ?>
        </td>
    </tr>
    <?php } ?>

    </tbody>

</table>
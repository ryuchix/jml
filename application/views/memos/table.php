<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Memo Number</th>
            <th>Title</th>
            <th>File</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($records as $row){ ?>
    <tr class="<?php echo ($row->id == $modified_item_id)?"animated tada\" style=\"animation-fill-mode: backwards;\"":""; ?>">
        <td>Memo-<?php echo $row->id; ?></td>
        <td><?php echo $row->title; ?></td>
        <td><?php echo anchor( site_url( "uploads/memos/$row->file" ), $row->file, "download='$row->file'"); ?></td>
        <td>
          <div class="btn-group">
                <button data-toggle="dropdown" class="dropdown-toggle btn btn-icon-toggle btn-default ink-reaction">
                  <i class="fa fa-ellipsis-v "></i>
                </button>
                <ul class="dropdown-menu">
                    <li><?php echo anchor(site_url("memo/save/$row->id"),'<i class="fa fa-pencil"></i> Edit')?></li>
                    <?php if ($row->active): ?>
                    <li><?php echo anchor(site_url("memo/activation/$row->id/0"),'<i class="fa fa-lock"></i> Disabled', 'class="disable"')?></li>
                    <?php else: ?>
                    <li><?php echo anchor(site_url("memo/activation/$row->id/1"),'<i class="fa fa-unlock"></i> Enable', 'class="reactivate"')?></li>
                    <?php endif; ?>
                </ul>
            </div>
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>
<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>File Number</th>
            <th>Title</th>
            <th>File Type</th>
            <th>Description</th>
            <th>File</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($records as $row){ ?>
    <tr class="<?php echo ($row->id == $modified_item_id)?"animated tada\" style=\"animation-fill-mode: backwards;\"":""; ?>">
        <td>File-<?php echo $row->id; ?></td>
        <td><?php echo $row->title; ?></td>
        <td><?php echo ucwords($row->type); ?></td>
        <td><?php echo $row->description; ?></td>
        <td><?php echo anchor( site_url( "uploads/memos/$row->file" ), $row->file, "download='$row->file'"); ?></td>
        <td>
          <div class="btn-group">
                <button data-toggle="dropdown" class="dropdown-toggle btn btn-icon-toggle btn-default ink-reaction">
                  <i class="fa fa-ellipsis-v "></i>
                </button>
                <ul class="dropdown-menu">
                    
                    <?php if ($controller->hasAccess('edit-file')): ?>
                        <li><?php echo anchor(site_url("files/save/$row->id"),'<i class="fa fa-pencil"></i> Edit')?></li>
                    <?php endif ?>
                    
                    <?php if ($controller->hasAccess('change-file-status')): ?>
                        
                        <?php if ($row->active): ?>
                        <li><?php echo anchor(site_url("files/activation/$row->id/0"),'<i class="fa fa-lock"></i> Disabled', 'class="disable"')?></li>

                        <?php else: ?>

                        <li><?php echo anchor(site_url("files/activation/$row->id/1"),'<i class="fa fa-unlock"></i> Enable', 'class="reactivate"')?></li>
                        
                        <?php endif; ?>

                    <?php endif ?>
                </ul>
            </div>
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>
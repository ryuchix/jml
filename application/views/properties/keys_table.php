<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Key No</th>
            <th>Key Type</th>
            <th>Description</th>
            <th>Internal Reference</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($records as $row){ ?>
    <tr class="<?php echo ($row->id == $modified_item_id)?"animated tada\" style=\"animation-fill-mode: backwards;\"":""; ?>">
        <td>Key-<?php echo $row->id; ?></td>
        <td><?php echo $row->type; ?></td>
        <td><?php echo $row->description; ?></td>
        <td><?php echo $row->internal_reference; ?></td>
        <td>
          <div class="btn-group">
                <button data-toggle="dropdown" class="dropdown-toggle btn btn-icon-toggle btn-default ink-reaction">
                  <i class="fa fa-ellipsis-v "></i>
                </button>
                <ul class="dropdown-menu">
                    
                    <?php if ($controller->hasAccess('edit-property-key')): ?>
                    <li><?php echo anchor(site_url("property/keys/$row->property_id/save/$row->id"),'<i class="fa fa-pencil"></i> Edit')?></li>
                    <?php endif ?>
                    
                    <?php if ($controller->hasAccess('change-property-key-status')): ?>
                        <?php if ($row->active): ?>
                        <li><?php echo anchor(site_url("property/key_activation/$row->id/0"),'<i class="fa fa-lock"></i> Disabled', 'class="disable"')?></li>
                        <?php else: ?>
                        <li><?php echo anchor(site_url("property/key_activation/$row->id/1"),'<i class="fa fa-unlock"></i> Enable', 'class="reactivate"')?></li>
                        <?php endif; ?>
                    <?php endif ?>
                        
                    <li><?php echo anchor(site_url("property/key_photo/$row->id"),'<i class="fa fa-image"></i> Photo', ' data-remote="false" data-toggle="modal" data-target="#photoModel" class=""')?></li></ul>
            </div>
        </td>
    </tr>

    <?php } ?>

    </tbody>

</table>


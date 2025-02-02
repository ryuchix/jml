<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Lead Type</th>
            <th>Description</th>
            <th>Color</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($records as $row){ ?>
    <tr class="<?php echo ($row->id == $modified_item_id)?"animated tada\" style=\"background: #fff;\"":""; ?>">
        <td><?php echo $row->type; ?></td>
        <td><?php echo $row->description; ?></td>
        <td><span class='badge' style="background-color: <?php echo $row->color; ?>"><?php echo $row->color; ?></span></td>
        <td>
          <div class="btn-group">
                <button data-toggle="dropdown" class="dropdown-toggle btn btn-icon-toggle btn-default ink-reaction">
                  <i class="fa fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    
                    <?php if ($row->editable && $controller->hasAccess('edit-lead-type')): ?>
                    <li><?php echo anchor(site_url($class_name.'/save/'.$row->id),'<i class="fa fa-pencil"></i> Edit')?></li>
                    <?php endif ?>
                    
                    <?php if ($controller->hasAccess('change-lead-type-status')): ?>
                    
                        <?php if ($row->active): ?>
                    
                        <li><?php echo anchor(site_url($class_name.'/activation/'.$row->id.'/0'),'<i class="fa fa-lock"></i> Disabled', 'class="disable"')?></li>
                    
                        <?php else: ?>
                    
                        <li><?php echo anchor(site_url($class_name.'/activation/'.$row->id.'/1'),'<i class="fa fa-unlock"></i> Enable', 'class="reactivate"')?></li>
                    
                        <?php endif; ?>
                    
                    <?php endif ?>

                </ul>

            </div>

        </td>
        
    </tr>

    <?php } ?>

    </tbody>

</table>


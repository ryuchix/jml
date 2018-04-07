<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>License Plate</th>
            <th>Make</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($records as $row){ ?>
    <tr class="<?php echo ($row->id == $modified_item_id)?"animated tada\" style=\"animation-fill-mode: backwards;\"":""; ?>">
        <td><?php echo $row->license_plate; ?></td>
        <td><?php echo $row->make; ?></td>
        <td>
          <div class="btn-group">
                <button data-toggle="dropdown" class="dropdown-toggle btn btn-icon-toggle btn-default ink-reaction">
                  <i class="fa fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    
                    <?php if ($controller->hasAccess('edit-user')): ?>
                    <li><?php echo anchor(site_url($class_name.'/save/'.$row->id),'<i class="fa fa-pencil"></i> Edit')?></li>
                    <?php endif ?>
                    
                    <?php if ($controller->hasAccess('change-vehicle-status')): ?>
                        <?php if ($row->active): ?>

                        <li><?php echo anchor(site_url($class_name.'/activation/'.$row->id.'/0'),'<i class="fa fa-lock"></i> Disabled', 'class="disable"')?></li>
                        <?php else: ?>
                        <li><?php echo anchor(site_url($class_name.'/activation/'.$row->id.'/1'),'<i class="fa fa-unlock"></i> Enable', 'class="reactivate"')?></li>
                        <?php endif; ?>
                    <?php endif ?>

                    <?php if ($controller->hasAccess('view-vehicle-rego')): ?>
                    <li><?php echo anchor(site_url("vehicle_rego/index/$row->id"),'<i class="fa fa-fax"></i> Rego')?></li>
                    <?php endif ?>

                    <?php if ($controller->hasAccess('view-vehicle-finance')): ?>
                    <li><?php echo anchor(site_url("$class_name/finance/$row->id"),'<i class="fa fa-money"></i> Finance')?></li>
                    <?php endif ?>

                    <?php if ($controller->hasAccess('view-vehicle-insurance')): ?>
                    <li><?php echo anchor(site_url("$class_name/insurance/$row->id"),'<i class="fa fa-fire-extinguisher"></i> Insurance')?></li>
                    <?php endif ?>

                    <?php if ($controller->hasAccess('view-vehicle-odometer')): ?>
                    <li><?php echo anchor(site_url("odometer/lists/$row->id"),'<i class="fa fa-tachometer"></i> Odometer')?></li>
                    <?php endif ?>
                    
                    <?php if ($controller->hasAccess('view-vehicle-service')): ?>
                    <li><?php echo anchor(site_url("vehicle_services/lists/$row->id"),'<i class="fa fa-file-pdf-o"></i> Service')?></li>
                    <?php endif ?>

                    <?php if ($controller->hasAccess('view-vehicle-fuel')): ?>
                    <li><?php echo anchor(site_url("vehicle_fuel/lists/$row->id"),'<i class="fa fa-assistive-listening-systems"></i> Fuel')?></li>
                    <?php endif ?>

                </ul>
            </div>
        </td>
    </tr>

    <?php } ?>

    </tbody>

</table>


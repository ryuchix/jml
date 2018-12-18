<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Client</th>
            <th>Address</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($records as $row){ ?>
    <?php if ($row->id == $modified_item_id): ?>    
    <tr class="animated tada" style="background: #fff; animation-fill-mode: backwards;">
    <?php else: ?>
        <tr>
    <?php endif; ?>
        <td><?php echo $row->name; ?></td>
        <td><?php echo $row->address . ', ' . $row->address_suburb . ', ' . $row->address_post_code; ?></td>
        <td>
          <div class="btn-group">
                <button data-toggle="dropdown" class="dropdown-toggle btn btn-icon-toggle btn-default ink-reaction">
                  <i class="fa fa-ellipsis-v "></i>
                </button>
                <ul class="dropdown-menu">
                    <?php if ($controller->hasAccess('edit-property')): ?>
                    <li><?php echo anchor(site_url("property/save/$row->id"),'<i class="fa fa-pencil"></i> Edit', 'class=""')?></li>
                    <?php endif ?>
                    
                    <?php if ($controller->hasAccess('change-property-status')): ?>
                    <?php if ($row->active): ?>
                    <li><?php echo anchor(site_url("property/activation/$row->id/0"),'<i class="fa fa-lock"></i> Disabled', 'class=" disable"')?></li>
                    <?php else: ?>
                    <li><?php echo anchor(site_url("property/activation/$row->id/1"),'<i class="fa fa-unlock"></i> Enable', 'class=" reactivate"')?></li>
                    <?php endif; ?>
                    <?php endif ?>
                    
                    <?php if ($controller->hasAccess('view-property-history')): ?>
                    <li><?php echo anchor(site_url("property/history/$row->id"),'<i class="fa fa-file-text"></i> History')?></li>
                    <?php endif ?>
                    
                    <?php if ($controller->hasAccess('view-property-key')): ?>
                    <li><?php echo anchor(site_url("property/keys/$row->id/lists"),'<i class="fa fa-key"></i> Keys')?></li>
                    <?php endif ?>
                    
                    <?php if ($controller->hasAccess('view-property-gallery')): ?>
                    <li><?php echo anchor(site_url("gallery/index/property/$row->id"),'<i class="fa fa-camera"></i> Gallery')?></li>
                    <?php endif ?>
                    
                    <li><?php echo anchor(site_url("property/bins/$row->id/lists"),'<i class="fa fa-trash"></i> Bins')?></li>
                    <li><?php echo anchor(site_url("property/consumables/$row->id/lists"),'<i class="fa fa-hourglass-half"></i> Consumables')?></li>
                    <li><?php echo anchor(site_url("Property_consumable_equipment/save/$row->id"),'<i class="fa fa-hourglass"></i> Consumable Equipment')?></li>
                    <li><?php echo anchor(site_url("property/map/$row->id"),'<i class="fa fa-map-marker"></i> Map', ' data-remote="false" data-toggle="modal" data-target="#myModal" class=""')?></li>
                    <li><?php echo anchor(site_url("property_video/lists/$row->id"),'<i class="fa fa-video-camera"></i> Videos')?></li>
                </ul>
            </div>
        </td>
    </tr>

    <?php } ?>

    </tbody>

</table>


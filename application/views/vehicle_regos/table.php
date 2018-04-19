<table id="example1" class="table table-bordered table-striped">
    
    <thead>
    
        <tr>
    
            <th>Ref #</th>

            <th>Rate</th>
    
            <th>Payment Due Date</th>
    
            <th>Expiry Date</th>
    
            <th>Status</th>
    
            <th>Action</th>
    
        </tr>
    
    </thead>
    
    <tbody>
    
    <?php foreach($records as $row){ ?>

    <tr>
        
        <td><?php echo $row->id ?></td>

        <td>$<?php echo $row->rate; ?></td>
        
        <td><?php echo local_date($row->due_date); ?></td>
        
        <td><?php echo local_date($row->expiry_date); ?></td>
        
        <td><?php echo get_status($row->status); ?></td>
        
        <td>
        
          <div class="btn-group">
        
                <button data-toggle="dropdown" class="dropdown-toggle btn btn-icon-toggle btn-default ink-reaction">
        
                  <i class="fa fa-ellipsis-v "></i>
        
                </button>
        
                <ul class="dropdown-menu">
                    <?php if ($controller->hasAccess('edit-vehicle-rego')): ?>
                    <li><?php echo anchor(site_url("vehicle_rego/save/$row->vehicle_id/$row->id"),'<i class="fa fa-pencil"></i> Edit')?></li>
                    <?php endif ?>
        
                    <?php if ($controller->hasAccess('delete-vehicle-rego')): ?>
                    <li><?php echo anchor(site_url("vehicle_rego/delete/$row->vehicle_id/$row->id"),'<i class="fa fa-trash"></i> Delete', 'class="delete"')?></li>
                    <?php endif ?>
        
                </ul>
        
            </div>
        
        </td>

    </tr>
    
    <?php } ?>

    </tbody>
</table>
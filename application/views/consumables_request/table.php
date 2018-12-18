<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Date</th>
            <th>Property</th>
            <th>Client</th>
            <th>Status</th>
            <th>Request by</th>

            <?php if (isset($approval_datetime) && $approval_datetime): ?>
                <th>Approved by</th>
                <th>Approved at</th>
            <?php endif ?>

            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($records as $row): ?>
    <tr>
        <td><?php echo local_date($row->date); ?></td>
        <td><?php echo $row->address; ?></td>
        <td><?php echo $row->name; ?></td>
        <td><?php echo get_status($row->status); ?></td>
        <td><?php echo $row->request_by; ?></td>

        <?php if (isset($approval_datetime) && $approval_datetime): ?>
            <td><?php echo $row->approved_by; ?></td>
            <td><?php echo $row->approved_at; ?></td>
        <?php endif ?>

        <td>
          <div class="btn-group">
                <button data-toggle="dropdown" class="dropdown-toggle btn btn-icon-toggle btn-default ink-reaction">
                  <i class="fa fa-ellipsis-v "></i>
                </button>
                <ul class="dropdown-menu">
                    <?php if ($controller->hasAccess('edit-consumable-request')): ?>
                    <li><?php echo anchor(site_url("consumable_request/save/$row->id"),'<i class="fa fa-pencil"></i> Edit')?></li>
                    <?php endif ?>
                    
                    <?php if ($controller->hasAccess('view-consumable-request-history')): ?>
                    <li><?php echo anchor(site_url("consumable_request/history/$row->id"),'<i class="fa fa-lock"></i> History')?></li>
                    <?php endif ?>
                    
                    <?php if ($controller->hasAccess('can-approve-consumable-request') && !$row->approved_by): ?>
                    <li><?php echo anchor(site_url("consumable_request/approve/$row->id"),'<i class="fa fa-check"></i> Approve')?></li>
                    <?php endif ?>
            </div>
                        
        </td>
    </tr>

    <?php endforeach; ?>

    </tbody>

</table>


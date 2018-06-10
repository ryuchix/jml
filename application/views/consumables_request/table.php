<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Date</th>
            <th>Property</th>
            <th>Client</th>
            <th>Status</th>
            <th>Request by</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($records as $row){ ?>
    <tr>
        <td><?php echo local_date($row->date); ?></td>
        <td><?php echo $row->address; ?></td>
        <td><?php echo $row->name; ?></td>
        <td><?php echo get_status($row->status); ?></td>
        <td><?php echo $row->request_by; ?></td>
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
            </div>
                        
        </td>
    </tr>

    <?php } ?>

    </tbody>

</table>


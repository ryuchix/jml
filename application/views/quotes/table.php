<div class="table-responsive">
<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Quote No.</th>
            <th>Client</th>
            <th>Service</th>
            <th>Property</th>
            <th>Status</th>
            <th>Chance</th>
            <th>Contact</th>
            <th>Sales</th>
            <th>Frequency</th>
            <th>Value</th>
            <th>Yearly</th>
            <th>Last Contacted</th>
            <th>Next Contact</th>
            <th>Expected Signoff</th>
            <?php if(isset($won) && $won): ?>
            <th>Quote Won</th>
            <?php endif; ?>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($records as $row){ ?>
    <tr>
        <?php if ($row->file): ?>
        <td><?php echo anchor(base_url('uploads/quotes/'.$row->file), $row->quote_no, 'download="'.$row->file.'"'); ?></td>
        <?php else: ?>
        <td><?php echo $row->quote_no; ?></td>
        <?php endif; ?>
        <td><?php echo $row->client; ?></td>
        <td><?php echo $row->service; ?></td>
        <td><?php echo $row->address; ?></td>
        <td><?php echo get_status($row->status); ?></td>
        <td><?php echo $row->chance; ?>%</td>
        <td><?php echo $row->contact; ?></td>
        <td><?php echo $row->sales; ?></td>
        <td><?php echo get_frequency($row->frequency); ?></td>
        <td>$<?php echo $row->value; ?></td>
        <td>$<?php echo $row->yearly; ?></td>
        <td><?php echo local_date($row->last_contact); ?></td>
        <td><?php echo local_date($row->next_contact); ?></td>
        <td><?php echo local_date($row->expected_signoff); ?></td>
        <?php if(isset($won) && $won): ?>
        <td><?php echo local_date($row->quote_won); ?></td>
        <?php endif; ?>
        <td>

            <?php if( $controller->hasAccess(['edit-quote', 'view-quote-history']) ): ?>

            <div class="btn-group">

                <button data-toggle="dropdown" class="dropdown-toggle btn btn-icon-toggle btn-default ink-reaction">
                    <i class="fa fa-ellipsis-v"></i>
                </button>

                <ul class="dropdown-menu">
                    
                    <?php if( $controller->hasAccess('edit-quote') ): ?>
                    <li><?php echo anchor(site_url("$class_name/save/$row->id"),'<i class="fa fa-pencil"></i> Edit')?></li>
                    <?php endif;?>

                    <?php if( $controller->hasAccess('view-quote-history') ): ?>
                    <li><?php echo anchor(site_url("$class_name/history/$row->id"),'<i class="fa fa-file-text-o"></i> History')?></li>
                    <?php endif; ?>

                </ul>
            </div>

            <?php endif; ?>

        </td>

    </tr>

    <?php } ?>

    </tbody>

</table>
</div>
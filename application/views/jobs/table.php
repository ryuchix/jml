<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Job no.</th>
            <th>Property/Client</th>
            <th>Type of job</th>
            <th>Category</th>
            <!-- <th>Last Visit</th> -->
            <th>Next Visit</th>
            <th>Value</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($records as $row){ ?>
    <tr>
        <td>Job-<?php echo $row->id; ?></td>
        <td><?php echo $row->address . ' <br> ' . $row->client; ?></td>
        <td><?php echo get_job_types($row->job_type); ?></td>
        <td><?php echo get_job_categories($row->job_category) . ' - ' . $row->job_description; ?></td>
        <td><?php echo ($row->next_visit && !$row->closed)? local_date($row->next_visit):''; ?></td>
        <!-- <td><?php echo ''; ?></td> -->
        <td>$<?php echo $row->value; ?></td>
        <td>
          <div class="btn-group">
                <button data-toggle="dropdown" class="dropdown-toggle btn btn-icon-toggle btn-default ink-reaction">
                  <i class="fa fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><?php echo anchor(site_url($class_name.'/save/'.$row->id),'<i class="fa fa-pencil"></i> Edit'); ?></li>
                    <li><?php echo anchor(site_url($class_name.'/view/'.$row->id),'<i class="fa fa-eye"></i> View Job'); ?></li>
                    <?php if (!$row->closed): ?>
                    <li><?php echo anchor(site_url($class_name.'/close/'.$row->id),'<i class="fa fa-times"></i> Close Job', 'class="close-job"'); ?></li>
                    <?php endif ?>
                </ul>
            </div>
        </td>
    </tr>

    <?php } ?>

    </tbody>

</table>

<!-- $2y$12$CtarNAi9fi9Oo2FPvSOu1eKGGjmIybOeTqCEnq9IgTaXqjo1w3VFK -->
<!-- default -->
<!-- $2y$12$I7YsrXknuwGCrsd2biEMW.A8U00qykOnxFDMpdETNSA7TSt8dUcgK -->
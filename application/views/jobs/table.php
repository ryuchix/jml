<?php 

$frequency = [
    'Weekly'    => 'Week',
    'Daily'     => 'Day',
    'Monthly'   => 'Month',
    'Yearly'    => 'Year',
];

?>

<table id="example1" data-ordering="false" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Job no.</th>
            <th>Duration</th>
            <th>Schedule for</th>
            <th>Property/Client</th>
            <th>Type of job</th>
            <th>Job Category</th>
            <th>Job</th>
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
        <?php if($row->job_type == 2): ?>
            <td><?php echo $row->duration . ' ' . $row->duration_schedule; ?></td>
        <?php else: ?>
            <td><?php echo '1 Day'; ?></td>
        <?php endif; ?>
        <?php if($row->visit_frequency == 'custom'): ?>
            <td>Every <?php echo $row->every_no_day . ' ' . $frequency[$row->frequency] . ' on ' . $row->week_days; ?></td>
        <?php else: ?>
            <td><?php echo '&nbsp;'; ?></td>
        <?php endif; ?>
        <td><?php echo $row->address . ' <br> ' . $row->client; ?></td>
        <td><?php echo get_job_types($row->job_type ? $row->job_type: 1); ?></td>
        <td><?php echo $row->job_category; ?></td>
        <td><?php echo $row->job_title; ?></td>
        
        <?php if($row->job_type == 1): ?>
            <td><?php echo local_date($row->start_date); ?></td>
        <?php else: ?>
            <td><?php echo ($row->next_visit && !$row->closed)? local_date($row->next_visit):''; ?></td>
        <?php endif; ?>

        <!-- <td><?php echo ''; ?></td> -->
        <td>$<?php echo $row->value; ?></td>
        <td>

          <div class="btn-group">

                <button data-toggle="dropdown" class="dropdown-toggle btn btn-icon-toggle btn-default ink-reaction">
                  <i class="fa fa-ellipsis-v"></i>
                </button>
                
                <ul class="dropdown-menu">

                    <?php if ($controller->hasAccess('edit-job')): ?>
                    <li><?php echo anchor(site_url($class_name.'/save/'.$row->id),'<i class="fa fa-pencil"></i> Edit'); ?></li>
                    <?php endif ?>

                    <li><?php echo anchor(site_url($class_name.'/view/'.$row->id),'<i class="fa fa-eye"></i> View Job'); ?></li>

                    <li><?php echo anchor(site_url('job_files/add_files/'.$row->id),'<i class="fa fa-file-o"></i> Add Files'); ?></li>
                    
                    <?php if (!$row->closed && $controller->hasAccess('close-job')): ?>
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
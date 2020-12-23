<!doctype html>
<html lang="en">
  <head>
    <title>Schedule List</title>
    <style>
    @page { margin: 120px 40px; }
    * { font-family: "helvetica" !important; }
    header { position: fixed; top: -90px; left: 0px; right: 0px; height: 100px; }
    table{ collapse: collapse; font-size: 10px; width: 100% }
    table td, table th{ border: 1px solid #000; padding: 5px; font-size: 12px; color: #111; }
    table th{ background-color: #eee; padding: 10px; text-transform: capitalize; font-size: 11px; }
    /* table tr:nth-child(even){ background-color: #eee; } */
    .head>div{ display: flex; justify-content: center; }
    .head>div>div{ flex: 1; text-align: center; }
    .head h3{ text-decoration: underline; margin-top: 5px; font-size: 16px; }
    ul { margin: 0; padding: 0;}
    ul.crews-list { display: inline; }
    .crews-list li.crew-item { display:inline-block; width: 20px; height: 20px; border-radius: 50%; text-align: center; font-weight: bold; }
    </style>
  </head>
  <body>

    <header class="head">
        <div>
            <img src="<?php echo APPPATH . '../assets/images/logo.png'; ?>" alt="Logo" width="180">
            <div>
                <h3 align="center">Schedule List</h1>
            </div>
        </div>
    </header>

        <ul style="margin-top: -10px;">
            <li style="width: 48%; display: inline-block;">Date: <?= @$_GET['date'] ?></li>
            <li style="width: 48%; display: inline-block;">Vehicle: </li>
        </ul>

        <ul style="margin: 10px 0;">
            <li style="width: 48%; display: inline-block;">Odo Start: </li>
            <li style="width: 48%; display: inline-block;">Odo End: </li>
        </ul>
    
    <table  cellspacing="0">
        <thead>
            <tr>
                <th>Property Address</th>
                <th>Category job</th>
                <th>Job title</th>
                <th>Instructions</th>
                <th>Assigned to</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($job_visits as $visit): ?>
            <tr>
                <td><?php echo $visit->job->property->full_address ?></td>
                <td><?php echo $visit->job->category->type ?></td>
                <td><?php echo $visit->job->job_title . ' ' . ($visit->job->job_type == JOB_TYPE_RECURRING? "(R)": "(O)") ?></td>
                <td><?php echo $visit->job->instruction ?></td>
                <td><?php 
                    $i = 0;
                    if($visit->crews->count()):
                    echo '<ul class="crews-list">';
                    foreach($visit->crews as $user):?>
                        <?php
                        echo '<li class="crew-item" data-toggle="tooltip" title="' . $user->first_name . ' ' . $user->last_name . '" style="color: white;background-color: ' . $user->system_color . '">' . substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1) . '</li>';
                        ?>
                    <?php 
                    endforeach;
                    echo '</ul>';
                    endif; ?>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>

    </table>

</body>
</html>
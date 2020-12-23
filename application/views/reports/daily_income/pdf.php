<!doctype html>
<html lang="en">
  <head>
    <title>Property Services</title>
    <style>
    @page { margin: 120px 40px; }
    * { font-family: "helvetica" !important; }
    header { position: fixed; top: -90px; left: 0px; right: 0px; height: 100px; }
    table{ collapse: collapse; font-size: 10px; }
    table td, table th{ border: 1px solid #000; padding: 5px; font-size: 12px; color: #111; }
    table th{ background-color: #eee; padding: 10px; text-transform: capitalize; font-size: 11px; }
    /* table tr:nth-child(even){ background-color: #eee; } */
    .head>div{ display: flex; justify-content: center; }
    .head>div>div{ flex: 1; text-align: center; }
    .head h3{ text-decoration: underline; margin-top: 5px; font-size: 16px; }
    </style>
  </head>
  <body>

    <header class="head">
        <div>
            <img src="<?php echo APPPATH . '../assets/images/logo.png'; ?>" alt="Logo" width="180">
            <div>
                <h3 align="center">Daily Income</h1>
            </div>
        </div>
    </header>

    <?php if(count($jobs)): ?>

    <table  cellspacing="0">
        <thead>
            <tr>
		        <th>Date</th>
                <th>Property Address</th>
                <th>Client Name</th>
                <th>Category Job</th>
                <th>Job Title</th>
                <th>Value</th>
            </tr>
        </thead>
        
        <tbody>
            <?php $total = 0; ?>
            <?php foreach($jobs as $job): ?>
            <tr>
                <td><?php echo local_date($job->visits->first()->date) ?></td>
                <td><?php echo $job->property->address ?></td>
                <td><?php echo $job->client->name ?></td>
                <td><?php echo $job->category->type ?></td>
                <td><?php echo $job->job_title ?></td>
                <td align=right>
                    $ <?php 
                        $sum = $job->visits->first()->items->sum('pivot.total');
                        $total += $sum;
                        echo number_format($sum, 2); 
                    ?>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan=5>Total</th>
                <th align=right>$ <?php echo number_format($total, 2); ?></th>
            </tr>
        </tfoot>

    </table>

    <?php else: ?>
        <h1 align=center>No Record Found!</h1>
    <?php endif; ?>

</body>
</html>
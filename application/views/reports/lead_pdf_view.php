<!doctype html>
<html lang="en">
  <head>
    <title>Leads</title>
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
    </style>
  </head>
  <body>

    <header class="head">
        <div>
            <img src="<?php echo APPPATH . '../assets/images/logo.png'; ?>" alt="Logo" width="180">
            <div>
                <h3 align="center">Leads</h1>
            </div>
        </div>
    </header>

    <table  cellspacing="0">
        <thead>
            <tr>
                <th>Name</th>
                <th>Address</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Lead by</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($leads as $lead): ?>
            <tr>
                <td><?php echo $lead->name ?></td>
                <td><?php echo $lead->address_1 ?></td>
                <td><?php echo $lead->email ?></td>
                <td><?php echo $lead->phone ?></td>
                <td><?php echo $lead->leadBy->full_name ?></td>
            </tr>
            <tr>
                <td colspan="5"><?php 
                foreach ($lead->clinetLogs as $log) {
                    echo $log->note . ' - ' . local_datetime($log->added_time) . '<br>';
                }
                // echo $lead->clinetLogs->implode('note', '<br>') 
                ?></td>
            </tr>
            <?php endforeach;?>
        </tbody>

    </table>

</body>
</html>
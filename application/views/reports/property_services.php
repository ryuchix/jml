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
                <h3 align="center">Properties Services</h1>
            </div>
        </div>
    </header>

    <table  cellspacing="0">
        <thead>
            <tr>
                <th>Client Name</th>
                <th>Properties Address</th>
                <th>Contact Name</th>
                <th>Services</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach($results as $result): ?>
            <tr>
                <td><?php echo $result->name ?></td>
                <td><?php echo $result->address ?></td>
                <td><?php echo $result->attention ?></td>
                <td><?php echo $result->services ?></td>
            </tr>
            <?php endforeach;?>
        </tbody>

    </table>

</body>
</html>
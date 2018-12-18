<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Date</th>
            <th>Odometer</th>
            <th>Cost</th>
            <th>Volume</th>
            <th>Cost per Litre</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($records as $row){ ?>
    <tr>
        <td><?php echo local_date($row->date); ?></td>
        <td><?php echo $row->odometer; ?></td>
        <td>$<?php echo $row->cost; ?></td>
        <td><?php echo $row->volume; ?>L</td>
        <td>$<?php echo ($row->volume>0)? number_format(($row->cost/$row->volume), 2):0.00; ?></td>
        <td>
          <div class="btn-group">
                <button data-toggle="dropdown" class="dropdown-toggle btn btn-icon-toggle btn-default ink-reaction">
                  <i class="fa fa-ellipsis-v "></i>
                </button>
                <ul class="dropdown-menu">
                    <li><?php echo anchor(site_url("vehicle_fuel/save/$row->vehicle_id/$row->id"),'<i class="fa fa-pencil"></i> Edit')?></li>
                </ul>
            </div>
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>
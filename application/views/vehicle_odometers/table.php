<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Date</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Odometer Start</th>
            <th>Odometer Finish</th>
            <th>Total Kilometer Travelled</th>
            <th>Driver</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($records as $row){ ?>
    <tr>
        <td><?php echo local_date($row->date); ?></td>
        <td><?php echo $row->start_time; ?></td>
        <td><?php echo $row->finish_time; ?></td>
        <td><?php echo $row->odometer_start; ?></td>
        <td><?php echo $row->odometer_finish; ?></td>
        <td><?php echo ($row->odometer_finish-$row->odometer_start); ?></td>
        <td><?php echo $row->driver; ?></td>
        <td>
          <div class="btn-group">
                <button data-toggle="dropdown" class="dropdown-toggle btn btn-icon-toggle btn-default ink-reaction">
                  <i class="fa fa-ellipsis-v "></i>
                </button>
                <ul class="dropdown-menu">
                    <li><?php echo anchor(site_url("odometer/save/$row->vehicle_id/$row->id"),'<i class="fa fa-pencil"></i> Edit')?></li>
                </ul>
            </div>
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>
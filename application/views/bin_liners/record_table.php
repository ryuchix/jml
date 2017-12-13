<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Date</th>
            <th>Property</th>
            <th>Client</th>
            <th>User/Staff</th>
            <th>Bin Liners</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($records as $row){ ?>
    <tr>
        <td><?php echo local_date($row->date); ?></td>
        <td><?php echo $row->address; ?></td>
        <td><?php echo $row->name; ?></td>
        <td><?php echo $row->user_name; ?></td>
        <td><?php echo implode('<br>', explode(',', $row->item_with_qty)); ?></td>
        <td>
          <div class="btn-group">
                <button data-toggle="dropdown" class="dropdown-toggle btn btn-icon-toggle btn-default ink-reaction">
                  <i class="fa fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><?php echo anchor(site_url($class_name.'/save/'.$row->id),'<i class="fa fa-pencil"></i> Edit')?></li>
                </ul>
            </div>
        </td>
    </tr>

    <?php } ?>

    </tbody>

</table>


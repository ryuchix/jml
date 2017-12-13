<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Equipment Type</th>
            <th>Consumable</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($records as $row){ ?>
    <tr>
        <td><?php echo implode('<br>', explode(',', $row->equipment_type_names)); ?></td>
        <td><?php echo implode('<br>', explode(',', $row->consumable_names)); ?></td>
        <td>
          <div class="btn-group">
                <button data-toggle="dropdown" class="dropdown-toggle btn btn-icon-toggle btn-default ink-reaction">
                  <i class="fa fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><?php echo anchor(site_url("$class_name/save/$row->property_id/$row->id"),'<i class="fa fa-pencil"></i> Edit')?></li>
                </ul>
            </div>
        </td>
    </tr>

    <?php } ?>

    </tbody>

</table>


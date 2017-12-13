<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Sold Price - Box</th>
            <th>Sold Price - Unit</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($records as $row){ ?>
    <tr>
        <td><?php echo $row->name; ?></td>
        <td><?php echo $row->soled_price_per_box; ?></td>
        <td><?php echo $row->soled_price_per_unit; ?></td>
        <td>
          <div class="btn-group">
                <button data-toggle="dropdown" class="dropdown-toggle btn btn-icon-toggle btn-default ink-reaction">
                  <i class="fa fa-ellipsis-v "></i>
                </button>
                <ul class="dropdown-menu">
                    <li><?php echo anchor(site_url("property/consumables/$property_id/save/$row->id"),'<i class="fa fa-pencil"></i> Edit')?></li>
                    <li><?php echo anchor(site_url("property/delete_property_consumable/$row->id"),'<i class="fa fa-lock"></i> Remove')?></li>
            </div>
        </td>
    </tr>

    <?php } ?>

    </tbody>

</table>


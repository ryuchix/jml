<table id="firstDateSort" class="table table-bordered table-striped">

    <thead>

        <tr>

            <th>Tagged Date.</th>

            <th>Cost</th>

            <th>Next Service Date</th>

            <th>Supplier</th>

            <th>Action</th>

        </tr>

    </thead>

    <tbody>

    <?php foreach($records as $row){ ?>

    <tr>

        <td><?php echo local_date($row->booked_date); ?></td>

        <td>$<?php echo $row->cost; ?></td>

        <td><?php echo $row->next_service_date? local_date($row->next_service_date):''; ?></td>

        <td><?php echo $row->name; ?></td>

        <td>

          <div class="btn-group">

                <button data-toggle="dropdown" class="dropdown-toggle btn btn-icon-toggle btn-default ink-reaction">
                    <i class="fa fa-ellipsis-v"></i>
                </button>

                <ul class="dropdown-menu">

                    <li><?php echo anchor(site_url("$class_name/save/$row->equipment_id/$row->id"),'<i class="fa fa-pencil"></i> Edit')?></li>

                </ul>

            </div>

        </td>
        
    </tr>

    <?php } ?>

    </tbody>

</table>


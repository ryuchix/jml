<!-- Contact Table -->

<table id="example2" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Contact Name</th>

            <th>Role</th>

            <th>Phone</th>

            <th>Email</th>

            <th>Primary</th>

            <th>Action</th>

        </tr>

    </thead>

    <tbody>

    <?php foreach($records as $row){ ?>
    <tr>

        <td><?php echo $row->contact_name . ' ' . $row->surname; ?></td>

        <td><?php echo $row->role; ?></td>

        <td><?php echo $row->phone; ?></td>

        <td><?php echo $row->email; ?></td>

        <td><?php echo $row->is_primary? '<i class="fa fa-check text-primary"></i>':''; ?></td>

        <td>

          <div class="btn-group">

                <button data-toggle="dropdown" class="dropdown-toggle btn btn-icon-toggle btn-default ink-reaction">

                  <i class="fa fa-ellipsis-v "></i>

                </button>

                <ul class="dropdown-menu">

                    <li><?php echo anchor(site_url("client/contact/".$row->id."/edit/"),'<i class="fa fa-pencil"></i> Edit')?></li>

                    <?php if ($row->active): ?>

                    <li><?php echo anchor(site_url("client/contact/".$row->id."/inactive/"),'<i class="fa fa-lock"></i> Disabled', 'class="disable"')?></li>

                    <?php else: ?>

                    <li><?php echo anchor(site_url("client/contact/".$row->id."/active/"),'<i class="fa fa-unlock"></i> Enable', 'class="reactivate"')?></li>

                    <?php endif; ?>
                
                </ul>

            </div>

        </td>

    </tr>

    <?php } ?>

    </tbody>

</table>
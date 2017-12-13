<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>User Role</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
    <?php foreach($records as $row){ ?>
    <?php if ($row->id == $modified_item_id): ?>    
    <tr class="animated tada" style="background: #fff; animation-fill-mode: backwards;">
    <?php else: ?>
        <tr>
    <?php endif; ?>
        <td><?php echo $row->first_name . ' ' . $row->last_name; ?></td>
        <td><?php echo $row->user_name; ?></td>
        <td><a href="mailto:<?php echo $row->email; ?>"><?php echo $row->email; ?></a></td>
        <td><?php echo get_user_role($row->user_role); ?></td>
        <td>
          <div class="btn-group">
                <button data-toggle="dropdown" class="dropdown-toggle btn btn-icon-toggle btn-default ink-reaction">
                  <i class="fa fa-ellipsis-v "></i>
                </button>
                <ul class="dropdown-menu">
                    <li><?php echo anchor(site_url('users/save/'.$row->id),'<i class="fa fa-pencil"></i> Edit')?></li>
                    <?php if ($row->active): ?>
                    <li><?php echo anchor(site_url("users/activation/$row->id/0"),'<i class="fa fa-lock"></i> Disabled', 'class="disable"')?></li>
                    <?php else: ?>
                    <li><?php echo anchor(site_url("users/activation/$row->id/1"),'<i class="fa fa-unlock"></i> Enable', '')?></li>
                    <?php endif; ?>
                    <li><?php echo anchor(site_url('users/files/'.$row->id),'<i class="fa fa-paperclip"></i> Files')?></li>
                    <li><?php echo anchor(site_url('users/view/'.$row->id),'<i class="fa fa-file-pdf-o"></i> PDF', 'target="_blank"')?></li>
                </ul>
            </div>
        </td>
    </tr>
    <?php } ?>

    </tbody>

</table>
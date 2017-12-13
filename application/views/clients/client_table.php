<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Client Name</th>
            <th>Address </th>
            <th>Phone </th>
            <th>Email</th>
            <th>Parent</th>
            <th>Parent Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($records as $row){ ?>
    <tr class="<?php echo ($row->id == $modified_item_id)?"animated tada\" style=\"animation-fill-mode: backwards;\"":""; ?>">
        <td><?php echo $row->name; ?></td>
        <td><?php echo $row->address_1 . ', ' . $row->address_suburb . ', ' . $row->address_post_code; ?></td>
        <td><?php echo $row->phone; ?></td>
        <td><?php echo $row->email; ?></td>
        <td><?php echo $row->is_parent? '<i class="fa fa-check text-primary"></i>':'-'; ?></td>
        <td><?php echo $row->parent_name; ?></td>
        <td>
          <div class="btn-group">
                <button data-toggle="dropdown" class="dropdown-toggle btn btn-icon-toggle btn-default ink-reaction">
                  <i class="fa fa-ellipsis-v "></i>
                </button>
                <ul class="dropdown-menu">
                    <li><?php echo anchor(site_url('client/save/'.$row->id),'<i class="fa fa-pencil"></i> Edit')?></li>
                    <?php if ($row->active): ?>
                    <li><?php echo anchor(site_url('client/activation/'.$row->id.'/0'),'<i class="fa fa-lock"></i> Disabled', 'class="disable"')?></li>
                    <?php else: ?>
                    <li><?php echo anchor(site_url('client/activation/'.$row->id.'/1'),'<i class="fa fa-unlock"></i> Enable', 'class="reactivate"')?></li>
                    <?php endif; ?>
                    <li><?php echo anchor(site_url('client/history/'.$row->id),'<i class="fa fa-file-text"></i> History')?></li>
                    <li><?php echo anchor(site_url('client/contact/'.$row->id.'/list/'),'<i class="fa fa-newspaper-o"></i> Contacts')?></li>
                    <li><?php echo anchor(site_url("client/properties/$row->id/?client=$row->name"),'<i class="fa fa-building"></i> Properties', 'class=""')?></li>
                    <li><?php echo anchor(site_url('client/service/'.$row->id.'/list'),'<i class="fa fa-file-text"></i> Services')?></li>
                    <li><?php echo anchor(site_url('client/map/'.$row->id),'<i class="fa fa-map-marker"></i> Map', ' data-remote="false" data-toggle="modal" data-target="#myModal"')?></li>
                    <li><?php echo anchor(site_url('client/notes/'.$row->id),'<i class="fa fa-sticky-note-o"></i> Notes')?></li>
                    <li><?php echo anchor(site_url('client/files/'.$row->id),'<i class="fa fa-paperclip"></i> Files')?></li>
                </ul>
            </div>
        </td>
    </tr>

    <?php } ?>

    </tbody>

</table>


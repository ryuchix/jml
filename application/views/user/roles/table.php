<table id="example1" class="table table-bordered table-striped">

    <thead>

        <tr>

            <th>Role Name</th>

            <th>Description</th>

            <th>Action</th>

        </tr>

    </thead>

    <tbody>

        <?php foreach($records as $row){ ?>

        <tr>

            <td><?php echo $row->name; ?></td>

            <td><?php echo $row->description; ?></td>

            <td>

                <div class="btn-group">

                    <button data-toggle="dropdown" class="dropdown-toggle btn btn-icon-toggle btn-default ink-reaction">
                        <i class="fa fa-ellipsis-v "></i>
                    </button>

                    <ul class="dropdown-menu">

                        <?php if ($controller->hasAccess('edit-role')): ?>
                            <li><?php echo anchor(site_url('roles/save/'.$row->id),'<i class="fa fa-pencil"></i> Edit')?></li>
                        <?php endif ?>
                        
                        <?php if ($controller->hasAccess('edit-role')): ?>
                            <li><?php echo anchor(site_url('roles/show_permissions/'.$row->id),'<i class="fa fa-key"></i> View Permissions', ' data-remote="false" data-toggle="modal" data-target="#permissionsModel" class=""')?></li>
                        <?php endif ?>
                    
                    </ul>

                </div>

            </td>

        </tr>

        <?php } ?>

    </tbody>

</table>
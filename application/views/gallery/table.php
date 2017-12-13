<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Category</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($records as $row){ ?>

    <tr>
        <td><?php echo $row->name; ?></td>
        <td><?php echo $row->type; ?></td>
        <td><?php echo $row->description; ?></td>
        <td>
          <div class="btn-group">
                <button data-toggle="dropdown" class="dropdown-toggle btn btn-icon-toggle btn-default ink-reaction">
                  <i class="fa fa-ellipsis-v "></i>
                </button>
                <ul class="dropdown-menu">
                    <li><?php echo anchor(site_url("gallery/edit/$row->id"),'<i class="fa fa-pencil"></i> Edit Gallery')?></li>
                    <li><?php echo anchor(site_url("gallery/append_gallery/$row->id"),'<i class="fa fa-plus"></i> Add Images')?></li>
                    <li><?php echo anchor(site_url("gallery/gallery_description/$row->id"),'<i class="fa fa-file-text"></i> Add Description'); ?></li>
                    <li><?php echo anchor(site_url("gallery/gallery_slider/$row->id"),'<i class="fa fa-sliders"></i> View Gallery', ' data-remote="false" data-toggle="modal" data-target="#photoModel" class=""')?></li>
                    <li><?php echo anchor(site_url("gallery/delete_gallery/$row->id"),'<i class="fa fa-trash"></i> Delete', 'class="delete"')?></li>
                </ul>
            </div>
        </td>
    </tr>

    <?php } ?>

    </tbody>

</table>

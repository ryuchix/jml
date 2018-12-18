<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Issue No.</th>
            <th>Title</th>
            <th>Client</th>
            <th>Property</th>
            <th>Status</th>
            <th>Assigned</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($records as $row){ ?>
    <tr">
        <td><?php echo $row->id; ?></td>
        <td><?php echo $row->title; ?></td>
        <td><?php echo $row->client; ?></td>
        <td><?php echo $row->property; ?></td>
        <td><?php echo get_status((int)$row->status); ?></td>
        <td><?php echo $row->assigned; ?></td>
        <td>
          <div class="btn-group">
                <button data-toggle="dropdown" class="dropdown-toggle btn btn-icon-toggle btn-default ink-reaction">
                  <i class="fa fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu">
                    
                    <?php if ($controller->hasAccess('edit-complaint')): ?>
                    <li><?php echo anchor(site_url('complaints/save/'.$row->id),'<i class="fa fa-pencil"></i> Edit')?></li>
                    <?php endif ?>

                    <?php if ($controller->hasAccess('view-complaint-history')): ?>
                    <li><?php echo anchor(site_url('complaints/history/'.$row->id),'<i class="fa fa-file-text"></i> History')?></li>
                    <?php endif ?>
                    
                    <?php if ($controller->hasAccess('')): ?>
                        
                    <?php endif ?>
                    <li><?php echo anchor(site_url('complaints/get_print/'.$row->id),'<i class="fa fa-file-pdf-o"></i> Print','target="_blank"')?></li>
                    <li><?php echo anchor(site_url('complaints/files/'.$row->id),'<i class="fa fa-paperclip"></i> Files')?></li>
                    <li><?php echo anchor(site_url("gallery/index/complaints/$row->id/"),'<i class="fa fa-camera"></i> Gallery')?></li>
                </ul>
            </div>
        </td>
    </tr>

    <?php } ?>

    </tbody>

</table>


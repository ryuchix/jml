<table id="example1" class="table table-bordered table-striped">
    
    <thead>
    
        <tr>
    
            <th>Date</th>
    
            <th>Balance</th>
    
            <th>Notes</th>
    
            <th>Action</th>
    
        </tr>
    
    </thead>
    
    <tbody>
    
    <?php foreach($records as $row){ ?>
    
    <tr>
    
        <td><?php echo local_date($row->date); ?></td>
    
        <td><?php echo $row->balance; ?></td>
    
        <td><?php echo $row->notes; ?></td>
    
        <td>
    
            <div class="btn-group">
    
                <button data-toggle="dropdown" class="dropdown-toggle btn btn-icon-toggle btn-default ink-reaction">
                  <i class="fa fa-ellipsis-v"></i>
                </button>
    
                <ul class="dropdown-menu">
    
                    <li><?php echo anchor(site_url("daily_balances/save/$row->id"),'<i class="fa fa-pencil"></i> Edit')?></li>
    
                </ul>
    
            </div>
    
        </td>
    
    </tr>

    <?php } ?>

    </tbody>

</table>


<table  id="firstDateSort" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Title</th>
            <th>Visit Date</th>
            <th>Assignee</th>
            <th>Amount</th>
            <th>Options</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($records as $row){ ?>
    <tr>
        <td>
            <?php echo $row->title ?? $record->job_title ?>
        </td>
        <td>
            <label class="checkbox-inline">
            <?php if ($row->completed): ?>
                <input type="checkbox" checked disabled="disabled">
                <?php echo local_date($row->date); ?>
            <?php else: ?>
                <form action="<?php echo site_url('jobs/close_visit'); ?>" method="post">
                    <input type="checkbox" name="visit_id" value="<?php echo $row->id; ?>" onchange="">
                    <?php echo local_date($row->date); ?>
                </form>
            <?php endif ?>
            </label>
        </td>
        <td>
            <?php echo $row->assignee; ?>
        </td>
        <td>
            $<?php echo $row->amount; ?>
        </td>
        <td>
            <?php if (!$row->completed): ?>
            <a href="#" data-toggle='modal' class="editVisit" data-target="#editVisitModal" data-vpk="<?php echo $row->id; ?>">
                <i class="fa fa-edit"></i>
                Edit
            </a>
            <?php endif ?>
        </td>
    </tr>
    <?php } ?>

    </tbody>
</table>

<div class="modal fade" id="editVisitModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Visit</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="VisitTitleInput">Visit Title</label>
                            <input type="text" class="form-control" name="title" id="VisitTitleInput" placeholder="Visit Title">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="VisitDateInput">Date</label>
                            <input type="text" class="form-control" name="date" id="VisitDateInput" placeholder="Date">
                        </div>
                    </div>
                </div>
                
                <!-- Note: This div will be used by js to append crew users. -->
                <div id="users" class="row">
                    <?php foreach(User::all() as $user): ?>
                        <div class="col-md-4">
                            <label class="checkbox-inline crew-users">
                                <input type="checkbox" name="crew[]" checked value="<?php echo $user->id?>">
                                <?php echo $user->full_name; ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="row" style="margin-top: 20px;">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered" id="lineItemTable">
                            <thead>
                                <tr>
                                    <th>Service/Description</th>
                                    <th>Qty</th>
                                    <th>Unit Cost</th>
                                    <th>
                                        Total
                                        <span style="float: right;">
                                            <a href="#" id="addItem" class="btn btn-primary btn-sm">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                            <a href="#" id="deleteItem" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </span>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>
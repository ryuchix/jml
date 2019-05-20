<?php if ($controller->hasAccess('view-lead-table')): ?>

<div class="row">
            
    <div class="col-sm-12">
        
        <div class="box box-info">

            <div class="box-header with-border">

              	<h3 class="box-title">Leads</h3>

              	<div class="box-tools pull-right">

                	<button type="button" class="btn btn-box-tool" data-widget="collapse">

                    	<i class="fa fa-minus"></i>

                	</button>

                	<button type="button" class="btn btn-box-tool" data-widget="remove">

                    	<i class="fa fa-times"></i>

                	</button>

              </div>

            </div>

            <?php 
            
                $leads = Client::with(['leadType' => function($q){
                }, 'leadBy' => function($q){
                    $q->select('first_name', 'last_name', 'id');
                }, 'clinetLogs'])->where('is_lead', 1)->where('active', 1)->orderBy('id', 'desc')->get();

            ?>

            <div class="box-body chart-responsive table-responsive fleet-table">
				
				<table class="table table-bordered table-striped">
					
					<thead>
							
						<th>Client Name</th>

						<th>Address</th>

						<th>Suburb</th>

						<th>Contact name</th>

						<th>Phone</th>

						<th>Email</th>

						<th>Lead Date</th>

						<th>Lead Type</th>

						<th>Lead User</th>

						<th>Action</th>

					</thead>

					<tbody>
						
						<?php foreach ($leads as $lead): ?>
							
							<tr>
								<td><?php echo $lead->name; ?></td>
								
								<td><?php echo ($lead->address_1); ?></td>

								<td><?php echo ($lead->address_suburb); ?></td>
								
								<td><?php echo $lead->attention; ?></td>

								<td><?php echo ($lead->phone); ?></td>
								
								<td><?php echo ($lead->email); ?></td>
								
								<td><?php echo local_date($lead->lead_date); ?></td>
								
								<td><?php echo ($lead->leadType->type); ?></td>
								
								<td><?php echo $lead->leadBy->full_name; ?></td>

								<td>
                                    <a href="<?php echo site_url("client/save/$lead->id"); ?>">Edit</a> | 
                                    <a href="<?php echo site_url("client/change_type/$lead->id/prospect"); ?>">Prospect</a> | 
                                    <a href="<?php echo site_url("client/change_type/$lead->id/client"); ?>">Client</a> |
									<span data-toggle="tooltip" data-html="true" data-placement="top" title="<?= $lead->clinetLogs->implode('note', '<br>'); ?>">
										<a data-remote="false" data-href="<?php echo site_url( "clients/$lead->id/marketing/save_note" ); ?>" data-toggle="modal" data-target="#leadModal">Marketing</a>
									</span>
                                </td>

							</tr>

						<?php endforeach ?>

					</tbody>

				</table>
			
            </div>
            <!-- /.box-body -->

        </div>
        <!-- /.box -->

    </div>
    <!-- .col-sm-12 -->

</div>
<!-- .row -->

<!-- Modal -->
<div class="modal fade" id="leadModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog" role="document">
        <form role="form" id="form" method="post" action="#" enctype="multipart/form-data">
	    
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        	<h4 class="modal-title" id="myModalLabel">New Notes & Attachments</h4>
	      	</div>
	      	<div class="modal-body">
				
				<input type="hidden" name="job_id" value="">
				<input type="hidden" name="redirect" value="/">
                <div class="form-group">
                    <label for="image">Choose Files</label>
                    <input type="file" class="form-control" id="imageFile" name="upl_files[]" multiple>
                </div>

                <div class="form-group">
                    <label>Notes</label>
                    <textarea class="form-control" rows="3" name="notes" placeholder="Notes..."></textarea>
                </div>

	      	</div>
	      	<div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	    	    <button type="submit" name="submit" class="btn btn-primary">Save</button>
	      	</div>
    	</div>
    	</form>
  	</div>
</div>

<?php endif; ?>
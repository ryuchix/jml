<!-- row -->
    <div class="row">
        <div class="col-md-12">
          	<!-- The time line -->
          	<ul class="timeline">
            	<!-- timeline time label -->
            	<li class="time-label">
                  	<span class="bg-red">
                    <!-- Button trigger modal -->
					<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#noteModal">
					  New Note
					</button>
                  	</span>
            	</li>
	            <!-- /.timeline-label -->
	            <!-- timeline item -->
	            <?php foreach ($notes as $note): ?>
	            <li>
	              	<i class="fa fa-envelope bg-blue"></i>

	              	<div class="timeline-item">
	                	<span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

	                	<h3 class="timeline-header"><a href="#"><?php echo $note['user']; ?></a></h3>

	                	<div class="timeline-body">
		                  	
		                  	<div class="note-text"><?php echo $note['note']; ?></div>
		                  	
		                  	<?php if (!empty($note['files'])): ?>
							<hr>
                            <div class="list-group">
                            <?php foreach ($note['files'] as $id => $filename): ?>
                                <?php echo anchor(site_url( "uploads/job_attachments/".$filename ), $filename . '<span data-file_id="'.$id.'" class="badge alert-danger">X</span>', 'class="list-group-item" target="_blank"'); ?>
                            <?php endforeach ?>
                            </div>
                            <?php endif ?>
		                </div>
		                <div class="timeline-footer">
		                  	<a class="btn btn-primary btn-xs edit_note" data-note-id="<?php echo $note['note_id']; ?>" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></a>

		                  	<a class="btn btn-danger btn-xs delete_note" data-note-id="<?php echo $note['note_id']; ?>"><i class="fa fa-trash"></i></a>
		                </div>
	              	</div>
	            </li>
	            <?php endforeach ?>
	            <!-- END timeline item -->
          </ul>
        </div>
        <!-- /.col -->
    </div>
<!-- /.row -->

<!-- Modal -->
<div class="modal fade" id="noteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog" role="document">
        <form role="form" id="form" method="post" action="<?php echo site_url( $class_name."/save_note/".$record->id ); ?>" enctype="multipart/form-data">
	    
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        	<h4 class="modal-title" id="myModalLabel">New Notes & Attachments</h4>
	      	</div>
	      	<div class="modal-body">
				
				<input type="hidden" name="job_id" value="<?php echo $record->id; ?>">
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

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog" role="document">
        <form role="form" id="form" method="post" action="<?php echo site_url( "$class_name/save_note/$record->id/0" ); ?>" enctype="multipart/form-data">
	    
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        	<h4 class="modal-title" id="myModalLabel">Edit Notes & Attachments</h4>
	      	</div>
	      	<div class="modal-body">
				
				<input type="hidden" name="job_id" value="<?php echo $record->id; ?>">
                <div class="form-group">
                    <label for="image">Choose Files</label>
                    <input type="file" class="form-control" id="imageFile" name="upl_files[]" multiple>
                </div>

                <div class="form-group">
                    <label>Notes</label>
                    <textarea class="form-control" id="editNote" rows="3" name="notes" placeholder="Notes..."></textarea>
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
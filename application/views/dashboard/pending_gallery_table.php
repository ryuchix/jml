<?php if ($controller->hasAccess('view-pending-gallery')): ?>

<div class="row">
            
    <div class="col-sm-12">
        
        <div class="box box-info">

            <div class="box-header with-border">

              	<h3 class="box-title">Pending Gallery</h3>

              	<div class="box-tools pull-right">

                	<button type="button" class="btn btn-box-tool" data-widget="collapse">

                    	<i class="fa fa-minus"></i>

                	</button>

                	<button type="button" class="btn btn-box-tool" data-widget="remove">

                    	<i class="fa fa-times"></i>

                	</button>

              </div>

            </div>

            <div class="box-body chart-responsive table-responsive pendign-gallery">

			<?php if(empty($pending_galleries)): ?>
				<p align="center">No pending gallery</p>
			<?php else: ?>
				<table class="table table-bordered table-striped">
					
					<thead>
							
						<th>Client</th>

						<th>Property</th>

						<th>Gallery Type</th>

						<th>Created By</th>

						<th>Created At</th>

						<th>Action</th>

					</thead>

					<tbody>
						
						<?php foreach ($pending_galleries as $gallery): ?>
							<tr>
								<td>
									<?php echo $gallery->name; ?>
								</td>
								<td>
									<?php echo $gallery->address ?>
								</td>
								<td>
									<?php echo $gallery->type ?>
								</td>
								<td>
									<?php echo $gallery->user ?>
								</td>
								<td>
									<?php echo local_datetime($gallery->added_time) ?>
								</td>
								<td>
									<a href="<?php echo site_url("gallery/gallery_slider/$gallery->id") ?>" data-remote="false" data-toggle="modal" data-target="#photoModel" class="">View</a> | 
									<a href="#" class="propcess-gallery" data-id="<?php echo $gallery->id; ?>">Proccess</a>
								</td>

							</tr>

						<?php endforeach ?>

					</tbody>

				</table>
			<?php endif; ?>
            </div>
            <!-- /.box-body -->

        </div>
        <!-- /.box -->

    </div>
    <!-- .col-sm-12 -->

</div>
<!-- .row -->

<!-- Default bootstrap modal example -->
<div class="modal fade" id="photoModel" tabindex="-1" role="dialog" aria-labelledby="photoModelLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="photoModelLabel">Modal title</h4>
            </div>
            <div class="modal-body">
            
            </div>
            <div class="modal-footer">
                <button type="button" id="rotate" class="btn btn-danger">
					<i class="fa fa-undo"></i>
				</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<?php endif; ?>



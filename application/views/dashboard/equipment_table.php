<?php if ($controller->hasAccess('view-equipment-table')): ?>

<style>
	.equipment-table tr>td:first-child>a{ display: block; }
</style>

<div class="row">

    <div class="col-sm-12">

        <div class="box box-info">

            <div class="box-header with-border">

              	<h3 class="box-title">Upcoming Equipment Services</h3>

              	<div class="box-tools pull-right">

                	<button type="button" class="btn btn-box-tool" data-widget="collapse">
                    	<i class="fa fa-minus"></i>
                	</button>

                	<button type="button" class="btn btn-box-tool" data-widget="remove">
                    	<i class="fa fa-times"></i>
                	</button>

              	</div>

            </div>

            <div class="box-body chart-responsive table-responsive equipment-table equipment-table">
				
				<table class="table table-bordered table-striped">
					
					<thead>
							
						<th>JML No.</th>

						<th>Reference</th>

						<th>Type</th>

						<th>Tagged Date</th>

						<th>Next Service Date</th>

						<th>Assigned To</th>

					</thead>

					<tbody>
						
						<?php foreach ($equipments as $equipment): ?>
							
							<tr>
								
								<td>
									<a href="<?php echo site_url( "equipments/save/$equipment->id" ); ?>" class="image-preview" data-url='<?php echo base_url("uploads/equipments/$equipment->image"); ?>'>
										JML-<?php echo $equipment->id ?>
									</a>
								</td>
								
								<td>
									<?php echo $equipment->name; ?>
								</td>
								
								<td>
									<?php echo $equipment->type; ?>
								</td>
								
								<td>
									<?php echo local_date($equipment->booked_date); ?>
								</td>
								
								<td class="<?php echo $equipment->get_next_service_highlighted_class(); ?>">
									<?php echo local_date($equipment->next_service_date); ?>
								</td>

								<td><?php echo $equipment->assigned_user; ?></td>

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

<?php endif ?>
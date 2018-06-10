<?php if ($controller->hasAccess('view-vehicle-table')): ?>

<div class="row">
            
    <div class="col-sm-12">
        
        <div class="box box-info">

            <div class="box-header with-border">

              	<h3 class="box-title">Fleet of Vehicles</h3>

              	<div class="box-tools pull-right">

                	<button type="button" class="btn btn-box-tool" data-widget="collapse">

                    	<i class="fa fa-minus"></i>

                	</button>

                	<button type="button" class="btn btn-box-tool" data-widget="remove">

                    	<i class="fa fa-times"></i>

                	</button>

              </div>

            </div>

            <div class="box-body chart-responsive table-responsive">
				
				<table class="table table-bordered">
					
					<thead>
							
						<th>Rego</th>

						<th>Rego Due Date</th>

						<th>Rego Expires</th>

						<th>Next Service Date</th>

						<th>Next Service Odo</th>

						<th>Odometer Finish</th>

						<th>Insurance Expires</th>

					</thead>

					<tbody>
						
						<?php foreach ($regoes as $rego): ?>
							
							<tr>
								
								<td>

									<a href="<?php echo site_url( "vehicle/save/$rego->id" ); ?>" class="image-preview" data-url='<?php echo base_url("uploads/vehicles/$rego->image") ?>'>

										<?php echo $rego->license_plate; ?>

									</a>

								</td>
								
								<td class="<?php echo $rego->get_due_date_highlighted_class(); ?>">

									<?php echo local_date($rego->due_date); ?>

								</td>
								
								<td class="<?php echo $rego->get_expiry_date_highlighted_class(); ?>">

									<?php echo local_date($rego->expiry_date); ?>

								</td>
								
								<td class="<?php echo $rego->get_next_service_date_highlighted_class(); ?>">

									<?php echo local_date($rego->next_service_date); ?>

								</td>
								
								<td class="<?php echo $rego->get_next_odo_highlighted_class(); ?>">

									<?php echo $rego->get_service_odo(); ?>

								</td>

								<td>

									<?php echo $rego->get_odometer_finish(); ?>
										
								</td>
										
								<td class="<?php echo $rego->get_insurance_expiry_date_hightlighted_class(); ?>">

									<?php echo local_date($rego->insurance_expiry_date); ?>
									
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

<?php endif; ?>
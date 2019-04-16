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
                }])->where('is_lead', 1)->orderBy('id', 'desc')->get();

                // dd($leads->toArray());
            ?>

            <div class="box-body chart-responsive table-responsive fleet-table">
				
				<table class="table table-bordered table-striped">
					
					<thead>
							
						<th>Client Name</th>

						<th>Address</th>

						<th>Suburb</th>

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

								<td><?php echo ($lead->phone); ?></td>
								
								<td><?php echo ($lead->email); ?></td>
								
								<td><?php echo local_date($lead->lead_date); ?></td>
								
								<td><?php echo ($lead->leadType->type); ?></td>
								
								<td><?php echo $lead->leadBy->full_name; ?></td>

								<td>
                                    <a href="<?php echo site_url("client/save/$lead->id"); ?>">Edit</a> | 
                                    <a href="<?php echo site_url("client/change_type/$lead->id/prospect"); ?>">Prospect</a> | 
                                    <a href="<?php echo site_url("client/change_type/$lead->id/client"); ?>">Client</a>
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
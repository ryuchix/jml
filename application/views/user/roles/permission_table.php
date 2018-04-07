<table class="table table-bordered table-striped">
	
	<thead>
		
		<tr>
			<td>Module</td>
			<td>Permissions</td>
		</tr>

	</thead>

	<tbody>

		<?php if (strlen(form_error('permissions[]'))): ?>
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<strong>Error</strong> <?php echo form_error('permissions[]'); ?>
			</div>
		<?php endif ?>

		<?php foreach ($permissions as $module => $perms): ?>
			<tr>
				<td><?php echo $module ?></td>
				<td>
					<?php foreach ($perms as $perm): ?>
						
					<div class="form-group">
				      	<div class="checkbox">
				        	<label>
				          		<input type="checkbox" name="permissions[]" 
								<?php echo in_array($perm->id, $selected_permissions)? 'checked': ''; ?>
				          		value="<?php echo $perm->id ?>"> 
				          		<?php echo $perm->label; ?>
				        	</label>
				      	</div>
				    </div>
						
					<?php endforeach ?>
				</td>
			</tr>
		<?php endforeach ?>

	</tbody>

</table>
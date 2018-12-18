<table class="table table-bordered table-striped">
	
	<thead>
		<tr>
			<th>Name</th>
			<th>Surname</th>
			<th>Role</th>
			<th>Email</th>
			<th>Phone</th>
		</tr>
	</thead>

	<tbody>
		<?php foreach ($contacts as $contact): ?>
		<tr>
			<td><?php echo $contact->contact_name ?></td>
			<td><?php echo $contact->surname ?></td>
			<td><?php echo $contact->role ?></td>
			<td><?php echo $contact->email ?></td>
			<td><?php echo $contact->phone ?></td>
		</tr>
		<?php endforeach ?>
	</tbody>

</table>
<table class="table">
	<thead>
		<tr>
			<td><?php echo l('name') ?></td>
			<td><?php echo l('email') ?></td>
			<td><?php echo l('profession') ?></td>
			<td><?php echo l('type') ?></td>
		</tr>
	</thead>
	<tbody>
<?php foreach($records as $r): ?>
	<tr>
		<td>
			<?php
				if(isset($r['website']) && $r['website']){echo '<a href="'.$r['website'].'" target="_blank">';};
				if(isset($r['name_first'])){echo $r['name_first'];};
				if(isset($r['name_last'])){echo ' '.$r['name_last'];};
				if(isset($r['company'])){echo $r['company'];};
				if(isset($r['website']) && $r['website']){echo '</a>';};
			?>
		</td>
		<td>
			<?php
				echo str_replace(array('@','.'), array(' AT ',' DOT '), $r['email']);
			?>
		</td>
		<td>
			<?php
				if(isset($r['profession'])){echo $r['profession'];};
				if(isset($r['position'])){echo ' '.$r['position'];};
			?>
		</td>
		<td>
			<?php echo $r['type'] ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
</table>
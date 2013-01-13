<ul class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index.php/admin/">Admin Home</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament/view/<?php echo $tournament ?>">Tournament <?php echo $tournament ?></a> <span class="divider">/</span></li>
  <li class="active">Events</li>
</ul>
<h3>Events</h3>
<table class="table">
	<thead>
		<tr>
			<th>Name</th>
			<th>Sport</th>
			<th>Start date</th>
			<th>End date</th>
			<th>Reg. Start</th>
			<th>Reg. End</th>
			<th>Max Entries</th>
			<th>Min Entries</th>
			<th>Participents registered</th>
			<th></th>
		</tr> 
	</thead>
	<tbody>
	<?php
	foreach($events as $current )
	{
		echo "<tr>";
		$url = base_url() . "index.php/admin/event/edit/".$current['eventId']."/";
		echo "<td><a href=\"{$url}\">{$current['name']}</a></td>";
		echo "<td>" . $sports[$current['sportId']-1]['sportName'] . "</td>";
		echo "<td>{$current['start']}</td>";
		echo "<td>{$current['end']}</td>";
		echo "<td>{$current['regStart']}</td>";
		echo "<td>{$current['regEnd']}</td>";
		echo "<td>{$current['maxEntries']}</td>";
		echo "<td>{$current['minEntries']}</td>";
		echo "<td>Coming soon</td>";
		$url = base_url() . "index.php/admin/event/edit/".$current['eventId']."/";
		echo "<td><a href=\"{$url}\">Edit</a></td>";
		echo "</tr>";
		
	}
	?>
	</tbody>
	<tfoot>
		<tr>
		<td colspan="6"><a href="<?php echo base_url() . "index.php/admin/event/add"; ?>">Add new event</a></td>
	</tfoot>
</table>
<?php echo $links; ?>
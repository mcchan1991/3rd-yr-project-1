<ul class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index.php/admin/">Admin Home</a> <span class="divider">/</span></li>
  <li class="active">Tournaments</li>
</ul>
<h3>Tournaments</h3>
<table class="table">
	<thead>
		<tr>
			<th>Name</th>
			<th>Start date</th>
			<th>End Date</th>
			<th>No. tickets/day</th>
			<th>No. events</th>
			<th>Participents registered</th>
		</tr> 
	</thead>
	<tfoot>
		<tr>
			<td colspan="6">
			<a href="<?php echo base_url(); ?>index.php/admin/tournament/add">Add new tournament</a>
			</td>
		</tr>
	</tfoot>
	<tbody>
<?php
foreach($tournaments as $current )
{
	echo "<tr>";
	$url = base_url() . "index.php/admin/tournament/view/".$current['tournamentId']."/";
	echo "<td><a href=\"{$url}\">{$current['name']}</a></td>";
	echo "<td>{$current['start']}</td>";
	echo "<td>{$current['end']}</td>";
	echo "<td>{$current['noTickets']}</td>";
	echo "<td>{$eventCount[$current['tournamentId']]}</td>";
	echo "<td>To come...</td>";	
	echo "</tr>";
	
	
}
?>
	</tbody>
</table>
<?php echo $links; ?>
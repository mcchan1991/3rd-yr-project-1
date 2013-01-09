<table>
<tr>
<th>Name</th>
<th>Start date</th>
<th>End Date</th>
<th>No. tickets/day</th>
<th>No. events</th>
<th>Participents registered</th>
</tr> 
<?php
foreach($tournaments as $current )
{
	echo "<tr>";
	$url = base_url() . "index.php/admin/tournament/view/".$current['tournamentId']."/";
	echo "<td><a href=\"{$url}\">{$current['name']}</a></td>";
	echo "<td>{$current['start']}</td>";
	echo "<td>{$current['end']}</td>";
	echo "<td>{$current['noTickets']}</td>";
	echo "<td>To come...</td>";
	echo "<td>To come...</td>";	
	echo "</tr>";
	
}
?>
<tr>
<td colspan="6">
<?php echo $links; ?>
</td>
</tr>
</table>
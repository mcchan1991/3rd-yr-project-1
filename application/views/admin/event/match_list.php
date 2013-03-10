<ul class="breadcrumb">
   <li><a href="<?php echo base_url(); ?>index.php/admin/">Admin Home</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament">Tournaments</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament/view/<?php echo $tournament['tournamentId'] ?>"><?php echo $tournament['name'] ?></a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament/viewEvents/<?php echo $event['tournamentId']; ?>">Events</a> <span class="divider">/</span></li>
  <li class="active">Event: <?php echo $event['name']; ?></li>
</ul>
<h3>Matches</h3>
<table class="table">
	<thead>
		<tr>
			<th>Match</th>
			<th>Status</th>
			<th>Goals</th>
			<th>Location</th>
			<th>Date</th>
			<th>Time</th>
			<th>Umpire</th>
			<th>Update</th>
		</tr> 
	</thead>
	<tbody>
<?php
foreach($matches as $current )
{
	echo "<tr>";
	echo "<td>{$current['team1Name']} vs {$current['team2Name']}</td>";
	echo "<td>{$current['status']}</td>";
	echo "<td>{$current['team1Goals']} - {$current['team2Goals']}</td>";
	echo "<td>{$current['locationName']}</td>";	
	echo "<td>{$current['date']}</td>";	
	echo "<td>{$current['time']}</td>";	
	echo "<td>{$current['umpireName']}</td>";	
	$url = base_url() . "index.php/admin/matches/edit/".$current['matchId']."/";
	echo "<td><a href=\"{$url}\">Update</a></td>";
	echo "</tr>";
}
?>
	</tbody>
</table>
<?php echo $links; ?>
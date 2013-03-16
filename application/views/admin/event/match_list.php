<?php
if ($allowAutomatic == 1)
{ ?>	
	<script>
	$(document).ready(function() {
	     $("#disabled").attr('disabled','disabled');
	 });
	</script>
<?php } ?>

<ul class="breadcrumb">
   <li><a href="<?php echo base_url(); ?>index.php/admin/">Admin Home</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament">Tournaments</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament/view/<?php echo $tournament['tournamentId'] ?>"><?php echo $tournament['name'] ?></a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament/viewEvents/<?php echo $event['tournamentId']; ?>">Events</a> <span class="divider">/</span></li>
  <li class="active">Event: <?php echo $event['name']; ?></li>
</ul>
<h3>Matches</h3>
<?php 

if ($status == 1)
{
	echo "<div class=\"alert alert-success\">";
	echo "Scheduling completed successfully.";
	echo "</div>";
}
else if ($status == 2)
{
	echo "<div class=\"alert alert-error\">";
	echo "Scheduling failed. There are too few teams registered for the tournament to make a schedule.";
	echo "</div>";
}
else if ($status == 3)
{
	echo "<div class=\"alert\">";
	echo "Scheduling incomplete. Please ensure that umpire and location availability is sufficient for the event. Then re-schedule";
	echo "</div>";
}

?>
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
if (count($matches) == 0)
{
	echo "<tr>";
	echo "<td colspan=\"8\"> No matches scheduled. Schedule the event below</td>";
	echo "</tr>";
}

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
	echo "<td><a href=\"{$url}\">Add result</a></td>";
	echo "</tr>";
}
?>
	</tbody>
</table>
<?php echo $links; ?>

<?php 
$attributes = array('class' => 'form-vertical', 'name' => 'schedule');
$labelAttributes = array(
    'class' => 'control-label',
);
$btnAttributes = array(
    'class' => 'btn',
	'style' => 'margin-top: 15px; margin-right:10px',
	'name' => 'submit'
);

$btnAttributesDisabled = array(
    'class' => 'btn',
	'style' => 'margin-top: 15px; margin-right:10px',
	'name' => 'submit',
	'id'   => 'disabled'
);

if (count($matches) == 0 || $allowAutomatic == 0) 
{
	$scheduleText = "Automatic schedule";
}
else
{
	$scheduleText = "Automatic reschedule";
}

echo "<div class=\"control-group\">";
echo "<div class=\"controls\">";
echo form_open("admin/event/matchButtonHandler/{$event['eventId']}", $attributes);
if ($allowAutomatic == 1)
{
	echo form_submit($btnAttributes, $scheduleText, 'submit');
}
else
{
	echo form_submit($btnAttributesDisabled, $scheduleText, 'submit');
}
echo form_submit($btnAttributes, 'Edit schedule', 'submit');
echo '</div>';
echo '</div>';
echo form_close();

if (count($matches) > 0 && $allowAutomatic == 1)
{
	echo '<span class="label label-important">NOTE: Automatic rescheduling removes all previously scheduled matches</span>';
}

?>
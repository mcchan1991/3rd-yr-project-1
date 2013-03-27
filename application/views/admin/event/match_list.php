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
   <li><a href="<?php echo base_url(); ?>index.php/<?php if ($public == false) { echo "admin/"; }?>/"> Home</a> <span class="divider">/</span></li>
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
			<?php if ($public == false) {?><th>Status</th> <?php } ?>
			<th>Goals</th>
			<th>Location</th>
			<th>Date</th>
			<th>Time</th>
			<th>Umpire</th>
			<?php if ($public == false) {?> <th>Update</th><?php } ?>
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

$i=0;
foreach($matches as $current )
{

	$url = base_url() . "index.php/match/view/" . $current['matchId'];
	echo "<tr data-provides=\"rowlink\">";
	echo "<td>{$current['team1Name']} vs {$current['team2Name']}</td>";
	if ($public == false) { echo "<td>{$current['status']}</td>"; }
	if ($current['status'] != "finished")
	{
		echo "<td></td>";
	}
	else
	{
		foreach($Score[$i] as $item)
		{
		echo "<td><a href=\"{$url}\" style=\"color:#333333;\">". ($item['team1Goals'] != NULL ? $item['team1Goals'] : "0"). " - " . ($item['team2Goals'] != NULL ? $item['team2Goals'] : "0") . "</a></td>";
		}
	}
	echo "<td>{$current['locationName']}</td>";	
	echo "<td>{$current['date']}</td>";	
	echo "<td>{$current['time']}</td>";	
	echo "<td>{$current['umpireName']}</td>";	
	if ($public == false)
	{
		$url = base_url() . "index.php/admin/match/enterResults/".$current['matchId']."/";
		echo "<td><a href=\"{$url}\">Add result</a></td>";
	}
	echo "</tr>";
	$i++;
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


if ($public == false)
{
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
}

?>

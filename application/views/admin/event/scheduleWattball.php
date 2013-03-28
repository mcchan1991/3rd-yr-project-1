<ul class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index.php/admin/">Admin Home</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament">Tournaments</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament/view/<?php echo $tournament['tournamentId'] ?>"><?php echo $tournament['name'] ?></a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament/viewEvents/<?php echo $event['tournamentId']; ?>">Events</a> <span class="divider">/</span></li>
  <li class="active">Event: <?php echo $event['name']; ?></li>
</ul>
<?php
$errors = validation_errors();
if (!empty($errors))
{
echo "<div class=\"alert alert-error\">";
echo validation_errors();
echo "</div>";
}
?>

<h3>Schedule</h3>

<?php

echo '<span class="label label-important">NOTE: There are NO data verification, please ensure umpires and locations are available at the selected times!</span>';
	
$attributes = array('class' => 'form-inline', 'name' => 'schedule');
$labelAttributes = array(
    'class' => 'control-label',
	'style' => 'margin-right:5px; margin-left:5px'
);
$btnAttributes = array(
    'class' => 'btn',
	'style' => 'margin-top: 15px;',
	'name' => 'submit'
);
$inputAttributes = array(
	'class' => 'input-small'
);

echo form_open("admin/scheduler/saveWattball/{$event['eventId']}", $attributes);

$teamsArray = array();
$teamsArray[-1] = "";
foreach($teams as $currentTeam)
{	
	$id = $currentTeam['nwaId'];
	$teamsArray[$id] = $teamNames[$currentTeam['nwaId']];
}
$umpiresArray = array();
$umpiresArray[-1] = "";

foreach($umpires as $currentUmpire)
{
	$id = $currentUmpire['umpireId'];
	$umpiresArray[$id] = $currentUmpire['firstName'] . " " . $currentUmpire['surname'];
}

$locationsArray = array();
$locationsArray[-1] = "Location";
foreach($locations as $currentLocation)
{
	$id = $currentLocation['locationId'];
	$locationsArray[$id] = $currentLocation['name'];
}

for ($i = 0; $i < $totalGames; $i++)
{
	if ($i < count($matches))
	{
		$match = $matches[$i];
		//print_r($match);
	}
	else 
	{
		$match = -1;
	}
	$matchNo = $i+1;
	echo "<h5>Match {$matchNo} </h5>";
	if ($match == -1 || $retry == 1)
	{
		$curTeam1 = NULL;
		$curTeam2 = NULL;
		$curUmpire = NULL;
		$curLocation = NULL;
		$curDate = "";
		$curTime = "";
		$curId = -1;
		if ($i < count($team1))
		{
			$curTeam1 = $team1[$i];
			$curTeam2 = $team2[$i];
			$curUmpire = $umpire[$i];
			$curLocation = $location[$i];
			$curDate = $date[$i];
			$curTime = $eventTime[$i];
			$curId = $matchId[$i];
		}
		echo form_dropdown('team1[]', $teamsArray, $curTeam1, 'class="input-small"');
		echo form_label('VS', 'team2', $labelAttributes);
		echo form_dropdown('team2[]', $teamsArray, $curTeam2, 'class="input-small"');
		
		
		echo form_label('Umpire', 'umpire[]', $labelAttributes);
		echo form_dropdown('umpire[]', $umpiresArray, $curUmpire, 'class="input-small"');

		echo "<br /> <br />";

		echo form_dropdown('location[]', $locationsArray, $curLocation, 'class="input-small"');

		$dateForm = array(
			'name'	=> 'date[]',
			'id'	=> 'date[]',
			'placeholder' => 'dd/mm/yyyy',
			'class'	=> 'input-small dateInput',
			'value' => $curDate,
		);

		echo form_label('Date', 'date[]', $labelAttributes);
		echo form_input($dateForm);

		$eventTimesForm = array(
			'name'	=> 'eventTime[]',
			'id'	=> 'eventTime[]',
			'placeholder' => 'HH:MM',
			'class'	=> 'input-small',
			'value' => $curTime
		);

		echo form_label('At', 'eventTime[]', $labelAttributes);
		echo form_input($eventTimesForm);
		echo form_hidden('matchId[]', $curId);
	}
	else
	{
		echo form_dropdown('team1[]', $teamsArray, $match['team1Id'], 'class="input-small"');
		echo form_label('VS', 'team2', $labelAttributes);
		echo form_dropdown('team2[]', $teamsArray, 	$match['team2Id'], 'class="input-small"');
		
		
		echo form_label('Umpire', 'umpire[]', $labelAttributes);
		echo form_dropdown('umpire[]', $umpiresArray, $match['umpireId'], 'class="input-small"');

		echo "<br /> <br />";

		echo form_dropdown('location[]', $locationsArray, $match['locationId'], 'class="input-small"');

		$date = DateTime::createFromFormat("Y-m-d", $match['date']);
		
		$dateForm = array(
			'name'	=> 'date[]',
			'id'	=> 'date[]',
			'placeholder' => 'dd/mm/yyy',
			'class'	=> 'input-small dateInput',
			'value' => $date->format("d/m/Y")
		);

		echo form_label('Date', 'date[]', $labelAttributes);
		echo form_input($dateForm);
		$eventTimesForm = array(
			'name'	=> 'eventTime[]',
			'id'	=> 'eventTime[]',
			'placeholder' => 'HH:MM',
			'class'	=> 'input-small',
			'value' => substr($match['time'], 0, 5)
		);

		echo form_label('At', 'eventTime[]', $labelAttributes);
		echo form_input($eventTimesForm);

		echo form_hidden('matchId[]', $match['matchId']);
	}

}
echo "<br />";

echo form_submit($btnAttributes, "Submit schedule", 'submit');
echo form_close();


?>
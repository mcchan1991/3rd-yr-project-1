<ul class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index.php/admin/">Admin Home</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament">Tournaments</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament/view/<?php echo $tournament['tournamentId'] ?>"><?php echo $tournament['name'] ?></a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament/viewEvents/<?php echo $event['tournamentId']; ?>">Events</a> <span class="divider">/</span></li>
  <li class="active">Event: <?php echo $event['name']; ?></li>
</ul>
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
	if ($match == -1)
	{
		echo form_dropdown('team1[]', $teamsArray, NULL, 'class="input-small"');
		echo form_label('VS', 'team2', $labelAttributes);
		echo form_dropdown('team2[]', $teamsArray, NULL, 'class="input-small"');
		
		
		echo form_label('Umpire', 'umpire[]', $labelAttributes);
		echo form_dropdown('umpire[]', $umpiresArray, NULL, 'class="input-small"');

		echo "<br /> <br />";

		echo form_dropdown('location[]', $locationsArray, NULL, 'class="input-small"');

		$dateForm = array(
			'name'	=> 'eventTime[]',
			'id'	=> 'eventTime[]',
			'placeholder' => 'dd-mm-yyyy',
			'class'	=> 'input-small'
		);

		echo form_label('Date', 'date[]', $labelAttributes);
		echo form_input($dateForm);

		$eventTimesForm = array(
			'name'	=> 'eventTime[]',
			'id'	=> 'eventTime[]',
			'placeholder' => 'HH:MM',
			'class'	=> 'input-small'
		);

		echo form_label('At', 'eventTime[]', $labelAttributes);
		echo form_input($eventTimesForm);
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
			'name'	=> 'eventTime[]',
			'id'	=> 'eventTime[]',
			'placeholder' => 'dd/mm/yyy',
			'class'	=> 'input-small',
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
	}


	form_hidden('id[]', '-1');
}
echo "<br />";

echo form_submit($btnAttributes, "Submit schedule", 'submit');
echo form_close();


?>
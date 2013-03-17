<ul class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index.php/admin/">Admin Home</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament">Tournaments</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament/view/<?php echo $tournament['tournamentId'] ?>"><?php echo $tournament['name'] ?></a> <span class="divider">/</span></li>
  <li class="active">Edit Event: <?php echo $event['name']; ?></li>
</ul>

<?php

$labelAttributes = array(
    'class' => 'control-label',
	'style' => 'margin-right:5px; margin-left:5px'
);
$btnAttributes = array(
    'class' => 'btn',
	'style' => 'margin-top: 15px;'
);
$attributes = array('class' => 'form-inline');

//$form = form_label('Player', 'player[]', $labelAttributes);

$form = "<select name=\"player[]\" class=\"input-medium\">";
$form .= "<option value=\"-1\" style=\"font-weight:bold;\">Select a player</option>";
$form .= "<option value=\"-1\" style=\"font-weight:bold;\">---". $team1['name'] . "---</option>";
foreach($team1Players as $currentPlayer)
{	
	$form .= "<option value=\" " . $team1['nwaId'] .  "-" . $currentPlayer['shirtNo'] .  "\">". $currentPlayer['shirtNo'] . ". " . $currentPlayer['surname'] . "</option>";
}
$form .= "<option value=\"-1\" style=\"font-weight:bold;\">---". $team2['name'] . "---</option>";
foreach($team2Players as $currentPlayer)
{	
	$form .= "<option value=\" " . $team2['nwaId'] .  "-" . $currentPlayer['shirtNo'] .  "\">". $currentPlayer['shirtNo'] . ". " . $currentPlayer['surname'] . "</option>";
}
$form .= "</select>";


$form .= "<select name=\"assist[]\" class=\"input-medium\" style=\"margin-left:10px;\">";
$form .= "<option value=\"-1\" style=\"font-weight:bold;\">Assist</option>";
$form .= "<option value=\"-1\" style=\"font-weight:bold;\">---". $team1['name'] . "---</option>";
foreach($team1Players as $currentPlayer)
{	
	$form .= "<option value=\" " . $team1['nwaId'] .  "-" . $currentPlayer['shirtNo'] .  "\">". $currentPlayer['shirtNo'] . ". " . $currentPlayer['surname'] . "</option>";
}
$form .= "<option value=\"-1\" style=\"font-weight:bold;\">---". $team2['name'] . "---</option>";
foreach($team2Players as $currentPlayer)
{	
	$form .= "<option value=\" " . $team2['nwaId'] .  "-" . $currentPlayer['shirtNo'] .  "\">". $currentPlayer['shirtNo'] . ". " . $currentPlayer['surname'] . "</option>";
}
$form .= "</select>";

$minuteForm = array(
	'name'	=> 'minute[]',
	'id'	=> 'minute[]',
	'placeholder' => 'minute (mm)',
	'class'	=> 'input-small',
	'style' => 'margin-left:10px;'
);

$form .= form_input($minuteForm);
$form .= "<br /><br />";
$form .= "<label class=\"radio\" style=\"\">";
$form .= form_radio('type[]', 'goal', FALSE);
$form .= " Goal</label>";
$form .= "<label class=\"radio\" style=\"margin-left:10px;\">";
$form .= form_radio('type[]', 'owngoal', FALSE);
$form .= "Own-goal</label>";
$form .= "<label class=\"radio\" style=\"margin-left:10px;\">";
$form .= form_radio('type[]', 'yellowCard', FALSE);
$form .= "Yellow Card</label>";
$form .= "<label class=\"radio\" style=\"margin-left:10px;\">";
$form .= form_radio('type[]', 'redCard', FALSE);
$form .= "Red Card</label>";


//$form = form_dropdown('team[]', $playersArray, NULL, 'class="input-small"');

echo form_open("admin/scheduler/saveWattball/{$event['eventId']}", $attributes);
echo "<h6>Event 1</h6>";
echo $form;
echo "<h6>Event 2</h6>";
echo $form;
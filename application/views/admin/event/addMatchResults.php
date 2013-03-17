<ul class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index.php/admin/">Admin Home</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament">Tournaments</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament/view/<?php echo $tournament['tournamentId'] ?>"><?php echo $tournament['name'] ?></a> <span class="divider">/</span></li>
  <li class="active">Edit Event: <?php echo $event['name']; ?></li>
</ul>
<?php
$form = "<div class=\"event\">";
$form .= "<h6>Event</h6>";
$form .= "<select name=\"player[]\" class=\"input-medium\">";
$form .= "<option value=\"-1\" style=\"font-weight:bold;\">Select a player</option>";
$form .= "<option value=\"-1\" style=\"font-weight:bold;\">---". $team1['name'] . "---</option>";
foreach($team1Players as $currentPlayer)
{	
	$form .= "<option value=\" " . $currentPlayer['playerId'] .  "\">". $currentPlayer['shirtNo'] . ". " . $currentPlayer['surname'] . "</option>";
}
$form .= "<option value=\"-1\" style=\"font-weight:bold;\">---". $team2['name'] . "---</option>";
foreach($team2Players as $currentPlayer)
{	
	$form .= "<option value=\" " . $currentPlayer['playerId'] .  "\">". $currentPlayer['shirtNo'] . ". " . $currentPlayer['surname'] . "</option>";
}
$form .= "</select>";


$form .= "<select name=\"assist[]\" class=\"input-medium\" style=\"margin-left:10px;\">";
$form .= "<option value=\"-1\" style=\"font-weight:bold;\">Assist</option>";
$form .= "<option value=\"-1\" style=\"font-weight:bold;\">---". $team1['name'] . "---</option>";
foreach($team1Players as $currentPlayer)
{	
	$form .= "<option value=\" " . $currentPlayer['playerId'] .  "\">". $currentPlayer['shirtNo'] . ". " . $currentPlayer['surname'] . "</option>";
}
$form .= "<option value=\"-1\" style=\"font-weight:bold;\">---". $team2['name'] . "---</option>";
foreach($team2Players as $currentPlayer)
{	
	$form .= "<option value=\" " . $currentPlayer['playerId'] .  "\">". $currentPlayer['shirtNo'] . ". " . $currentPlayer['surname'] . "</option>";
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
$form .= form_radio('typex', 'goal', FALSE);
$form .= " Goal</label>";
/*$form .= "<label class=\"radio\" style=\"margin-left:10px;\">";
$form .= form_radio('typex', 'owngoal', FALSE);
$form .= "Own-goal</label>";*/
$form .= "<label class=\"radio\" style=\"margin-left:10px;\">";
$form .= form_radio('typex', 'yellowCard', FALSE);
$form .= "Yellow Card</label>";
$form .= "<label class=\"radio\" style=\"margin-left:10px;\">";
$form .= form_radio('typex', 'redCard', FALSE);
$form .= "Red Card</label>";
$form .= "<br /> <br /><a href=\"#\" class=\"remove\" >Remove event</a>";
$form .= form_hidden('resultId[]', -1);
$form .= "</div>";
?>
<script>
$(function () {
    var div = $('#events');
    var i = $('#events h6').size();

    $('#addInput').on('click', function () {
        $('<?php echo $form;  ?>').appendTo(div);
        i++;
		$('[name=typex]').attr("name","type[" + i + "]");
        return false;
    });

    $(document).on('click', '.remove', function () {
        if (i > 1) {
            $(this).parent('div').remove();
            i--;
        }
        return false;
    });
});

</script>
<h3>Add match resulsts</h3>
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
$errors = validation_errors();
if (!empty($errors))
{
echo "<div class=\"alert alert-error\">";
echo validation_errors();
echo "</div>";
}
echo form_open("admin/match/saveMatchResults/{$matchId}", $attributes);
echo "<div id=\"events\">";

if (count($player) == 0)
{
	$count = 2;
}
else
{
	$count = count($player);
}
for ($i = 0; $i < $count; $i++)
{
	$curPlayer = "";
	$curAssist = "";
	$curMinute = "";
	$curType = "";
	$curResultId = -1;
	if ($i < count($player))
	{
		$curPlayer = $player[$i];
		$curAssist = $assist[$i];
		$curMinute = $minute[$i];
		$curType = $type[$i];
		$curResultId = $resultId[$id];
	}
	$form = "<div class=\"event\">";
	$form .= "<h6>Event</h6>";
	$form .= "<select name=\"player[]\" class=\"input-medium\">";
	$form .= "<option value=\"-1\" style=\"font-weight:bold;\">Select a player</option>";
	$form .= "<option value=\"-1\" style=\"font-weight:bold;\">---". $team1['name'] . "---</option>";
	foreach($team1Players as $currentPlayer)
	{	
		$selected = "";
		if ($currentPlayer['playerId']  == $curPlayer)
		{
			$selected = "selected";
		}
		$form .= "<option value=\"" . $currentPlayer['playerId'] .  "\" {$selected}>". $currentPlayer['shirtNo'] . ". " . $currentPlayer['surname'] . "</option>";
	}
	$form .= "<option value=\"-1\" style=\"font-weight:bold;\">---". $team2['name'] . "---</option>";
	foreach($team2Players as $currentPlayer)
	{	
		$selected = "";
		if ($currentPlayer['playerId']  == $curPlayer)
		{
			$selected = "selected";
		}
		$form .= "<option value=\"" . $currentPlayer['playerId']  .  "\" {$selected}>". $currentPlayer['shirtNo'] . ". " . $currentPlayer['surname'] . "</option>";
	}
	$form .= "</select>";


	$form .= "<select name=\"assist[]\" class=\"input-medium\" style=\"margin-left:10px;\">";
	$form .= "<option value=\"-1\" style=\"font-weight:bold;\">Assist</option>";
	$form .= "<option value=\"-1\" style=\"font-weight:bold;\">---". $team1['name'] . "---</option>";
	foreach($team1Players as $currentPlayer)
	{	
		$selected = "";
		if ($currentPlayer['playerId']  == $curAssist)
		{
			$selected = "selected";
		}
		$form .= "<option value=\"" . $currentPlayer['playerId']  .  "\" {$selected}>". $currentPlayer['shirtNo'] . ". " . $currentPlayer['surname'] . "</option>";
	}
	$form .= "<option value=\"-1\" style=\"font-weight:bold;\">---". $team2['name'] . "---</option>";
	foreach($team2Players as $currentPlayer)
	{		
		$selected = "";
		if ($currentPlayer['playerId'] == $curAssist)
		{
			$selected = "selected";
		}
		$form .= "<option value=\"" . $currentPlayer['playerId'] .  "\" {$selected}>". $currentPlayer['shirtNo'] . ". " . $currentPlayer['surname'] . "</option>";
	}
	$form .= "</select>";

	$minuteForm = array(
		'name'	=> 'minute[]',
		'id'	=> 'minute[]',
		'placeholder' => 'minute (mm)',
		'class'	=> 'input-small',
		'style' => 'margin-left:10px;',
		'value' => $curMinute
	);

	$form .= form_input($minuteForm);
	$form .= "<br /><br />";
	$form .= "<label class=\"radio\" style=\"\">";
	$bool = FALSE;
	if ($curType == "goal")
	{
		$bool = TRUE;
	}
	$form .= form_radio("type[{$i}]", 'goal', $bool);
	$form .= " Goal</label>";
	/*$form .= "<label class=\"radio\" style=\"margin-left:10px;\">";
	$bool = FALSE;
	if ($curType == "owngoal")
	{
		$bool = TRUE;
	}
	$form .= form_radio("type[{$i}]", 'owngoal', $bool);
	$form .= "Own-goal</label>";*/
	$form .= "<label class=\"radio\" style=\"margin-left:10px;\">";
	$bool = FALSE;
	if ($curType == "yellowCard")
	{
		$bool = TRUE;
	}
	$form .= form_radio("type[{$i}]", 'yellowCard', $bool);
	$form .= "Yellow Card</label>";
	$form .= "<label class=\"radio\" style=\"margin-left:10px;\">";
	$bool = FALSE;
	if ($curType == "redCard")
	{
		$bool = TRUE;
	}
	$form .= form_radio("type[{$i}]", 'redCard', $bool);
	$form .= "Red Card</label>";
	if ($i != 0) {$form .= "<br /> <br /><a href=\"#\" class=\"remove\" >Remove event</a>";}
	$form .= form_hidden('resultId[]', $curResultId);
	$form .= "</div>";
	echo $form;
}
echo "</div>";
echo "<br />";
echo "<a href=\"#\" id=\"addInput\" style=\"\">Add another event</a>";
echo "<br />";
echo form_submit($btnAttributes, "Submit result", 'submit');
echo form_close();
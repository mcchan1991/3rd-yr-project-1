<?php
$attributes = array('class' => 'form-horizontal');
$labelAttributes = array(
    'class' => 'control-label',
);
$btnAttributes = array(
    'class' => 'btn',
);

?>

<ul class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index.php/">Home</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/tournament">Tournaments</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/tournamens/view/<?php echo $tournament['tournamentId'] ?>"><?php echo $tournament['name'] ?></a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/event/view/<?php echo $event['eventId']; ?>"><?php echo $event['name'] ?></a> <span class="divider">/</span></li>  
  <li class="active">Register for event</li>
</ul>
<h3>Login for view event: <?php echo $event['name'] ?></h3>
<?php
$errors = validation_errors();
if (!empty($errors) || isset($registrationError))
{
echo "<div class=\"alert alert-error\">";
echo "Sorry, registration for this tournament have ended.";

echo "</div>";
}
else if (isset($registrationError))
{
echo "<div class=\"alert alert-error\">";
if ($registartionError == 1)
{
	echo "Sorry, registration for this tournament have ended.";
}
else if ($registartionError == 2)
{
	echo "Sorry, registration for this tournament have not yet startet. Registration period is: PLACEHOLDER";
}
echo "</div>";

$btnAttributes = array(
    'class' => 'btn disabled',
);
}

?>
<?php echo validation_errors(); ?>
<?php
	echo form_open("team/verifyTeamLogin/teamLogin/{$event['eventId']}", $attributes);
	//echo form_open('team/teamRegister/add');

	// form building
	$email = array(
		'name'	=> 'email',
		'id'	=> 'email',
		'value' => $email
	);

	echo "<div class=\"control-group\">";
	echo form_label('email', 'email', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_input($email);
	echo '</div></div>';

	
	$password = array(
		'name'	=> 'password',
		'id'	=> 'password',
		'value' => $password
	);
	
	echo "<div class=\"control-group\">";
	echo form_label('Passowrd', 'password', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_password($password);
	echo '</div></div>';


	
	echo "<div class=\"control-group\">";
	echo "<div class=\"controls\">";
	
	// codeigniter was causing some troubles so submit button in pure php

	echo "<input type=\"submit\" name=\"\" value=\"Submit\" class=\"btn\" submit />";
	echo '</div>';
	echo '</div>';
	
	echo form_close();

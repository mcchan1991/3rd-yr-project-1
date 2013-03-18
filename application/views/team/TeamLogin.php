<?php
$attributes = array('class' => 'form-horizontal');
$labelAttributes = array(
    'class' => 'control-label',
);
$btnAttributes = array(
    'class' => 'btn',
);

?>

		
<?php 	
	$errors = validation_errors();
	if (!empty($errors))
	{
		echo "<div class=\"alert alert-error\">";
		echo validation_errors();
		echo "</div>";
	}
?>

<H2> Login to register<H2>
<?php
	if(isset($eventId))
	{
		echo form_open("team/verifyTeamLogin/teamLogin/{$eventId}", $attributes);
	}
	else
	{
		echo form_open("team/verifyTeamLogin/teamLogin/", $attributes);
	}

	// form building
	$email = array(
		'name'	=> 'email',
		'id'	=> 'email',
		'value' => $email
	);
	
	
	echo "<div class=\"control-group\">";
	echo form_label('Email', 'email', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_input($email);
	echo '</div></div>';
	
	$password = array(
		'name'	=> 'password',
		'id'	=> 'password',
		'value' => $password
	);
	
	echo "<div class=\"control-group\">";
	echo form_label('Password', 'password', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_password($password);
	echo '</div></div>';


	
	echo "<div class=\"control-group\">";
	echo "<div class=\"controls\">";
	
	// codeigniter was causing some troubles so submit button in pure php

	echo "<input type=\"submit\" name=\"\" value=\"Submit\" class=\"btn\" submit />";
	$registerUrl = base_url() . "index.php/team/teamRegister/add/{$eventId}";
	echo '<a href="' . $registerUrl .'" class="btn btn-large btn-primary" style="margin-left:20pt;">Register New Team</a>';
	echo '</div>';
	echo '</div>';
	
	echo form_close();

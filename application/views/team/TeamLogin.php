<?php echo validation_errors(); ?>

<?php 
	echo form_open('team/verifyTeamLogin');
?>

<?php
	// form building
	$email = array(
		'name'	=> 'email',
		'id'	=> 'email',
		'value' => $email
	);
	
	echo form_input($email);
	echo form_label('Email', 'email');
	echo '<br />';
	
	$password = array(
		'name'	=> 'password',
		'id'	=> 'password',
		'value' => $password
	);
	
	echo form_password($password);
	echo form_label('Password', 'password');
	echo '<br />';
	
	echo form_submit('submit', 'Submit');
	
	echo form_close();

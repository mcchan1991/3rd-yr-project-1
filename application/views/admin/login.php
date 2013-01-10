<?php echo validation_errors(); ?>

<?php 
	echo form_open('admin/VerifyLogin');
?>

<?php
	// form building
	$username = array(
		'name'	=> 'username',
		'id'	=> 'username',
		'value' => $username
	);
	
	echo form_input($username);
	echo form_label('Username', 'username');
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
<?php echo validation_errors(); ?>


<?php
	echo form_open('team/teamRegister/team_update');

	// form building

	
	$name = array(
		'name'	=> 'name',
		'id'	=> 'name',
		'value' => $name
	);
	
	echo form_input($name);
	echo form_label('Team Name', 'name');
	echo '<br />';
	
	$contactFirstName = array(
		'name'	=> 'contactFirstName',
		'id'	=> 'contactFirstName',
		'value' => $contactFirstName
	);
	
	echo form_input($contactFirstName);
	echo form_label('contact FirstName', 'contactFirstName');
	echo '<br />';

	$contactSurname = array(
		'name'	=> 'contactSurname',
		'id'	=> 'contactSurname',
		'value' => $contactSurname
	);
	
	echo form_input($contactSurname);
	echo form_label('contact Surname', 'contactSurname');
	echo '<br />';
	
	
	$email = array(
		'name'	=> 'email',
		'id'	=> 'email',
		'value' => $email
	);
	
	echo form_input($email);
	echo form_label('email', 'email');
	echo '<br />';
	
	$password = array(
		'name'	=> 'password',
		'id'	=> 'password',
		'value' => $password
	);
	
	echo form_password($password);
	echo form_label('Passowrd', 'password');
	echo '<br />';

	$cpassword = array(
		'name'	=> 'cpassword',
		'id'	=> 'cpassword',
		'value' => $cpassword
	);
	
	echo form_password($cpassword);
	echo form_label('cpassword', 'cpassword');
	echo '<br />';
	
	echo form_submit('submit', 'Submit');
	
	echo form_close();


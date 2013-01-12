<?php echo validation_errors(); ?>


<?php
	echo form_open('athlete/add');

	// form building
	$firstName = array(
		'name'	=> 'firstName',
		'id'	=> 'firstName',
		'value' => $firstName
	);
	
	echo form_input($firstName);
	echo form_label('First Name', 'firstName');
	echo '<br />';
	
	$surname = array(
		'name'	=> 'surname',
		'id'	=> 'surname',
		'value' => $surname
	);
	
	echo form_input($surname);
	echo form_label('Surname', 'surname');
	echo '<br />';
	
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
	echo form_label('Passowrd', 'password');
	echo '<br />';
	
	$dob = array(
		'name'	=> 'dob',
		'id'	=> 'dob',
		'value' => $dob
	);
	
	echo form_input($dob);
	echo form_label('Date of birth', 'dob');
	echo '<br />';
	
	form_hidden('gender', $gender);
	
	echo form_submit('submit', 'Submit');
	
	echo form_close();
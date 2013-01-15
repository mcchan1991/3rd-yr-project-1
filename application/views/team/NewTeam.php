<?php echo validation_errors(); ?>


<?php
	echo form_open('team/teamRegister/add');

	// form building
	$nwaId = array(
		'name'	=> 'nwaId',
		'id'	=> 'nwaId',
		'value' => $nwaId
	);
	
	echo form_input($nwaId);
	echo form_label('NWAID', 'nwaId');
	echo '<br />';
	
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
	
	$email = array(
		'name'	=> 'email',
		'id'	=> 'email',
		'value' => $email
	);
	
	echo form_input($email);
	echo form_label('email', 'email');
	echo '<br />';
	
	echo form_submit('submit', 'Submit');
	
	echo form_close();

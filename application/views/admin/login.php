<?php 
	$attributes = array('class' => 'form-signin');
	echo form_open('admin/verifylogin', $attributes);
?>
<h2 class="form-signin-heading">Please sign in</h2>
<?php
$errors = validation_errors();
if (!empty($errors))
{
echo "<div class=\"alert alert-error\">";
echo validation_errors();
echo "</div>";
}
?>
<?php
	// form building
	$username = array(
		'name'	=> 'username',
		'id'	=> 'username',
		'value' => $username,
		'class' => 'input-block-level',
		'placeholder' => 'Username'
	);
	
	echo form_input($username);
	//echo form_label('Username', 'username');
	echo '<br />';
	
	$password = array(
		'name'	=> 'password',
		'id'	=> 'password',
		'value' => $password,
		'class' => 'input-block-level',
		'placeholder' => 'Password'
	);
	
	echo form_password($password);
	//echo form_label('Password', 'password');
	echo '<br />';
	$attributes = array('class' =>'btn btn-large btn-primary');
	echo form_submit($attributes, 'Login', 'submit');
	
	echo form_close();
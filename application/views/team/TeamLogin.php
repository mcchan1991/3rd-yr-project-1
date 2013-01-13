<html>
	<?php
	
	echo form_open('team/Team/check_team_login');
	
	echo validation_errors();
	

	echo "<p>email";
	echo form_input('email');
	echo "</p>";
	
	echo "<p>password";
	echo form_password('password');
	echo "</p>";
	
	echo "<p>";
	echo form_submit('signup_submit', 'Login');
	echo "</p>";
	
	echo form_close();
	
	
	
	?>
	<a href='<?php echo base_url()."index.php/team/Team/team_register"; ?>'>Team Registration</a>
</html>

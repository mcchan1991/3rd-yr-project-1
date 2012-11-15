<html>
	<?php
	
	echo form_open('team/Team/team_validation');
	
	echo validation_errors();
	
	echo "<p>Team Name";
	echo form_input('TeamName');
	echo "</p>";

	echo "<p>email";
	echo form_input('email');
	echo "</p>";
	
	echo "<p>password";
	echo form_password('password');
	echo "</p>";
	
	echo "<p>confirm password";
	echo form_password('cpassword');
	echo "</p>";
	
	echo "<p>Contact first name";
	echo form_input('CFname');
	echo "</p>";
	
	echo "<p>contact surname";
	echo form_input('CSname');
	echo "</p>";
	
	echo "<p>";
	echo form_submit('signup_submit', 'sign up');
	echo "</p>";
	
	echo form_close();
	
	?>
</html>

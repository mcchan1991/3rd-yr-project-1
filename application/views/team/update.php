<html>
	<?php
	
	echo form_open('team/Team/team_update');
	
	echo validation_errors();
	echo "update Team";
	
	echo "<p>Team Name";
	echo form_input('TeamName');
	echo "</p>";

	echo "<p>email";
	echo form_input('email');
	echo "</p>";
	
	echo "<p>Contact first name";
	echo form_input('CFname');
	echo "</p>";
	
	echo "<p>contact surname";
	echo form_input('CSname');
	echo "</p>";
	
	echo "<p>";
	echo form_submit('update_submit', 'update');
	echo "</p>";
	
	echo form_close();
	
	?>
</html>

<?php
$attributes = array('class' => 'form-horizontal');
$labelAttributes = array(
    'class' => 'control-label',
);
$btnAttributes = array(
    'class' => 'btn',
);

?>

<ul class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index.php/">Home</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/tournament">Tournaments</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/tournamens/view/<?php echo $tournament['tournamentId'] ?>"><?php echo $tournament['name'] ?></a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/event/view/<?php echo $event['eventId']; ?>"><?php echo $event['name'] ?></a> <span class="divider">/</span></li>  
  <li class="active">Register for event</li>
</ul>
<h3>Register for event: <?php echo $event['name'] ?></h3>
<?php
	$errors = validation_errors();
	if (!empty($errors))
	{
		echo "<div class=\"alert alert-error\">";
		echo validation_errors();
		echo "</div>";
	}
	
	if ($registrationError != 0)
	{
		switch ($registrationError) {
			case 1:
				echo "Registration for this event is closed"; break;
			case 2:
				echo "Registration for this event hasn't started yet"; break;
			case 3:
				echo "This event is already full"; break;
		}
	}
	else
	{
	
		echo form_open("team/teamRegister/add/{$event['eventId']}", $attributes);
		//echo form_open('team/teamRegister/add');

		// form building
		$nwaId = array(
			'name'	=> 'nwaId',
			'id'	=> 'nwaId',
			'value' => $nwaId
		);

		echo "<div class=\"control-group\">";
		echo form_label('NWAID', 'nwaId', $labelAttributes);
		echo "<div class=\"controls\">";
		echo form_input($nwaId);
		echo '</div></div>';
		

		
		$name = array(
			'name'	=> 'name',
			'id'	=> 'name',
			'value' => $name
		);

		echo "<div class=\"control-group\">";
		echo form_label('Team Name', 'name', $labelAttributes);
		echo "<div class=\"controls\">";
		echo form_input($name);
		echo '</div></div>';
			

		
		$contactFirstName = array(
			'name'	=> 'contactFirstName',
			'id'	=> 'contactFirstName',
			'value' => $contactFirstName
		);
		
		echo "<div class=\"control-group\">";
		echo form_label('Contact First Name', 'contactFirstName', $labelAttributes);
		echo "<div class=\"controls\">";
		echo form_input($contactFirstName);
		echo '</div></div>';
		

		$contactSurname = array(
			'name'	=> 'contactSurname',
			'id'	=> 'contactSurname',
			'value' => $contactSurname
		);
		
		
		echo "<div class=\"control-group\">";
		echo form_label('Contact Surname', 'contactSurname', $labelAttributes);
		echo "<div class=\"controls\">";
		echo form_input($contactSurname);
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

		$cpassword = array(
			'name'	=> 'cpassword',
			'id'	=> 'cpassword',
			'value' => $cpassword
		);
		
		
		echo "<div class=\"control-group\">";
		echo form_label('Confirm Password', 'cpassword', $labelAttributes);
		echo "<div class=\"controls\">";
		echo form_password($cpassword);
		echo '</div></div>';
		
		$email = array(
			'name'	=> 'email',
			'id'	=> 'email',
			'value' => $email
		);

			
		echo "<div class=\"control-group\">";
		echo form_label('E-mail', 'email', $labelAttributes);
		echo "<div class=\"controls\">";
		echo form_input($email);
		echo '</div></div>';
		
		
		$firstName = array(
			'name'	=> 'firstName[]',
			'id'	=> 'firstName[]',
		);
		
		$surname = array(
			'name'	=> 'surname[]',
			'id'	=> 'surname[]',
		);
		
		$num = array(
			'name'	=> 'num[]',
			'id'	=> 'num[]',
		);
		
		echo "<div class=\"control-group\">";
		echo "
		<table class=\"table\">
		<thead>
			<tr>
				<th></th>
				<th>First Name</th>
				<th>Surname</th>
				<th>Shirt Number</th>
			</tr> 
		</thead>
		<tbody>";
		for ($i = 0; $i < 10; $i++)
		echo "
		<tr>
		<td> Player " . ($i + 1) . " </td>
		<td>" . form_input($firstName) . " </td>
		<td>" . form_input($surname) . " </td>
		<td>" . form_input($num) . " </td>
		</tr>
		";
		echo "</tbody>
		</table>";
		
		echo '</div>';
		
		echo "<div class=\"control-group\">";
		echo "<div class=\"controls\">";
		
		echo "<input type=\"submit\" name=\"\" value=\"Submit\" class=\"btn\" submit />";

		echo '</div>';
		echo '</div>';
		
		echo form_close();
	}

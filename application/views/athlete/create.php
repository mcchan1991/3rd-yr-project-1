<script>
$(function() {
	$( "#dob" ).datepicker({
	  defaultDate: "-30y",
	  changeMonth: false,
	  numberOfMonths: 1,
	  dateFormat: "dd/mm/yy",
	});
});

</script>
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
if (!empty($errors) || isset($registrationError))
{
echo "<div class=\"alert alert-error\">";
echo "Sorry, registration for this tournament have ended.";
echo validation_errors();
echo "</div>";
}
else if (isset($registrationError))
{
echo "<div class=\"alert alert-error\">";
if ($registartionError == 1)
{
	echo "Sorry, registration for this tournament have ended.";
}
else if ($registartionError == 2)
{
	echo "Sorry, registration for this tournament have not yet startet. Registration period is: PLACEHOLDER";
}
echo "</div>";

$btnAttributes = array(
    'class' => 'btn disabled',
);
}

?>

<?php
	echo form_open("athlete/add/{$event['eventId']}", $attributes);

	// form building
	$firstName = array(
		'name'	=> 'firstName',
		'id'	=> 'firstName',
		'value' => $firstName
	);
	
	echo "<div class=\"control-group\">";
	echo form_label('First Name', 'firstName', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_input($firstName);
	echo '</div></div>';
	
	$surname = array(
		'name'	=> 'surname',
		'id'	=> 'surname',
		'value' => $surname
	);
	
	echo "<div class=\"control-group\">";
	echo form_label('Surname', 'surname', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_input($surname);
	echo '</div></div>';
	
	$email = array(
		'name'	=> 'email',
		'id'	=> 'email',
		'value' => $email
	);

	echo "<div class=\"control-group\">";
	echo form_label('Email', 'email', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_input($email);
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
	
	$dob = array(
		'name'	=> 'dob',
		'id'	=> 'dob',
		'value' => $dob
	);
	
	echo "<div class=\"control-group\">";
	echo form_label('Date Of Birth', 'dob', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_input($dob);
	echo '</div></div>';
	
	$fastestForm = array(
		'name'	=> 'fastest',
		'id'	=> 'fastest',
		'value' => $fastest
	);
	
	echo "<div class=\"control-group\">";
	echo form_label('Fastest Run', 'fastest', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_input($fastestForm);
	echo '</div></div>';
	
	echo form_hidden('gender', $gender);
	
	echo "<div class=\"control-group\">";
	echo "<div class=\"controls\">";
	
	// codeigniter was causing some troubles so submit button in pure php
	if (!empty($errors) || isset($registrationError))
	{
		echo "<input type=\"submit\" name=\"\" value=\"Submit\" class=\"btn disabled\" disabled />";
	}
	else
	{
		echo "<input type=\"submit\" name=\"\" value=\"Submit\" class=\"btn\" submit />";
		
	}
	echo '</div>';
	echo '</div>';
	
	echo form_close();
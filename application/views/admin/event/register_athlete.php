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
  <li><a href="<?php echo base_url(); ?>index.php/admin/">Admin Home</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/tournaments">Tournaments</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/tournamens/view/<?php echo $tournament['tournamentId'] ?>"><?php echo $tournament['name'] ?></a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/event/view/<?php echo $event['eventId']; ?>"><?php echo $event['name'] ?></a> <span class="divider">/</span></li>  
  <li><a href="<?php echo base_url(); ?>index.php/admin/event/viewRegistrations/<?php echo $event['eventId']; ?>">Event registrations</a> <span class="divider">/</span></li>
  <li class="active">Register athlete for event</li>
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

?>

<?php
	echo form_open("admin/event/saveAthlete/{$event['eventId']}", $attributes);

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
	
	$genderForm = array(
		'name'	=> 'gender',
		'id'	=> 'gender',
		'value' => $gender
	);
	$options = array(
	                  '1'  => 'Male',
	                  '2'    => 'Female',
	                );

    echo form_hidden('gender', $gender);
	
	echo "<div class=\"control-group\">";
	echo "<div class=\"controls\">";
	echo form_submit($btnAttributes, 'Submit', 'submit');
	echo '</div>';
	echo '</div>';
	
	echo form_close();
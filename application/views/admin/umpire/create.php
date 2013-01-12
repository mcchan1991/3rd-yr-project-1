<?php 
if (empty($id))
{
	?>
	<ul class="breadcrumb">
	  <li><a href="<?php echo base_url(); ?>index.php/admin/">Admin Home</a> <span class="divider">/</span></li>
	  <li><a href="<?php echo base_url(); ?>index.php/admin/umpire">Umpires</a> <span class="divider">/</span></li>
	  <li class="active">Add new umpire</li>
	</ul>
	<?php
	echo "<h3>Add new umpire</h3>";
	
	$errors = validation_errors();
	if (!empty($errors))
	{
	echo "<div class=\"alert alert-error\">";
	echo validation_errors();
	echo "</div>";
	}
	echo form_open('admin/umpire/save');
}
else
{
	?>
	<ul class="breadcrumb">
	  <li><a href="<?php echo base_url(); ?>index.php/admin/">Admin Home</a> <span class="divider">/</span></li>
	  <li><a href="<?php echo base_url(); ?>index.php/admin/umpire">Umpires</a> <span class="divider">/</span></li>
	  <li class="active">Edit umpire: <?php echo $firstName . " " . $surname; ?></li>
	</ul>
	<?php
	echo "<h3>Edit umpire: {$firstName} {$surname}</h3>";
	$errors = validation_errors();
	if (!empty($errors))
	{
	echo "<div class=\"alert alert-error\">";
	echo validation_errors();
	echo "</div>";
	}
	echo form_open("admin/umpire/save/{$id}");
}

// form building
$firstNameForm = array(
	'name'	=> 'firstName',
	'id'	=> 'firstName',
	'value' => $firstName
);

echo form_input($firstNameForm);
echo form_label('First Name', 'firstName');
echo '<br />';

$surnameForm = array(
	'name'	=> 'surname',
	'id'	=> 'surname',
	'value' => $surname
);

echo form_input($surnameForm);
echo form_label('Surname', 'surname');
echo '<br />';

$dobForm = array(
	'name'	=> 'dob',
	'id'	=> 'dob',
	'value' => $DOB
);

echo form_input($dobForm);
echo form_label('Date Of Birth', 'dob');
echo '<br />';

$emailForm = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value' => $email
);

echo form_input($emailForm);
echo form_label('E-mail', 'email');
echo '<br />';

$sportOptions = array();
foreach ($sports as $sportValue)
{
	$sportOptions[$sportValue['sportId']] = $sportValue['sportName'];
}

echo form_dropdown('sport', $sportOptions);
echo form_label('Sport', 'sport');
echo "<br /> <br />";
echo form_submit('submit', 'Submit');

echo form_close();
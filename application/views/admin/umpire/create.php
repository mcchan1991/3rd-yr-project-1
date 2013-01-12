<?php 
$attributes = array('class' => 'form-horizontal');
$labelAttributes = array(
    'class' => 'control-label',
);
$btnAttributes = array(
    'class' => 'btn',
);
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
	echo form_open('admin/umpire/save', $attributes);
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
	echo form_open("admin/umpire/save/{$id}", $attributes);
}

// form building
$firstNameForm = array(
	'name'	=> 'firstName',
	'id'	=> 'firstName',
	'value' => $firstName
);

echo "<div class=\"control-group\">";
echo form_label('First Name', 'firstName', $labelAttributes);
echo "<div class=\"controls\">";
echo form_input($firstNameForm);
echo '</div>';
echo '</div>';

$surnameForm = array(
	'name'	=> 'surname',
	'id'	=> 'surname',
	'value' => $surname
);

echo "<div class=\"control-group\">";
echo form_label('Surname', 'surname', $labelAttributes);
echo "<div class=\"controls\">";
echo form_input($surnameForm);
echo '<br />';
echo '</div>';
echo '</div>';

$dobForm = array(
	'name'	=> 'dob',
	'id'	=> 'dob',
	'value' => $DOB
);

echo "<div class=\"control-group\">";
echo form_label('Date Of Birth', 'dob', $labelAttributes);
echo "<div class=\"controls\">";
echo form_input($dobForm);
echo '<br />';
echo '</div>';
echo '</div>';

$emailForm = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value' => $email
);

echo "<div class=\"control-group\">";
echo form_label('E-mail', 'email', $labelAttributes);
echo "<div class=\"controls\">";
echo form_input($emailForm);
echo '<br />';
echo '</div>';
echo '</div>';

$sportOptions = array();
foreach ($sports as $sportValue)
{
	$sportOptions[$sportValue['sportId']] = $sportValue['sportName'];
}

echo "<div class=\"control-group\">";
echo form_label('Sport', 'sport', $labelAttributes);
echo "<div class=\"controls\">";
echo form_dropdown('sport', $sportOptions);
echo "<br /> <br />";
echo form_submit($btnAttributes,'submit', 'Submit');
echo '</div>';
echo '</div>';

echo form_close();
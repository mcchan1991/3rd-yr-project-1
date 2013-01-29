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
	  <li><a href="<?php echo base_url(); ?>index.php/admin/staff">Staff</a> <span class="divider">/</span></li>
	  <li class="active">Add new a new Staff member</li>
	</ul>
	<?php
	echo "<h3>Add new a new staff member</h3>";
	
	$errors = validation_errors();
	if (!empty($errors))
	{
	echo "<div class=\"alert alert-error\">";
	echo validation_errors();
	echo "</div>";
	}
	echo form_open('admin/staff/save', $attributes);
}
else
{
	?>
	<ul class="breadcrumb">
	  <li><a href="<?php echo base_url(); ?>index.php/admin/">Admin Home</a> <span class="divider">/</span></li>
	  <li><a href="<?php echo base_url(); ?>index.php/admin/staff">Staff</a> <span class="divider">/</span></li>
	  <li class="active">Edit staff: <?php echo $firstname . " " . $surname; ?></li>
	</ul>
	<?php
	echo "<h3>Edit staff: {$firstname} {$surname}</h3>";
	$errors = validation_errors();
	if (!empty($errors))
	{
	echo "<div class=\"alert alert-error\">";
	echo validation_errors();
	echo "</div>";
	}
	echo form_open("admin/staff/save/{$id}", $attributes);
}

// form building

$usernameForm = array(
	'name'	=> 'username',
	'id'	=> 'username',
	'value' => $username
);

echo "<div class=\"control-group\">";
echo form_label('Username', 'username', $labelAttributes);
echo "<div class=\"controls\">";
echo form_input($usernameForm);
echo '</div>';
echo '</div>';

$passwordForm = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'value' => $password
);

echo "<div class=\"control-group\">";
echo form_label('Password', 'password', $labelAttributes);
echo "<div class=\"controls\">";
echo form_password($passwordForm);
echo '</div>';
echo '</div>';


$firstNameForm = array(
	'name'	=> 'firstname',
	'id'	=> 'firstname',
	'value' => $firstname
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


echo "<div class=\"control-group\">";
echo form_label('Manager', 'manager', $labelAttributes);
echo "<div class=\"controls\">";
$data = array(
    'name'        => 'manager',
    'id'          => 'manager',
    'value'       => 'accept',
    'checked'     => $manager,
    'style'       => 'margin:10px',
    );
echo form_checkbox($data);
	
echo "<br /> <br />";
echo form_submit($btnAttributes,'submit', 'Submit');
echo '</div>';
echo '</div>';

echo form_close();
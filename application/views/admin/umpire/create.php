<?php echo validation_errors(); ?>
<?php 
if (empty($id))
{
	echo form_open('admin/umpire/save');
}
else
{
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
<?php
$attributes = array('class' => 'form-horizontal');
$labelAttributes = array(
    'class' => 'control-label',
);
$btnAttributes = array(
    'class' => 'btn',
);

?>

<?php echo validation_errors(); ?>


<?php
	$errors = validation_errors();
	if (!empty($errors))
	{
		echo "<div class=\"alert alert-error\">";
		echo validation_errors();
		echo "</div>";
	}
	


	echo form_open_multipart("team/teamRegister/update/{$nwaId}", $attributes);
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
	
	echo "<div class=\"control-group\">";
	echo form_label('Logo', 'logo', $labelAttributes);
	echo "<div class=\"controls\">";
	echo '<input type="file" name="userfile" size="20" />';
	echo '</div></div>';
	
	$descriptionField = array(
	'name'	=> 'description',
	'id'	=> 'description',
	'class' => 'input-xxlarge',
	'value' => $description
	);

	echo "<div class=\"control-group\">";
	echo form_label('Description', 'description', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_textarea($descriptionField);
	echo '</div>';
	echo '</div>';
		
	
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
	{
		$firstNameProp = array(
			'name'	=> 'firstName[]',
			'id'	=> 'firstName[]',
			'value' => isset($firstName[$i]) ? $firstName[$i] : ""
		);
		
		$surnameProp = array(
			'name'	=> 'surname[]',
			'id'	=> 'surname[]',
			'value' => isset($surname[$i]) ? $surname[$i] : ""
		);
		
		$numProp = array(
			'name'	=> 'num[]',
			'id'	=> 'num[]',
			'value' => isset($num[$i]) ? $num[$i] : ""
		);
		echo "
			<tr>
			<td> Player " . ($i + 1) . " </td>
			<td>" . form_input($firstNameProp) . " </td>
			<td>" . form_input($surnameProp) . " </td>
			<td>" . form_input($numProp) . " </td>
			</tr>
		";
	}
	echo "</tbody>
	</table>";
	
	echo '</div>';
	
	echo "<div class=\"control-group\">";
	echo "<div class=\"controls\">";
	
	echo "<input type=\"submit\" name=\"\" value=\"Submit\" class=\"upload\" submit />";

	echo '</div>';
	echo '</div>';
	
	echo form_close();
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
  <li class="active">Ticket</li>
</ul>
<?php echo validation_errors(); ?>
<?php
	echo form_open("ticket/addInfo/{$ID}/{$Tournament}", $attributes);
	
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
		

	
	$surName = array(
		'name'	=> 'surName',
		'id'	=> 'surName',
		'value' => $surName
	);
	
	echo "<div class=\"control-group\">";
	echo form_label('Surname', 'surName', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_input($surName);
	echo '</div></div>';
	

	$addr1 = array(
		'name'	=> 'addr1',
		'id'	=> 'addr1',
		'value' => $addr1
	);
	
	
	echo "<div class=\"control-group\">";
	echo form_label('Address 1', 'addr1', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_input($addr1);
	echo '</div></div>';
	
		
	$addr2 = array(
		'name'	=> 'addr2',
		'id'	=> 'addr2',
		'value' => $addr2
	);
	
	
	echo "<div class=\"control-group\">";
	echo form_label('Address 2', 'addr2', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_input($addr2);
	echo '</div></div>';
	
	$postcode = array(
		'name'	=> 'postcode',
		'id'	=> 'postcode',
		'value' => $postcode
	);
	
	
	echo "<div class=\"control-group\">";
	echo form_label('Postcode', 'postcode', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_input($postcode);
	echo '</div></div>';
	

	$city = array(
		'name'	=> 'city',
		'id'	=> 'city',
		'value' => $city
	);
	
	
	echo "<div class=\"control-group\">";
	echo form_label('City', 'city', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_input($city);
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
	echo "<div class=\"controls\">";
	echo "<input type=\"submit\" name=\"\" value=\"Submit\" class=\"btn\" submit />";
	echo '</div>';
	echo '</div>';
	
	echo form_close();

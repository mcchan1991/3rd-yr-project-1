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
	  <li><a href="<?php echo base_url(); ?>index.php/admin/location">Locations</a> <span class="divider">/</span></li>
	  <li class="active">Add new location</li>
	</ul>
	<?php
	echo "<h3>Add new Location</h3>";
	
	$errors = validation_errors();
	if (!empty($errors))
	{
	echo "<div class=\"alert alert-error\">";
	echo validation_errors();
	echo "</div>";
	}
	echo form_open('admin/location/save', $attributes);
}
else
{
	?>
	<ul class="breadcrumb">
	  <li><a href="<?php echo base_url(); ?>index.php/admin/">Admin Home</a> <span class="divider">/</span></li>
	  <li><a href="<?php echo base_url(); ?>index.php/admin/location">Locations</a> <span class="divider">/</span></li>
	  <li class="active">Edit location: <?php echo $name?></li>
	</ul>
	<?php
	echo "<h3>Edit location: {$name}</h3>";
	$errors = validation_errors();
	if (!empty($errors))
	{
	echo "<div class=\"alert alert-error\">";
	echo validation_errors();
	echo "</div>";
	}
	echo form_open("admin/location/save/{$id}", $attributes);
}

// form building
$nameForm = array(
	'name'	=> 'name',
	'id'	=> 'name',
	'value' => $name
);

echo "<div class=\"control-group\">";
echo form_label('Name', 'name', $labelAttributes);
echo "<div class=\"controls\">";
echo form_input($nameForm);
echo '</div>';
echo '</div>';

$capacityForm = array(
	'name'	=> 'capacity',
	'id'	=> 'capacity',
	'value' => $capacity
);

echo "<div class=\"control-group\">";
echo form_label('Capacity', 'capacity', $labelAttributes);
echo "<div class=\"controls\">";
echo form_input($capacityForm);
echo '<br />';
echo '</div>';
echo '</div>';


echo "<div class=\"control-group\">";
echo form_label('Lights', 'lights', $labelAttributes);
echo "<div class=\"controls\">";
$data = array(
    'name'        => 'lights',
    'id'          => 'lights',
    'value'       => 'accept',
    'checked'     => $lights,
    'style'       => 'margin:10px',
    );
echo form_checkbox($data);
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
echo form_multiselect('sport[]', $sportOptions, $sportSelected);
echo "<br /> <br />";
echo form_submit($btnAttributes,'submit', 'Submit');
echo '</div>';
echo '</div>';

echo form_close();
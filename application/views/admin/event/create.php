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
	  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament">Tournaments</a> <span class="divider">/</span></li>
	  <li class="active">Add new event</li>
	</ul>
	<?php
	echo "<h3>Add new event</h3>";
	$errors = validation_errors();
	if (!empty($errors))
	{
	echo "<div class=\"alert alert-error\">";
	echo validation_errors();
	echo "</div>";
	}
	echo form_open('admin/event/save', $attributes);
}
else
{
	?>
	<ul class="breadcrumb">
	  <li><a href="<?php echo base_url(); ?>index.php/admin/">Admin Home</a> <span class="divider">/</span></li>
	  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament">Tournaments</a> <span class="divider">/</span></li>
	  <li class="active">Edit Event: <?php echo $name; ?></li>
	</ul>
	<?php
	echo "<h3>Edit Event: {$name}</h3>";
	$errors = validation_errors();
	if (!empty($errors))
	{
	echo "<div class=\"alert alert-error\">";
	echo validation_errors();
	echo "</div>";
	}
	echo form_open("admin/event/save/".$id, $attributes);
}

?>

<?php
	// form building
	$nameForm = array(
		'name'	=> 'name',
		'id'	=> 'name',
		'value' => $name
	);
	echo "<div class=\"control-group\">";
	echo form_label('Event name', 'name', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_input($nameForm);
	echo '</div>';
	echo '</div>';
	
	$regStartForm = array(
		'name'	=> 'regStart',
		'id'	=> 'regStart',
		'value' => $regStart
	);
	
	echo "<div class=\"control-group\">";
	echo form_label('Registration start', 'regStart', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_input($regStartForm);
	echo '</div>';
	echo '</div>';	
	
	$regEndForm = array(
		'name'	=> 'regEnd',
		'id'	=> 'regEnd',
		'value' => $regEnd
	);
	
	echo "<div class=\"control-group\">";
	echo form_label('Registration end', 'regEnd', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_input($regEndForm);
	echo '</div>';
	echo '</div>';
	
	$maxEntriesForm = array(
		'name'	=> 'maxEntries',
		'id'	=> 'maxEntries',
		'value' => $maxEntries
	);
	
	echo "<div class=\"control-group\">";
	echo form_label('Maximum No. of entries', 'maxEntries', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_input($maxEntriesForm);
	echo '</div>';
	echo '</div>';
	
	
	$minEntriesForm = array(
		'name'	=> 'minEntries',
		'id'	=> 'minEntries',
		'value' => $minEntries
	);
	
	echo "<div class=\"control-group\">";
	echo form_label('Minimum No. of entries', 'minEntries', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_input($minEntriesForm);
	echo '</div>';
	echo '</div>';
	
	$startForm = array(
		'name'	=> 'start',
		'id'	=> 'start',
		'value' => $start
	);
	
	echo "<div class=\"control-group\">";
	echo form_label('Start date', 'start', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_input($startForm);
	echo '</div>';
	echo '</div>';
	
	$endForm = array(
		'name'	=> 'end',
		'id'	=> 'end',
		'value' => $end
	);
	
	echo "<div class=\"control-group\">";
	echo form_label('End date', 'end', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_input($endForm);
	echo '</div>';
	echo '</div>';
	
	$sportOptions = array();
	foreach ($sports as $sportValue)
	{
		$sportOptions[$sportValue['sportId']] = $sportValue['sportName'];
	}

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
	
	echo form_hidden('tournament', $tournament);
	
	echo form_submit($btnAttributes,'submit', 'Submit');
	echo '</div>';
	echo '</div>';
	
	echo form_close();
<?php echo validation_errors(); ?>

<?php 
if (empty($id))
{
	echo form_open('admin/tournament/save');
}
else
{
	echo form_open("admin/tournament/save/{$id}");
}


?>

<?php
	// form building
	$name = array(
		'name'	=> 'name',
		'id'	=> 'name',
		'value' => $name
	);
	
	echo form_input($name);
	echo form_label('Tournament name', 'name');
	echo '<br />';
	
	$startDate = array(
		'name'	=> 'startDate',
		'id'	=> 'startDate',
		'value' => $startDate
	);
	
	echo form_input($startDate);
	echo form_label('Start date', 'startDate');
	echo '<br />';
	
	$endDate = array(
		'name'	=> 'endDate',
		'id'	=> 'endDate',
		'value' => $endDate
	);
	
	echo form_input($endDate);
	echo form_label('End date', 'endDate');
	echo '<br />';
	
	$noTicketsField = array(
		'name'	=> 'noTickets',
		'id'	=> 'noTickets',
		'value' => $noTickets
	);
	
	echo form_input($noTicketsField);
	echo form_label('Number of tickets/day', 'noTickets');
	echo '<br />';
	
	echo form_submit('submit', 'Submit');
	
	echo form_close();
<?php echo validation_errors(); ?>

<?php echo form_open('admin/tournament/add')?>

<?php
	// form building
	$name = array(
		'name'	=> 'name',
		'id'	=> 'name',
	);
	
	echo form_input($name);
	echo form_label('Tournament name', 'name');
	echo '<br />';
	
	$startDate = array(
		'name'	=> 'start_date',
		'id'	=> 'start_date',
	);
	
	echo form_input($startDate);
	echo form_label('Start date', 'start_date');
	echo '<br />';
	
	$endDate = array(
		'name'	=> 'end_date',
		'id'	=> 'end_date',
	);
	
	echo form_input($endDate);
	echo form_label('End date', 'end_date');
	echo '<br />';
	
	$noTickets = array(
		'name'	=> 'no_tickets',
		'id'	=> 'no_tickets',
	);
	
	echo form_input($noTickets);
	echo form_label('Number of tickets/day', 'no_tickets');
	echo '<br />';
	
	echo form_submit('submit', 'Add Tournament');
	
	echo form_close();
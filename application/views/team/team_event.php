<?php echo validation_errors(); ?>
<?php
	echo form_open('team/teamEvent/teamEvent1');
	$eventId = array(
		'name'	=> 'eventId',
		'id'	=> 'eventId',
		'value' => $eventId
	);
	//echo 
	echo form_input('eventId');
	echo form_label('eventId', 'eventId');
	echo '<br />';
	
	//echo $eventId;

	//echo form_dropdown('eventId', $eventId);
 
	echo form_submit('submit', 'Submit');
	
	echo form_close();
?>

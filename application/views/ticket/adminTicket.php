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
  <li><a href="<?php echo base_url(); ?>index.php/admin/">Home</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament/">Tournaments</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament/view/<?php echo $tournamentId ?>"><?php echo $tournament['name'] ?></a> <span class="divider">/</span></li> 
  <li class="active">Register for ticket</li>
</ul>
<h3>Register for ticket: <?php echo $tournament['name'] ?></h3>




<?php echo validation_errors(); ?>
<?php
	echo form_open("admin/ticket/addTicket", $attributes);
	//echo form_open('team/teamRegister/add');
	
	// form building
	$ticketType = array(
		'name'	=> 'ticketType',
		'id'	=> 'ticketType',
		'value' => $ticketType
	);
	$options = array(
                   'child'  => 'child',
                   'adult'    => 'adult',
                 );
	echo "<div class=\"control-group\">";
	echo form_label('Ticket Type', 'ticketType', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_dropdown('ticketType', $options, '');
 //form_input($ticketType);
	echo '</div></div>';
	
	$noTickets = array(
		'name'	=> 'noTickets',
		'id'	=> 'noTickets',
		'value' => $noTickets
	);

	echo "<div class=\"control-group\">";
	echo form_label('Number of Tickets', 'noTickets', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_input($noTickets);
	echo '</div></div>';
	
	$id = array(
		'name'	=> 'id',
		'id'	=> 'id',
		'value' => $tournamentId
	);
	
	echo form_hidden('id', $tournamentId);
	
	echo "<div class=\"control-group\">";
	echo "<div class=\"controls\">";
	echo form_submit('submit', 'Submit');
	
	echo form_close();

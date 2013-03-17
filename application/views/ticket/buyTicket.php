<script type="text/javascript">
$(function() {
$('#Date').datepicker({
numberOfMonths: 1,
dateFormat: 'yy-mm-dd',
beforeShowDay: checkAvailability

});
});


var $myBadDates =<?php echo json_encode($date111);?>;
function checkAvailability(mydate){
var $return1=false;
var $returnclass ="unavailable";
$checkdate = $.datepicker.formatDate('yy-mm-dd', mydate);
for(var i = 1; i <<?php echo $Alength; ?>+1; i++)
{ 
if($myBadDates[i] == $checkdate)
{
$return1 = true;
$returnclass= "available";
}
}
return [$return1,$returnclass];
}


</script>

<?php
$attributes = array('class' => 'form-horizontal');
$labelAttributes = array(
    'class' => 'control-label',
);
$btnAttributes = array(
    'class' => 'btn',
);
	foreach($ticket as $row)
	{
		$id= $row['ticketId'];
		$Tid = $row['tournamentId'];
		$tType= $row['ticketType'];
		$noTickets= $row['noTickets'];
		
	}
?>
<ul class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index.php/">Home</a> <span class="divider">/</span></li>
  <li class="active">Ticket</li>
</ul>
<h3>Ticket: <?php echo $Tournament ?></h3>
<?php echo validation_errors(); ?>
<?php

	echo form_open("ticket/buyticket/{$id}/{$Tournament}", $attributes);

	// form building

	$TicketId = array(
		'name'	=> 'TicketId',
		'id'	=> 'TicketId',
		'value' => $id
	);
	echo "<div class=\"control-group\">";
	echo form_hidden('TicketId',$id);
	echo '</div>';
	
	
	$checkdate = array(
		'name'	=> 'checkdate',
		'id'	=> 'checkdate',
		'value' => $date111
	);
	echo "<div class=\"control-group\">";
	echo form_hidden('checkdate',$date111);
	echo '</div>';
	
	$TournamentName = array(
		'name'	=> 'TournamentName',
		'id'	=> 'TournamentName',
		'value' => $Tournament
	);
	echo "<div class=\"control-group\">";
	echo form_hidden('TournamentName',$Tournament);
	echo '</div>';
 

	$quantity = array(
		'name'	=> 'quantity',
		'id'	=> 'quantity',
		'value' => $quantity
	);

	echo "<div class=\"control-group\">";
	echo form_label('Quantity', 'quantity', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_input($quantity);
	echo '</div></div>';
	
		$ticketType= array(
		'name'	=> 'ticketType',
		'id'	=> 'ticketType',
		'value' => $tType
	);
	
	echo "<div class=\"control-group\">";
	echo form_label('Type of ticket', 'ticketType', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_fieldset($tType);
	echo form_hidden('ticketType',$tType);
	echo '</div></div>';
	
	
	if($tType=="child")
	{
		$pValue=2.00;
	}
	else
	{
		$pValue=5.00;
	}
		$Price= array(
		'name'	=> 'Price',
		'id'	=> 'Price',
		'value' => $pValue
	);
	
	echo "<div class=\"control-group\">";
	echo form_label('Price for each', 'Price', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_fieldset($pValue);
	echo form_hidden('Price',$pValue);
	echo '</div></div>';

	$Date = array(
		'name'	=> 'Date',
		'id'	=> 'Date',
		'value' => $Date
	);
	
	echo "<div class=\"control-group\">";
	echo form_label('Date', 'Date', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_input($Date);
	echo '</div>';
	echo '</div>';	
	

	echo "<div class=\"control-group\">";
	echo "<div class=\"controls\">";
	echo form_submit('submit', 'Submit');
	
	echo form_close();
?>

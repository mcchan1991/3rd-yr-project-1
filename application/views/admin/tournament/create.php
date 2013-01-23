<script>
$(function() {
  $( "#startDate" ).datepicker({
    defaultDate: "+1w",
    changeMonth: false,
    numberOfMonths: 1,
	minDate: +0,
    onClose: function( selectedDate ) {
      $( "#startEnd" ).datepicker( "option", "minDate", selectedDate );
    }
  });
  $( "#endDate" ).datepicker({
    defaultDate: "+1w",
    changeMonth: false,
    numberOfMonths: 1,
	minDate: +0,
    onClose: function( selectedDate ) {
      $( "#startDate" ).datepicker( "option", "maxDate", selectedDate );
    }
  });
});
</script>
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
	  <li class="active">Add new tournament</li>
	</ul>
	<?php
	echo "<h3>Add new tournament</h3>";
	$errors = validation_errors();
	if (!empty($errors))
	{
	echo "<div class=\"alert alert-error\">";
	echo validation_errors();
	echo "</div>";
	}
	echo form_open('admin/tournament/save', $attributes);
}
else
{
	?>
	<ul class="breadcrumb">
	  <li><a href="<?php echo base_url(); ?>index.php/admin/">Admin Home</a> <span class="divider">/</span></li>
	  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament">Tournaments</a> <span class="divider">/</span></li>
	  <li class="active">Edit tournament: <?php echo $name; ?></li>
	</ul>
	<?php
	$url = base_url() . "index.php/admin/tournament/view/{$id}/";
	echo "<h3>Edit tournament: <a href=\"{$url}\">{$name}</a></h3>";
	$errors = validation_errors();
	if (!empty($errors))
	{
	echo "<div class=\"alert alert-error\">";
	echo validation_errors();
	echo "</div>";
	}
	echo form_open("admin/tournament/save/{$id}", $attributes);
}

?>

<?php
	// form building
	$name = array(
		'name'	=> 'name',
		'id'	=> 'name',
		'value' => $name
	);
	echo "<div class=\"control-group\">";
	echo form_label('Tournament name', 'name', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_input($name);
	echo '</div>';
	echo '</div>';
	
	$startDate = array(
		'name'	=> 'startDate',
		'id'	=> 'startDate',
		'value' => $startDate
	);
	
	echo "<div class=\"control-group\">";
	echo form_label('Start date', 'startDate', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_input($startDate);
	echo '</div>';
	echo '</div>';	
	
	$endDate = array(
		'name'	=> 'endDate',
		'id'	=> 'endDate',
		'value' => $endDate
	);
	
	echo "<div class=\"control-group\">";
	echo form_label('End date', 'endDate', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_input($endDate);
	echo '</div>';
	echo '</div>';
	
	$noTicketsField = array(
		'name'	=> 'noTickets',
		'id'	=> 'noTickets',
		'value' => $noTickets
	);
	
	echo "<div class=\"control-group\">";
	echo form_label('Number of tickets/day', 'noTickets', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_input($noTicketsField);
	echo '</div>';
	echo '</div>';
	
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
	echo "<div class=\"controls\">";
	echo form_submit($btnAttributes, 'Submit', 'submit');
	echo '</div>';
	echo '</div>';
	
	echo form_close();
<?php
$attributes = array('class' => 'form-horizontal');
$labelAttributes = array(
    'class' => 'control-label',
);
$btnAttributes = array(
    'class' => 'btn',
	'style' => 'margin-top: 15px;'
);

$eventTimesForm = array(
	'name'	=> 'eventTimes[]',
	'id'	=> 'eventTimes[]',
	'placeholder' => 'HH:MM',
	'value' => ""
);

//echo form_input($eventTimesForm);
$formOutput = "<div class=\"control-group\">";
$formOutput .= form_label('Start time', 'eventTimes', $labelAttributes);
$formOutput .= "<div class=\"controls\">";
$formOutput .= form_input($eventTimesForm);
$formOutput .= "<a href=\"#\" class=\"remove\" style=\"margin-left:5px;\">Remove</a>";
$formOutput .= '</div>';
$formOutput .= '</div>';
?>
<script>
var tournamentStart = $.datepicker.parseDate("yy-mm-dd",  "<?php echo $tournament['start']; ?>"); 
var tournamentEnd = $.datepicker.parseDate("yy-mm-dd",  "<?php echo $tournament['end']; ?>");

$(function() {
  $( "#regStart" ).datepicker({
    defaultDate: "+1w",
    changeMonth: true,
    numberOfMonths: 1,
	minDate: +0,
	maxDate: tournamentEnd,
	dateFormat: "dd/mm/yy",
    onClose: function( selectedDate ) {
	  if ($('#regStart').length > 0)
	  {$( "#regEnd" ).datepicker( "option", "minDate", selectedDate );}
	  else {$( "#regEnd" ).datepicker( "option", "maxDate", tournamentEnd );}
    }
  });
  $( "#regEnd" ).datepicker({
    defaultDate: "+1w",
    changeMonth: true,
    numberOfMonths: 1,
	minDate: +0,
	maxDate: tournamentEnd,
	dateFormat: "dd/mm/yy",
    onClose: function( selectedDate ) {
      if ($('#regEnd').length > 0)
	  {$( "#regStart" ).datepicker( "option", "maxDate", selectedDate ); var date2 = selectedDate; $( "#start" ).datepicker( "option", "minDate", date2 );}
	  else {$( "#regStart" ).datepicker( "option", "maxDate", tournamentEnd );}
    }
  });
  $( "#start" ).datepicker({
    defaultDate: "+1w",
    changeMonth: true,
    numberOfMonths: 1,
	minDate: +0,
	maxDate: tournamentEnd,
	dateFormat: "dd/mm/yy",
    onClose: function( selectedDate ) {
	  if ($('#start').length  > 0)
	  {$( "#end" ).datepicker( "option", "minDate", selectedDate );}
	  else {$( "#end" ).datepicker( "option", "maxDate", tournamentEnd );}
    },
  });
  $( "#end" ).datepicker({
    defaultDate: "+1w",
    changeMonth: true,
    numberOfMonths: 1,
	minDate: +0,
	minDate: tournamentStart,
	maxDate: tournamentEnd,
	dateFormat: "dd/mm/yy",
    onClose: function( selectedDate ) {
	  if ($('#end').length > 0)
	  {$( "#start" ).datepicker( "option", "maxDate", selectedDate );}
	  else {$( "#start" ).datepicker( "option", "maxDate", tournamentEnd );}
    }
  });
});

$(function () {
    var eventTimesDiv = $('#eventTimesDiv');
    var i = $('#eventTimesDiv label').size() + 1;

    $('#addInput').on('click', function () {
        $('<?php echo $formOutput;  ?>').appendTo(eventTimesDiv);
        i++;
        return false;
    });

    $(document).on('click', '.remove', function () {
        if (i > 2) {
            $(this).parent('div').parent('div').remove();
            i--;
        }
        return false;
    });
});

</script>
<?php 

if (empty($id))
{
	?>
	<ul class="breadcrumb">
	  <li><a href="<?php echo base_url(); ?>index.php/admin/">Admin Home</a> <span class="divider">/</span></li>
	  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament">Tournaments</a> <span class="divider">/</span></li>
	  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament/view/<?php echo $tournament['tournamentId'] ?>"><?php echo $tournament['name'] ?></a> <span class="divider">/</span></li>
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
	  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament/view/<?php echo $tournament['tournamentId'] ?>"><?php echo $tournament['name'] ?></a> <span class="divider">/</span></li>
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
	
	$sportOptions = array();
	foreach ($sports as $sportValue)
	{
		$sportOptions[$sportValue['sportId']] = $sportValue['sportName'];
	}

	echo "<div class=\"control-group\">";
	echo form_label('Sport', 'sport', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_dropdown('sport', $sportOptions, $sport);
	echo "</div> </div>";
	
	$genderOptions = array(
		'notset'  => 'Not set',
		'female'  => 'Female',
		'male'    => 'Male',
	);

	echo "<div class=\"control-group\">";
	echo form_label('Gender', 'gender', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_dropdown('gender', $genderOptions, $gender);
	echo "</div> </div>";
	
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
	
	echo "<h2>Scheduling settings</h2>";
	$durationField = array(
		'name'	=> 'duration',
		'id'	=> 'duration',
		'placeholder' => 'HH:MM',
		'value' => $duration
	);
	
	echo "<div class=\"control-group\">";
	echo form_label('Match/Race duration', 'duration', $labelAttributes);
	echo "<div class=\"controls\">";
	echo form_input($durationField);
	echo '</div>';
	echo '</div>';
	
	echo "<strong>Event match/race times</strong>";
	echo "<div id=\"eventTimesDiv\">";
	
	$loop = 0;
	if (count($eventTimes) != 0)
	{
		for ($i = 0; $i<count($eventTimes); $i++)
		{
			if (empty($eventTimes[$i]))
			{
				break;
			}
			else
			{
				$loop++;
			}
		}
	}
	if ($loop == 0)
	{
		$loop = 1;
	}
	
	for ($i = 0; $i<=$loop; $i++)
	{
		$value = "";
		if (!empty($eventTimes[$i]["start"]))
		{
			$value = $eventTimes[$i]["start"];
		}
		
		$eventTimesForm = array(
			'name'	=> 'eventTimes[]',
			'id'	=> 'eventTimes[]',
			'placeholder' => 'HH:MM',
			'value' => $value
		);

		echo "<div class=\"control-group\">";
		echo form_label('Start time', 'eventTimes', $labelAttributes);
		echo "<div class=\"controls\">";
		echo form_input($eventTimesForm);
		if ($i != 0) { echo "<a href=\"#\" class=\"remove\" style=\"margin-left:5px;\">Remove</a>"; }
		echo '</div>';
		echo '</div>';
	}
	echo "</div>";
	echo "<a href=\"#\" id=\"addInput\" style=\"margin-left:180px;\">Add another time</a>";
	echo "<br />";
	echo form_hidden('tournament', $tournament['tournamentId']);
	
	echo "<div class=\"control-group\">";
	echo "<div class=\"controls\">";
	echo form_submit($btnAttributes, 'Submit', 'submit');
	echo '</div>';
	echo '</div>';
	
	echo form_close();
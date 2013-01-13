<?php
/**
 * View for adding an umpire to an tournament
 *
 * Created: 13/01/2013
 * @author	Jacob Baungard Hansen <jeb14@hw.ac.uk>
 */

$attributes = array('class' => 'form-horizontal');
$labelAttributes = array(
    'class' => 'control-label',
);
$btnAttributes = array(
    'class' => 'btn',
);
if (empty($id))
{?>
	<ul class="breadcrumb">
	  <li><a href="<?php echo base_url(); ?>index.php/admin/">Admin Home</a> <span class="divider">/</span></li>
	  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament">Tournaments</a> <span class="divider">/</span></li>
	  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament/view/<?php echo $tournament['tournamentId']; ?>"><?php echo $tournament['name']; ?></a> <span class="divider">/</span></li>
	  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament/umpireList/<?php echo $tournament['tournamentId']; ?>">Umpires</a> <span class="divider">/</span></li>
	  <li class="active">Add umpire</li>
	</ul>
	<h3>Add new umpire</h3>
	
<?php 
$errors = validation_errors();
if (!empty($errors))
{
echo "<div class=\"alert alert-error\">";
echo validation_errors();
echo "</div>";
} 
echo form_open('admin/tournament/saveUmpire/' . $tournament['tournamentId'], $attributes);

} //END SCOPE: if (empty($id)) 
else
{
	?>
	
<?php } // END SCOPE: else

$umpireOptions = array();
foreach ($umpires as $umpire)
{
	$sport = $sports[$umpire['sport']-1]['sportName'];
	$umpireOptions[$umpire['umpireId']] = $umpire['firstName'] . " " . $umpire['surname'] . " / " . $sport;
}


echo "<div class=\"control-group\">";
echo form_label('Umpire', 'umpire', $labelAttributes);
echo "<div class=\"controls\">";
echo form_dropdown('umpire', $umpireOptions);
echo '</div>';
echo '</div>';

$dateForm = array(
	'name'	=> 'date',
	'id'	=> 'date',
	'value' => $date
);

echo "<div class=\"control-group\">";
echo form_label('Date', 'date', $labelAttributes);
echo "<div class=\"controls\">";
echo form_input($dateForm);
echo '<br />';
echo '</div>';
echo '</div>';

$from = array(
	'name'	=> 'from',
	'id'	=> 'from',
	'value' => $availableFrom
);

echo "<div class=\"control-group\">";
echo form_label('Available from', 'from', $labelAttributes);
echo "<div class=\"controls\">";
echo form_input($from);
echo '<br />';
echo '</div>';
echo '</div>';

$to = array(
	'name'	=> 'to',
	'id'	=> 'to',
	'value' => $availableTo
);

echo "<div class=\"control-group\">";
echo form_label('Available to', 'to', $labelAttributes);
echo "<div class=\"controls\">";
echo form_input($to);
echo '<br />';
echo '</div>';
echo '</div>';

//checkbox was causing some problems with bootstrap so did it manually.
?>
<div class="control-group">
<label class="checkbox">
<div class="controls">
  <input type="checkbox" name="allDay" id="allDay" value="1" <?php if ($checked == true){echo "checked";} ?>>
  Available all day
</div>
</label>
</div>

<?php
echo "<div class=\"control-group\">";
echo "<div class=\"controls\">";
echo form_submit($btnAttributes, 'Submit', 'submit');
echo '</div>';
echo '</div>';

echo form_close();
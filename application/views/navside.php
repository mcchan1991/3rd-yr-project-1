<?php
/**
 * Standard view for the sidebar in the administration area.
 * It shows a list of current tournaments and events
 *
 * Created: 13/01/2013
 * @author	Jacob Baungard Hansen <jeb14@hw.ac.uk>
 */
?>


<?php
// CURRENT
if (count($tournaments) != 0)
{
	echo "<li class=\"nav-header\">Current tournaments</li>";
}
foreach ($tournaments as $tournament)
{
?>
<?php
if (count($events[$tournament['tournamentId']]) > 0) {
?>
<li><?php echo $tournament['name']; ?></li>
<ul class="nav nav-list">
<?php 
	foreach($events[$tournament['tournamentId']] as $event)
	{
		$url = base_url() . "index.php/event/view/{$event['eventId']}";
		echo "<li><a href=\"{$url}\">{$event['name']}</a>";
	}
?>
</ul>	
<?php } }
?>

<?php
// PAST
if (count($pastTournaments) != 0)
{
	echo "<li class=\"nav-header\">Past tournaments</li>";
}
foreach ($pastTournaments as $tournament)
{
?>
<?php
if (count($pastEvents[$tournament['tournamentId']]) > 0) {
?>
<li><?php echo $tournament['name']; ?></li>
<ul class="nav nav-list">
<?php 
	foreach($pastEvents[$tournament['tournamentId']] as $event)
	{
		$url = base_url() . "index.php/event/view/{$event['eventId']}";
		echo "<li><a href=\"{$url}\">{$event['name']}</a>";
	}
?>
</ul>	
<?php } }
?>

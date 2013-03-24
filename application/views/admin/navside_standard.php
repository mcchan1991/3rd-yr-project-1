<?php
/**
 * Standard view for the sidebar in the administration area.
 * It shows a list of current tournaments and events
 *
 * Created: 13/01/2013
 * @author	Jacob Baungard Hansen <jeb14@hw.ac.uk>
 */
?>

<li class="nav-header">Current tournaments</li>
<?php
if (count($tournaments) == 0)
{
	echo "No current tournaments";
}
foreach ($tournaments as $tournament)
{
?>
<li><a href="<?php echo base_url() . "index.php/admin/tournament/view/{$tournament['tournamentId']}";?>"><?php echo $tournament['name']; ?></a></li>
<ul class="nav nav-list">
<?php 
	foreach($events[$tournament['tournamentId']] as $event)
	{
		$url = base_url() . "index.php/admin/event/view/{$event['eventId']}";
		echo "<li><a href=\"{$url}\">{$event['name']}</a>";
	}
?>
</ul>	
<?php }
?>

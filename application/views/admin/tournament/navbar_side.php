<?php
/**
 * View for the left navbar for tournament views.
 *
 * Created: 12/01/2013
 * @author	Jacob Baungard Hansen <jeb14@hw.ac.uk>
 */
?>
<li class="nav-header"><a href="<?php echo base_url() . "index.php/admin/tournament/view/{$tournament['tournamentId']}/"; ?>"><?php echo $tournament['name']; ?></a></li>
<li><a href="<?php echo base_url() . "index.php/admin/tournament/edit/{$tournament['tournamentId']}/"; ?>">Edit tournament</a></li>
<li><a href="<?php echo base_url() . "index.php/admin/tournament/viewEvents/{$tournament['tournamentId']}/"; ?>">Events</a></li>
<li><a href="<?php echo base_url() . "index.php/admin/tournament/umpireList/{$tournament['tournamentId']}/"; ?>">Umpires</a></li>
<li><a href="<?php echo base_url() . "index.php/admin/ticket/index/{$tournament['tournamentId']}/"; ?>">Tickets</a></li>

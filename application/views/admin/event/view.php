<ul class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index.php/admin/">Admin Home</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament">Tournaments</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament/view/<?php echo $tournament['tournamentId'] ?>"><?php echo $tournament['name'] ?></a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament/viewEvents/<?php echo $event['tournamentId']; ?>">Events</a> <span class="divider">/</span></li>
  <li class="active">Event: <?php echo $event['name']; ?></li>
</ul>
<h3>Event: <?php echo $event['name']; ?></h3>
<table class="table">
<tr>
	<th>Name</th>
	<td><?php echo $event['name']; ?></td>
</tr>
<tr>
	<th>Sport</th>
	<td><?php echo $sports[$event['sportId']-1]['sportName']; ?></td>
</tr>
<tr>
	<th>Start date</th>
	<td><?php echo $event['start']; ?></td>
</tr>
<tr>
	<th>End date</th>
	<td><?php echo $event['end']; ?></td>
</tr>
<tr>
	<th>Reg. start </th>
	<td><?php echo $event['regStart']; ?></td>
</tr>
<tr>
	<th>Reg. end</th>
	<td><?php echo $event['regEnd']; ?></td>
</tr>
<tr>
	<th>Max entries</th>
	<td><?php echo $event['maxEntries']; ?></td>
</tr>
<tr>
	<th>Min entries</th>
	<td><?php echo $event['minEntries']; ?></td>
</tr>
<tr>
	<th>Participents registered</th>
	<td><?php echo $noParticipents; ?></td>
</tr>
<tr>
	<th colspan="2">Description</th>
</tr>
<tr>
	<td colspan="2"> <?php echo $event['description']; ?> </tr>
</tr>
</table>
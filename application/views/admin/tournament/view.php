<ul class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index.php/admin/">Admin Home</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament">Tournaments</a> <span class="divider">/</span></li>
  <li class="active"><?php echo $tournament['name']; ?></li>
</ul>

<h3><?php echo $tournament['name']; ?></h3>
<table class="table">
<tr>
	<th>Name</th>
	<td><?php echo $tournament['name']; ?></td>
</tr>
<tr>
	<th>Start date</th>
	<td><?php echo $tournament['start']; ?></td>
</tr>
<tr>
	<th>End date</th>
	<td><?php echo $tournament['end']; ?></td>
</tr>
<tr>
	<th>No. tickets/day</th>
	<td><?php echo $tournament['noTickets']; ?></td>
</tr>
<tr>
	<th>No. events</th>
	<?php $url = base_url() . "index.php/admin/tournament/viewEvents/".$tournament['tournamentId']."/"; ?>
	<td><a href="<?php echo $url ?>"><?php echo $noEvents; ?></a></td>
</tr>
<tr>
	<th>Participents registered</th>
	<td>Coming soon...</td>
</tr>
</table>
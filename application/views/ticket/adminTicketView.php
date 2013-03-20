<?php
/**
 * 
 */

?>
<ul class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index.php/admin/">Admin Home</a> <span class="divider">/</span></li>
  <li class="active">Ticket</li>
</ul>
<h3>Ticket</h3>
<table class="table">
	<thead>
		<tr>
			<th>Ticket ID</th>
			<th>Tournament ID</th>
			<th>Ticket Type</th>
			<th>Number of Tickets</th>
		</tr>
	</thead>
	<tbody>
	<?php
		foreach($tickets as $ticket)
		{
			echo "<tr>";
			echo "<td>" . $ticket['ticketId'] . "</td>";
			echo "<td>" . $ticket['tournamentId'] . "</td>";
			echo "<td>" . $ticket['ticketType'] . "</td>";
			echo "<td>" . $ticket['noTickets'] . "</td>";
			echo "</tr>";
		}
		echo "</tbody>";
		
	?>
	<tfoot>
		<tr>
		<td colspan="6"><a href="<?php echo base_url() . "index.php/admin/ticket/register/{$id}/"; ?>">Add new ticket</a></td>
</table>


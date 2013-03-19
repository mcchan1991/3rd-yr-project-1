<?php
/**
 * 
 */

?>
<ul class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index.php/admin/">Admin Home</a> <span class="divider">/</span></li>
  <li class="active">Ticket Sale</li>
</ul>
<h3>Ticket Sale</h3>
<table class="table">

	<tbody>
	<?php
		$typeTotal=0;
		$typeTicketTotal=0;
		foreach($types as $type)
		{
			echo "<tr>";
			echo "<th>Type of ticket</th>";
			echo "<td>" .$type['ticketType']."</td>";
			foreach($typeData[$type['ticketType']] as $item)
			{
				$typeTicketTotal=$typeTicketTotal+$item['quantity'];
				$typeTotal=$typeTotal+($item['price']*$item['quantity']);
			}
			echo "<th>Number of ticket</th>";
			echo "<td>" .$typeTicketTotal."</td>";
			echo "<th>Sold</th>";
			echo "<td>£" .$typeTotal."</td>";
			echo "</tr>";
			$typeTotal=0;
			$typeTicketTotal=0;
		}
		$toalTicket=0;
		$TotalPrice=0;
		foreach($ticketsinfo as $items)
		{

				$TotalPrice= $TotalPrice+($items['quantity']*$items['price']);
				$toalTicket=$toalTicket+$items['quantity'];
		}
		?>
		<tr>
		<th></th>
		<td></td>
		<?php
		echo "<th>Total Number of Tickets Sold </th>";
		echo "<td>" .$toalTicket."</td>";
		echo "<th>Total Sold</th>";
		echo "<td>£" .$TotalPrice."</td>";
		echo "</tr>";
		?>
	<tfoot>
</table>

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
		$toalTicket=0;
		$TotalPrice=0;
		foreach($ticketsinfo as $items)
		{

				$TotalPrice= $TotalPrice+($items['quantity']*$items['price']);
				$toalTicket=$toalTicket+$items['quantity'];
		}
		echo "<tr>";
		echo "<th>Total Sold</th>";
		echo "<td>£" .$TotalPrice."</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<th>Total Number of Tickets Sold </th>";
		echo "<td>" .$toalTicket."</td>";
		echo "</tr>";
	?>
	<tfoot>
</table>

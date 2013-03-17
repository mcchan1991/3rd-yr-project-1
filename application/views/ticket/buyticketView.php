<ul class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index.php/">Home</a> <span class="divider">/</span></li>
  <li class="active">Ticket</li>
</ul>
<h3>Ticket</h3>
<table class="table" >
	<thead>
		<tr>
			<th style="text-align:center;">Tournament</th>
			<th style="text-align:center;">Ticket</th>
			<th style="text-align:center;">Number of ticket</th>
			<th style="text-align:center;">Price</th>
			<th style="text-align:center;">Buy item</th>
		</tr> 
	</thead>
	<tbody>
			<?php
		
		$i=0;
		$j=0;
		if(count($tickets)==0)
		{
			echo "<td style=\"text-align:center;\"> No ticket available</td>";
		}
		else
		{
			foreach ($tickets as $ticket)
			{
				echo "<tr>";
				echo "<td style=\"text-align:center;\">{$ticket['name']}</td>";
				echo "<td style=\"text-align:center;\">{$ticket['ticketType']}</td>";
				echo "<td style=\"text-align:center;\">{$ticket['noTickets']}</td>";
				echo "<td style=\"text-align:center;\">{$ticket['price']}</td>";
				$url = base_url() . "index.php/ticket/add/";
				echo "	<td style=\"text-align:center;\"><a href=\"{$url}{$ticket['ticketId']}/{$ticket['name']}\">buy</a></td>";
				echo "</tr>";
				$j++;
			}
		}
		
		

	?>
	
	
	</tbody>
</table>

<p>This screen will probably be redone where this is the archieve view, and the actual view have more details on it, for better accessibility especially when there are few planned tournaments, though this view will probably be planend if there are >2 active tournaments.</p>

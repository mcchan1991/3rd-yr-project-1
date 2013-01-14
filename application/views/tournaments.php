<ul class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index.php/">Home</a> <span class="divider">/</span></li>
  <li class="active">Tournaments</li>
</ul>
<h3>Tournaments</h3>
<table class="table" >
	<thead>
		<tr>
			<th>Name</th>
			<th style="text-align:center;">Sport</th>
			<th style="text-align:center;">Start date</th>
			<th style="text-align:center;">End date</th>
			<th style="text-align:center;">Reg. Start</th>
			<th style="text-align:center;">Reg. End</th>
		</tr> 
	</thead>
	<tbody>
	<?php
		foreach ($tournaments as $tournament)
		{
			$currentEvents = $events[$tournament['tournamentId']];
			echo "<tr class=\"info\">";
			echo "	<td colspan=\"1\"><strong>" . $tournament['name'] . "</strong></td>";
			echo "	<td colspan=\"5\"></td>";
			echo "</tr>";
			foreach ($currentEvents as $event)
			{
				$url = base_url() . "index.php/event/" . $event['eventId'];
				echo "<tr class=\"warning\"   data-provides=\"rowlink\">";
				echo "	<td><a href=\"{$url}\">{$event['name']}</a></td>";
				$sport = $sports[$event['sportId']-1]['sportName'];
				echo "	<td style=\"text-align:center;\"><a href=\"{$url}\" style=\"color:#333333;\">{$sport}</a></td>";
				echo "	<td style=\"text-align:center;\"><a href=\"{$url}\" style=\"color:#333333;\">{$event['start']}</a></td>";
				echo "	<td style=\"text-align:center;\"><a href=\"{$url}\" style=\"color:#333333;\">{$event['end']}</a></td>";
				echo "	<td style=\"text-align:center;\"><a href=\"{$url}\" style=\"color:#333333;\">{$event['regStart']}</a></td>";
				echo "	<td style=\"text-align:center;\"><a href=\"{$url}\" style=\"color:#333333;\">{$event['regEnd']}</a></td>";
				echo "</tr>";
			}
			if ($totalEventCount[$tournament['tournamentId']] > count($currentEvents))
			{
				echo "<tr class=\"warning\">";
				echo "<td colspan=\"6\" style=\"color:#333333;\" ><a href=\"#\">Total events: {$totalEventCount[$tournament['tournamentId']]} view all</a></td>";
				echo "</tr>";
			}
		}
	?>
	</tbody>
</table>
<?php echo $links; ?>
<?php
/**
 * View for showing which umpires are registered with a tournament
 *
 * Created: 13/01/2013
 * @author	Jacob Baungard Hansen <jeb14@hw.ac.uk>
 */
?>

<ul class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index.php/admin/">Admin Home</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament">Tournaments</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament/view/<?php echo $tournament['tournamentId']; ?>"><?php echo $tournament['name']; ?></a> <span class="divider">/</span></li>
  <li class="active">Umpires</li>
</ul>

<h3>Available umpires: <?php echo $tournament['name']; ?></h3>

<table class="table">
	<thead>
		<tr>
			<th>Name</th>
			<th>Date</th>
			<th>Available from</th>
			<th>Available to</th>
			<th>Sport</th>
			<th></th>
		</tr> 
	</thead>
	<tfoot>
		<tr>
			<td colspan="6">
			<a href="<?php echo base_url(); ?>index.php/admin/tournament/addUmpire/<?php echo $tournament['tournamentId']; ?>">Add new umpire</a>
			</td>
		</tr>
		<tr>
			<td colspan="6"><?php echo $links; ?></td>
		</tr>
	</tfoot>
	<tbody>
	<?php
		foreach ($umpires as $umpire)
		{
			echo "<tr>";
			echo "	<td>{$umpire['firstName']} {$umpire['surname']}</td>";
			
			echo "	<td>{$umpire['date']}</td>";
			
			$from = $umpire['availableFrom'];
			$to = $umpire['availableTo'];
			$dateFormat = "Y-m-d H:i:s";
			
			$fromObject = DateTime::createFromFormat($dateFormat, $from);
			$toObject = DateTime::createFromFormat($dateFormat, $to);
			
			$fromShow = $fromObject->format('H:i');
			$toShow = $toObject->format('H:i');
			
			if ($fromShow == "00:00" && $toShow == "23:59")
			{
				echo "	<td colspan=\"2\">All day</td>";
			}
			else
			{
				echo "	<td>{$fromShow}</td>";
				echo "	<td>{$toShow}</td>";
			}
			
			
			$sport = $sports[$umpire['sport']-1]['sportName'];
			echo "	<td>{$sport}</td>";
			echo "	<td><a href=\"#\">Edit</a>";
			echo "</tr>";
		}
	?>
	</tbody>
</table>
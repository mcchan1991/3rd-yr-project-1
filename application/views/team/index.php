<ul class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index.php/admin/">Home</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/tournaments">Tournaments</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/tournaments/view/<?php echo $tournament['tournamentId'] ?>"><?php echo $tournament['name'] ?></a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/event/view/<?php echo $event['eventId'] ?>"><?php echo $event['name'] ?></a> <span class="divider">/</span></li>
  <li class="active">Teams: <?php echo $event['name']; ?></li>
</ul>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<?php 
				// wattball
				if ($event['sportId'] == 1)
				{
					echo "<th>NWAID</th>";
					$no_cols = 2;
				}
				// hurdling
				if ($event['sportId'] == 2)
				{
					echo "<th>E-mail</th>";
					echo "<th>Date Of Birth</th>";
					echo "<th>Gender</th>";
					echo "<th>Fastest time</th>";
					$no_cols = 5;
				}
			
			?>
		</tr> 
	</thead>
	<tbody>
	<?php
		// wattball
		if ($event['sportId'] == 1)
		{
			foreach($registrations as $teams)
			{
				echo "<tr>";
				$url = base_url() . "index.php/team/".$teams['nwaId']."/";
				echo "<td><a href=\"{$url}\">{$teams['name']}</a></td>";
				echo "<td>{$teams['nwaId']}</td>";
				echo "</tr>";
			}
		}
		// hurdling
		if ($event['sportId'] == 2)
		{
			foreach($registrations as $athlete)
			{
				echo "<tr>";
				echo "<td>{$athlete['firstName']} {$athlete['surname']}</td>";
				echo "<td>{$athlete['email']}</td>";
				echo "<td>{$athlete['dob']}</td>";
				echo "<td>{$athlete['gender']}</td>";
				echo "<td>{$athlete['fastest']}</td>";
				echo "</tr>";
			}
		}
	?>
	</tbody>
</table>
<?php echo $links; ?>

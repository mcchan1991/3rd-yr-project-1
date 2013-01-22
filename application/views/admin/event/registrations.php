<ul class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index.php/admin/">Admin Home</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament">Tournaments</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament/view/<?php echo $tournament['tournamentId'] ?>"><?php echo $tournament['name'] ?></a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament/viewEvents/<?php echo $event['tournamentId']; ?>">Events</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/event/view/<?php echo $event['eventId']; ?>">Event: <?php echo $event['name']; ?></a> <span class="divider">/</span></li>
  <li class="active">Registrations</li>
</ul>
<h3>Registrations for: <?php echo $event['name']; ?></h3>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<?php 
				// wattball
				if ($event['sportId'] == 1)
				{
					$no_cols = 1;
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
	<tfoot>
		<tr>
			<td colspan="<?php echo $no_cols; ?>">
			<?php
			if ($event['sportId'] == 1)
			{
			}
			else if ($event['sportId'] == 2)
			{
				$gender = "";
				if ($event['gender'] == "male")
				{
					$gender = 1;
				}
				else 
				{
					$gender = 2;
				}
				$url = base_url() . "index.php/admin/event/registerAthlete/" . $event['eventId'] . "/" . $gender;
				echo "<a href=\"{$url}\">Register new athlete</a>";
			}
			?>
			</td>
		</tr>
	</tfoot>
	<tbody>
	<?php
		// wattball
		if ($event['sportId'] == 1)
		{
			
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
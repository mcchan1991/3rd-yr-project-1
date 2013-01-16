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

				}
				// hurdling
				if ($event['sportId'] == 2)
				{
					echo "<th>E-mail</th>";
					echo "<th>Date Of Birth</th>";
					echo "<th>Gender</th>";
					echo "<th>Fastest time</th>";
				}
			
			?>
		</tr> 
	</thead>
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
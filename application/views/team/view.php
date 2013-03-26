<div class="row-fluid">
	
	<div class="span2">
		<?php 
		if (isset($image))
		{
		?>
		<img src="<?php echo base_url() . "/uploads/" . $image;?>" class="img-rounded" />
		<?php
		}
		else
		{?>
		<img src="" class="img-rounded" />
		<?php }
		?>
	</div>
	
	<div class="span10">
		<h2><?php echo $teamName; ?></h2>
	</div>
	
</div>
<p>
<h3> Description </h3>
<?php 
	echo $team['description'];
?>
 </p>
<div class="row-fluid">
<table class="table table-striped">
  <caption><h4>Players</h4></caption>
  <thead>
    <tr>
      <th>First Name</th>
      <th>Surname</th>
	  <th>Shirt Number</th>
	  <th>Goals</th>
	  <th>Assists</th>
	  <th>Red Cards</th>
	  <th>Yellow Cards</th>
    </tr>
  </thead>
  <tbody>
  <?php
		foreach($players as $player)
		{
			echo "<tr>";
			echo "<td>" . $player['firstName'] . "</td>";
			echo "<td>" . $player['surname'] . "</td>";
			echo "<td>" . $player['shirtNo']. "</td>";
			if ($player['goals'] != NULL)
				echo "<td>" . $player['goals']. "</td>";
			else
				echo "<td> - </td>";
			if ($player['assists'] != NULL)
				echo "<td>" . $player['assists']. "</td>";
			else
				echo "<td> - </td>";
			if ($player['redCards'] != NULL)
				echo "<td>" . $player['redCards']. "</td>";
			else
				echo "<td> - </td>";	
			if ($player['yewllowCards'] != NULL)
				echo "<td>" . $player['yewllowCards']. "</td>";
			else
				echo "<td> - </td>";	
			echo "</tr>";
		}
	?>
  </tbody>
</table>
</div>



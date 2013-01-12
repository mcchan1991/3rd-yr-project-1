<?php
/**
 * Shows a list of all umpires including pagination.
 *
 * Created: 12/01/2013
 * @author	Jacob Baungard Hansen <jeb14@hw.ac.uk>
 */

?>
<ul class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index.php/admin/">Admin Home</a> <span class="divider">/</span></li>
  <li class="active">Umpires</li>
</ul>
<h3>Umpires</h3>
<table class="table">
	<thead>
		<tr>
			<th>First Name</th>
			<th>Surname</th>
			<th>DOB</th>
			<th>E-mail</th>
			<th>Sport</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php
		foreach($umpires as $umpire)
		{
			//echo print_r($umpire);
			echo "<tr>";
			echo "<td>" . $umpire['firstName'] . "</td>";
			echo "<td>" . $umpire['surname'] . "</td>";
			echo "<td>" . $umpire['DOB'] . "</td>";
			echo "<td>" . $umpire['email'] . "</td>";
			echo "<td>" . $sports[$umpire['sport']]['sportName'] . "</td>";
			$url = base_url() . "index.php/admin/umpire/edit/".$umpire['umpireId']."/";
			echo "<td><a href=\"{$url}\">Edit</a></td>";
			echo "</tr>";
		}
		echo "</tbody>";
		
	?>
	
</table>
<?php echo $links; ?>
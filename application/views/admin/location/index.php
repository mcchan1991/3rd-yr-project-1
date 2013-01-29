<?php
/**
 * Shows a list of all locations including pagination.
 *
 * Created: 12/01/2013
 * @author	Jonathan Val <jdv2@hw.ac.uk>
 */

?>
<ul class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index.php/admin/">Admin Home</a> <span class="divider">/</span></li>
  <li class="active">Locations</li>
</ul>
<h3>Locations</h3>
<table class="table">
	<thead>
		<tr>
			<th>Name</th>
			<th>Capactiy</th>
			<th>Lights</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php
		foreach($locations as $location)
		{
			echo "<tr>";
			echo "<td>" . $location['name'] . "</td>";
			echo "<td>" . $location['capacity'] . "</td>";
			echo "<td>" . ($location['lights']== 1 ? ' Yes' : 'No') . "</td>";
			$url = base_url() . "index.php/admin/location/edit/".$location['locationId']."/";
			echo "<td><a href=\"{$url}\">Edit</a></td>";
			echo "</tr>";
		}
		echo "</tbody>";
		
	?>
	<tfoot>
		<tr>
		<td colspan="6"><a href="<?php echo base_url() . "index.php/admin/location/add"; ?>">Add new Location</a></td>
</table>
<?php echo $links; ?>
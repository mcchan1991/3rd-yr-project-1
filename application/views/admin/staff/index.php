<?php
/**
 * Shows a list of all staff including pagination.
 *
 * Created: 12/01/2013
 * @author	Jonathan Val <jdv2@hw.ac.uk>
 */

?>
<ul class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index.php/admin/">Admin Home</a> <span class="divider">/</span></li>
  <li class="active">Staff</li>
</ul>
<h3>Staff</h3>
<table class="table">
	<thead>
		<tr>
			<th>User Name</th>
			<th>First Name</th>
			<th>Surname</th>
			<th>E-mail</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php
		foreach($staff as $st)
		{
			echo "<tr>";
			echo "<td>" . $st['username'] . "</td>";
			echo "<td>" . $st['firstname'] . "</td>";
			echo "<td>" . $st['surname'] . "</td>";
			echo "<td>" . $st['email'] . "</td>";
			$url = base_url() . "index.php/admin/staff/edit/".$st['staffId']."/";
			echo "<td><a href=\"{$url}\">Edit</a></td>";
			echo "</tr>";
		}
		echo "</tbody>";
		
	?>
	<tfoot>
		<tr>
		<td colspan="6"><a href="<?php echo base_url() . "index.php/admin/staff/add"; ?>">Add new staff</a></td>
</table>
<?php echo $links; ?>
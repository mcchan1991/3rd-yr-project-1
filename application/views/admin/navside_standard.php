<li class="nav-header">Current tournaments</li>
<?php
if (count($tournaments) == 0)
{
	echo "No current tournaments";
}
foreach ($tournaments as $tournament)
{
?>
<li><a href="<?php echo base_url() . "index.php/admin/tournament/view/{$tournament['tournamentId']}";?>"><?php echo $tournament['name']; ?></a></li>
<ul class="nav nav-list">
<li><a href="#">Event 1</a></li>
<li><a href="#">Event 2</a></li>
</ul>	
<?php }
?>

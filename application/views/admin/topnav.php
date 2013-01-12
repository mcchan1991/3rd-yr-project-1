<?php
/**
 * View for top navigation in the administration area.
 *
 * Created: 12/01/2013
 * @author	Jacob Baungard Hansen <jeb14@hw.ac.uk>
 */

?>
<ul class="nav">
  <li <?php if ($segment == "home") { echo "class=\"active\""; } ?> ><a href="<?php echo base_url(); ?>index.php/admin/">Home</a></li>
  <li <?php if ($segment == "tournament") { echo "class=\"active\""; } ?>><a href="<?php echo base_url(); ?>index.php/admin/tournament">Tournaments</a></li>
  <li <?php if ($segment == "umpire") { echo "class=\"active\""; } ?>><a href="<?php echo base_url(); ?>index.php/admin/umpire">Umpires</a></li>
  <li <?php if ($segment == "staff") { echo "class=\"active\""; } ?>><a href="<?php echo base_url(); ?>index.php/admin/staff">Staff</a></li>
  <li <?php if ($segment == "location") { echo "class=\"active\""; } ?>><a href="<?php echo base_url(); ?>index.php/admin/location">Locations</a></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/logout">Logout</a></li>
</ul>

<?php
/**
 * View for top navigation in the public area.
 *
 * Created: 13/01/2013
 * @author	Jacob Baungard Hansen <jeb14@hw.ac.uk>
 */

?>
<ul class="nav">
  <li <?php if ($segment == "home") { echo "class=\"active\""; } ?> ><a href="<?php echo base_url(); ?>index.php/">Home</a></li>
  <li <?php if ($segment == "tournaments") { echo "class=\"active\""; } ?>><a href="<?php echo base_url(); ?>index.php/tournaments">Tournaments</a></li>
  <li <?php if ($segment == "ticket") { echo "class=\"active\""; } ?>><a href="#">Buy Tickets</a></li>
  <li <?php if ($segment == "about") { echo "class=\"active\""; } ?>><a href="#">About Us</a></li>
  <li <?php if ($segment == "contact") { echo "class=\"active\""; } ?>><a href="#">Contact</a></li>
</ul>

<form class="form-inline" style="height:10px; margin-top:2px; float:right;">
  <input type="text" class="input-small" placeholder="Email">
  <input type="password" class="input-small" placeholder="Password">
  <button type="submit" class="btn btn-small" style="margin-bottom:5px;">Sign in</button>
</form>

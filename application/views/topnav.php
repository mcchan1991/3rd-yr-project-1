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
   <li <?php if ($segment == "ticket") { echo "class=\"active\""; } ?>><a href="<?php echo base_url(); ?>index.php/ticket">Buy Tickets</a></li>
  <li <?php if ($segment == "about") { echo "class=\"active\""; } ?>><a href="#">About Us</a></li>
  <li <?php if ($segment == "contact") { echo "class=\"active\""; } ?>><a href="#">Contact</a></li>
</ul>


<?php if($this->session->userdata('nwaId')!= NULL ): ?>
<div class="text" style="float:right;margin-top:7pt; "> Welcome <a href="<?php echo base_url(); ?>index.php/team/welcome"><?php echo $team ?> </a></div>
<?php else: ?>

<?php
	$attributes = array('class' => 'form-inline',
	'style' => 'height:10px; margin-top:2px; float:right');
	echo form_open('team/verifyTeamLogin/teamLogin', $attributes);
	$data = array(
              'name'        => 'email',
              'id'          => 'email',
              'class'       => 'input-small',
			  'placeholder' => 'Email'
            );
	echo form_input($data);
	$data = array(
              'name'        => 'password',
              'id'          => 'password',
              'class'       => 'input-small',
			  'placeholder' => 'Password'
            );
	echo form_password($data);
	$data = array(
              'name'        => 'submit',
              'id'          => 'submit',
              'class'       => 'btn btn-small',
			  'style' => 'margin-bottom:5px;margin-left:5px'
            );
	echo form_submit($data,'Sign in');
	
	echo form_close();
?>

<?php endif; ?>
<ul class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index.php/admin/">Home</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/tournaments">Tournaments</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/tournaments/view/<?php echo $tournament['tournamentId'] ?>"><?php echo $tournament['name'] ?></a> <span class="divider">/</span></li>
  <li class="active">Event: <?php echo $event['name']; ?></li>
</ul>
<h3><?php echo $event['name']; ?></h3>
<div><?php echo $event['description'];?></div>
<ul class="breadcrumb">
  <li><a href="<?php echo base_url(); ?>index.php/admin/">Admin Home</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament">Tournaments</a> <span class="divider">/</span></li>
  <li><a href="<?php echo base_url(); ?>index.php/admin/tournament/view/<?php echo $tournament['tournamentId'] ?>"><?php echo $tournament['name'] ?></a> <span class="divider">/</span></li>
  <li class="active">Edit Event: <?php echo $event['name']; ?></li>
</ul>

<?php

$labelAttributes = array(
    'class' => 'control-label',
);
$btnAttributes = array(
    'class' => 'btn',
	'style' => 'margin-top: 15px;'
);
$attributes = array('class' => 'form-vertical');

$form = form_dropdown('team[]', $teams, NULL, 'class="input-small"');


echo $form;
<li class="nav-header"><a href="<?php echo base_url() . "index.php/admin/event/view/{$event['eventId']}/"; ?>"><?php echo $event['name']; ?></a></li>
<li><a href="<?php echo base_url() . "index.php/admin/event/edit/{$event['eventId']}/"; ?>">Edit Event</a></li>
<li><a href="#">Schedule</a></li>
<li><a href="<?php echo base_url() . "index.php/admin/event/viewRegistrations/{$event['eventId']}/"; ?>">Registrations</a></li>
<li><a href="#">Results</a></li>
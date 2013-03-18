<li><a href="<?php echo base_url() . "index.php/admin/event/view/";?>">Event info</a></li>
<li><a href="<?php echo base_url() . "index.php/event/schedule/{$event['eventId']}"; ?>">Schedule</a></li>
<li><a href="#">Rankings</a></li>
<li><a href="<?php echo base_url() . "index.php/event/schedule/{$event['eventId']}/1/1"; ?>">Results</a></li>
<?php
if ($sport == 1)
{
	$string = "Teams";
} 
else
{
	$string = "Athletes";
}

$registerUrl = "";
if ($sport == 1)
{
		$registerUrl = base_url() . "index.php/team/teamRegister/register/{$event['eventId']}";
}
else
{
	if ($event['gender'] == "male")
	{
		$gender = 1;
	}
	else
	{
		$gender = 2;
	}
	$registerUrl = base_url() . "index.php/athlete/register/{$gender}/{$event['eventId']}";
}
?>
<li><a href="#"><?php echo $string; ?></a></li>
<li><a href="<?php echo $registerUrl; ?>">Register</a></li>

<li><a href="<?php echo base_url() . "index.php/team/verifyTeamLogin/teamLogin/{$event['eventId']}";; ?>">Team Login</a></li>

<!-- athlete/register/1/2 -->

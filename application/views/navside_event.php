<li><a href="<?php echo base_url() . "index.php/event/view/{$event['eventId']}";?>">Event info</a></li>
<li><a href="<?php echo base_url() . "index.php/event/schedule/{$event['eventId']}"; ?>">Schedule</a></li>
<li><a href="<?php echo base_url() . "index.php/event/showRankings/{$event['eventId']}"; ?>">Rankings</a></li>
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
		$registerUrl = base_url() . "index.php/team/verifyTeamLogin/teamLogin/{$event['eventId']}";
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
<li><a href="<?php echo base_url() . "index.php/teamview/teamlist/{$event['eventId']}"; ?>"><?php echo $string; ?></a></li>
<li><a href="<?php echo $registerUrl; ?>">Register</a></li>


<!-- athlete/register/1/2 -->

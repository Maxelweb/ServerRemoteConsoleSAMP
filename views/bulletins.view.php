<?php
/*
 *
 *  SERVER REMOTE CONSOLE
 *  View - Bulletins managament page
 *  
 *  Developed by Maxel (marianosciacco.it)
 *  Github - src.debug.ovh
 *
 */
?>

<a href="?" class="badge badge-secondary">&laquo; Go back to Home</a>
<h3 class="my-3"><i class='far fa-newspaper'></i> Bulletins Management </h3>

<p><b>From this section you can add, edit or remove server bulletins.</b> Bulletins are usually used in case of important technical update or server issues.</p>

<ul class="nav nav-tabs my-3">
  <li class="nav-item">
    <a class="nav-link <?=!isset($_GET['add']) && !isset($_GET['list']) && !isset($_GET['delete'])?"active":"";?>" href="?bulletins"><i class="fa fa-tachometer-alt"></i> Dashboard</a>
  </li>
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle text-info <?=isset($_GET['list'])?"active":"";?>" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-list-ul"></i> List Bulletins</a>
    <div class="dropdown-menu">
      <a class="dropdown-item" href="?bulletins&list">Order by Newest</a>
      <a class="dropdown-item" href="?bulletins&list&ord=1">Order by Oldest</a>
      <a class="dropdown-item" href="?bulletins&list&ord=2">Order by Priority (highest)</a>
      <a class="dropdown-item" href="?bulletins&list&ord=3">Order by Priority (lowest)</a>
    </div>
  </li>
  <li class="nav-item">
    <a class="nav-link text-success <?=isset($_GET['add'])?"active":"";?>" href="?bulletins&add"><i class="fa fa-plus-circle"></i> Add a new bulletin</a>
  </li>
</ul>


<?php if(isset($_GET['list'])) { 

	if($ord == 1) echo "<p class='text-muted'>Bulletins are ordered by the oldest.";
	elseif($ord == 2) echo "<p class='text-muted'>Bulletins are ordered by priority (highest).";
	elseif($ord == 3) echo "<p class='text-muted'>Bulletins are ordered by priority (lowest).";
	else echo "<p class='text-muted'>Bulletins are ordered by the newest.";
	$bull = new Status();
	$bull->ListAdmin($ord);

} elseif(isset($_GET['edit'], $_GET['file'])) { ?>

<form action='?bulletins&edit&file=<?=$f;?>&a=1' method='post' class="form-control">
	<h4 class="my-3">Edit Bulletin</h4>
	<?php 

		$Bull = new Bulletin($f.BULL_EXTENSION);

		echo "<b>Date:</b> " . $Bull->Datetime() . "<br><br>";

		ShowPriority($Bull->getPriorityId());

	?>
	<textarea class="form-control my-3" rows="4" name="content" maxlength="1024" placeholder="Edit here the message. Maximum 1024 characters."><?=$Bull->getContent();?></textarea>
	<button class='btn btn-warning' type='submit'>Edit bulletin <span class="fa fa-pencil-alt"></span></button>
</form>

<?php } elseif(isset($_GET['add'])) { ?>

<form action='?bulletins&add&a=1' method='post' class="form-control">
	<h4 class="my-3">New Bulletin</h4>
	<?php 
		ShowPriority(0); // Default priority: Status Update (0)
	?>
	<textarea class="form-control my-3" rows="4" name="content" maxlength="1024" placeholder="Write here a short message for status update or server issues. Maximum 1024 characters."></textarea>
	<button class='btn btn-success' type='submit'>Add new bulletin <span class="fa fa-plus-circle"></span></button>
</form>

<?php } else { 

	echo "<br>";

	if(!$gpage->EnableStatus) 
		$Al = Alert("The status block is actually <u>not visible</u> to guests.", 0, 1);
	else 
		$Al = Ok("The status block is actually visible to guests", 0,1);

	$Status = new Status();
	$tot = $Status->getTotalBulletins(); 
	if($tot)
	{
		$Last = new Bulletin($Status->getLastBulletin());
		$days = (int)((time()-$Last->getTimestamp())/86400);
		$days = $days < 1 ? "less than one day ago" : ($days == 1 ? $days." day ago" : $days." days ago");
	}
	else $days = "N/A";

	echo "<br><br><i class='fa fa-newspaper'></i> There are currently <b>".$tot." bulletins</b> published. ";
	if($tot>100) Alert("You have more than 100 bulletins. Consider to delete some of the <a href='?bulletins&list&ord=1'>oldest bulletins</a>.", 0, 1);
	echo "<br><i class='fa fa-clock'></i> The last bulletin has been submitted <b>".$days.".</b><br><br>";

	$query = new SampQuery(IP_SERVER, PORT_SERVER);
	if(!$query->connect())
		 No("<i class='fa fa-server'></i> The server is not responding or it may be offline! <a href='?bulletins&add'><i>Send a new bulletin</i></a> to inform your players about server issues!<br><br>");
	$query->close();

 } ?>
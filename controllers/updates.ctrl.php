<?php

	ini_set("allow_url_fopen", 1);
	$json = file_get_contents('http://src.debug.ovh/updates.php');
	$obj = json_decode($json);
	$NewVersion = $obj->version;
	$Release = $obj->releaseDate;

	if($NewVersion != $version && $json)
	{
		echo '<div class="alert alert-warning" role="alert">';
		echo "<i class='fa fa-bell'></i> ($Release) A new version of the <b>SERVER REMOTE CONSOLE</b> is available! <span class='badge badge-warning'>$version</span> --> <span class='badge badge-info'>$NewVersion</span>";
		echo "<br><i class='fab fa-github'></i> Please, consider to <a href='$GithubRepo'>update</a> in order to fix bugs and improve new features.";
		echo "<hr><b>Description:</b> ".$obj->description;
	}
	else
	{
		echo '<div class="alert alert-success" role="alert">';
		echo "<i class='fa fa-check'></i> Your version (<b>$version</b>) is up to date ($lastupdate). No action required.";
	}

		echo '</div>';



?>
<?php
/*
 *
 *  SERVER REMOTE CONSOLE
 *  View - Status / Guest Page
 *  
 *  Developed by Maxel (marianosciacco.it)
 *  Github - src.debug.ovh
 *
 */
?>


<h3 class="text-muted mb-3 mt-4">&nbsp;<i class="fa fa-server"></i> <?=$gpage->ServerName;?></h3>

<script type="text/javascript">
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

</script>

<!-- Main Information -->
<div class="row jumbotron mx-1 p-2">
  <div class="col-md-6">
<?php if($sStatus) { ?>
    <div class="card my-3">
      <div class="card-body">
        <h4 class="card-title"><a href="samp://<?=IP_SERVER;?>"><?=$sHostname;?></a></h4>
        <a href="http://<?=$sUrl;?>" class="h5"><i class="fa fa-link small"></i> <?=strtolower($sUrl);?></a>
        &nbsp; <code><?=IP_SERVER.":".PORT_SERVER;?></code>
        <p class="card-text my-2">
          <span class="badge badge-primary"><i class="fa fa-users"></i> <?=$sTotPlayers;?> players</span>
          <span class="badge badge-warning"><i class="fa fa-clock"></i> <?=$sVersion?></span>
          <span class="badge badge-light"><i class="fa fa-server"></i> <?=$sGamemode;?></span>
          <span class="badge badge-success"><i class="fa fa-globe"></i> <?=$sMap;?></span>
        </p>
      </div>
    </div>
<?php } 
  if(!$gpage->ShowPlayersList) echo "</div><div class='col-md-6'>";?>
    <div class="card bg-<?=$sColor;?> text-white my-3">
      <div class="card-body">
        <h4 class="card-title"><i class="fa fa-<?=$sIcon;?>"></i> <?=$ServerStatus;?></h4>
        <p class="card-text"><?=$sDesc?></p>
      </div>
    </div>
  </div>
  <!-- Detailed Information -->
  <?php if($gpage->ShowPlayersList && $sStatus) { ?>
  <div class="col-md-6">
  	<div class="card my-3">
      <div class="card-header clearfix">
        <span class="float-left"><i class="fa fa-users"></i> Players</span> 
        <span class="float-right"><span class=" badge badge-info">Score <i class="far fa-star"></i></span></span>
      </div>
      <?=$PlayerBlock;?>
  	</div>
  </div>
  <?php } ?>
</div>
<?php if($gpage->EnableStatus) { ?>
<h4 class="text-muted my-3">&nbsp;<i class="fa fa-newspaper"></i> Bulletins Tracker</h4>
<!-- Issues tracker-bar -->
<div class="row">
	<div class="col-md-12">
    <select class="custom-select custom-select-lg mb-3" onChange='window.location="?id=" + this.value;'>
      <option <?=!$id?"selected":"";?> value="0">7 days ago</option>
      <option <?=$id==1?"selected":"";?> value="1">14 days ago</option>
      <option <?=$id==2?"selected":"";?> value="2">21 days ago</option>
      <option <?=$id==3?"selected":"";?> value="3">30 days ago</option>
      <option <?=$id==4?"selected":"";?> value="4">All older bulletins</option>
    </select>
    <?php if($id==4) $Bulletins->ListNormal(); else { ?>
    <?=$Bulletins->ShowStatusBar($Days);?>
	</div>
</div>
<!-- Detailed issues with calendar -->
<div class="row">
	<div class="col-md-12">
    <?=$Bulletins->ListAsCalendar($Days);?>
    <?php } ?>
	</div>
</div>
<?php } ?>


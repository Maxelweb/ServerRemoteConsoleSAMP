<?php

/*
 *
 *  SERVER REMOTE CONSOLE
 *  Controller - Bulletins Management
 *  
 *  Developed by Maxel (marianosciacco.it)
 *  Github - src.debug.ovh
 *
 */


	$f = $f.BULL_EXTENSION;
		
		if(isset($_GET['delete']))
		{
			if((!file_exists(BULL_FOLDER.$f) || !unlink(BULL_FOLDER.$f)))
			{
				No("An error has occurred while deleting the bulletin. Please make sure to give all the necessary permissions to <code>/store</code> folder.");
			}
			else
			{
				Ok("The bulletin has been deleted successfully. <a href='?bulletins&list&ord=$ord'>Continue to Bulletins' List</a>");
			}
		}
		else
		{

			$content = $_POST['content'];
			$priority = $_POST['priority'];

			if($content == "")
			{
				No("No content has been submitted. Please write something before submitting the bulletin.");
			}
			elseif(strlen($content) > 1024)
			{
				No("Content too long, please reduce the message to 1024 characters.");
			}
			elseif(isset($_GET['add']))
			{
				$Bull = new Status();
				$Last = new Bulletin($Bull->getLastBulletin());
				if($Last->getTimestamp() > (time()-120))
					No("Wait for about 2 minutes before sending another bulletin update.");
				else
				{
					$filename = time()."_".$priority.".txt";
					$handle = fopen(BULL_FOLDER.$filename, "w");
					$hwrite = fwrite($handle, $content);
					fclose($handle);

					if(!$handle || !$hwrite)
						No("An error has occurred while submitting the new bulletin. Please make sure to give all the necessary permissions to <code>/store</code> folder.");
					else
						Ok("The new bulletin has been submitted! <a href='?bulletins&list'>Go to bulletins' list</a>");
				}
			}
			elseif(isset($_GET['edit']))
			{		
				if(!file_exists(BULL_FOLDER.$f))
				{
					No("An error has occurred while editing the bulletin. Please make sure to give all the necessary permissions to <code>/store</code> folder.");
				}
				else
				{
					$Bull = new Bulletin($f);
					$hdel = unlink(BULL_FOLDER.$f);
					$filename = $Bull->getTimestamp()."_".$priority.BULL_EXTENSION;
					$handle = fopen(BULL_FOLDER.$filename, "w");
					$hwrite = fwrite($handle, $content);
					fclose($handle);
					
					if(!$handle || !$hwrite || !$hdel)
						No("An error has occurred while editing the bulletin. Please make sure to give all the necessary permissions to <code>/store</code> folder.");
					else
					{
						Ok("The bulletin has been updated! <a href='?bulletins&list'>Go to bulletins' list</a>");
						$f = CleanFileExt($filename); // !! IMPORTANT
					}
				}
			}
		}

		echo "<br><br>";


?>
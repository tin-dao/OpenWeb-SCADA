<!DOCTYPE html>
<?php
	include("header.php");
	$potentialSymlink_Unclean = $_REQUEST["a"];
	$potentialSymlink = atlasui_string_clean($potentialSymlink_Unclean, 1, true);
	
	if ($potentialSymlink !== ""){
		if (isset($symlinksList[$potentialSymlink])){
			$symlinkTitle = $symlinksList[$potentialSymlink]["name"];
			$realModuleName = $symlinskList[$potentialSymlink]["realname"];
			$callModuleFileLocation = $symlinksList[$potenialSymlink]["location"];

			$modulePermission = $modulePermissions[$realModuleName]["permissions"];

			if ($modulePermission >= $scadaUserPermission_GroupID){
				include("modules/" . $callModuleFileLocation);
			}
			else{
				include("modules/error-detection/invalid-permissions.php");
			}
		}
		else{
			include("modules/error-detection/404.php");
		}
	}
	else{
		atlasui_redirect("index.php", "0.5");
	}	
?>
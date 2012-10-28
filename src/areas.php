<?php
	$modulePermissions_Encoded = file_get_contents("conf/module_permissions.json");
	$symlinks_Encoded = file_get_contents("conf/symlinks.json");
	$modulePermissions = json_decode($modulePermissions_Encoded, true);
	$symlinksList = json_decode($symlinks_Encoded, true);

    include("Framework/framework.php");

	$potentialSymlink_Unclean = $_GET["a"];
	$potentialSymlink = strtolower(atlasui_string_clean($potentialSymlink_Unclean, 1, true));
	
	if ($potentialSymlink !== ""){
		if (empty($symlinksList[$potentialSymlink]) == false){
			$symlinkTitle = $symlinksList[$potentialSymlink]["name"];
			$moduleFileLocation = $symlinksList[$potentialSymlink]["location"];
			$modulePermission = $modulePermissions[$potentialSymlink]["permissions"];

			if ($modulePermission <= $scadaUserPermission_GroupID){
				print "<title>$symlinkTitle</title>";
				include("modules/" . $moduleFileLocation);
			}
			else{
				include("modules/error-detection/invalid-permissions.php");
			}
		}
		else{
			include("modules/error-detection/http_errors/404.php");
		}
	}
	else{
		include("modules/error-detection/http_errors/404.php");
	}	
?>
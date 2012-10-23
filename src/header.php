<!DOCTYPE html>
<html>
    <head>
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/jqueryui.js"></script>
        <link rel="stylesheet" type="text/css" href="css/main.css" />
    </head>
    <body>
        <?php

            $configContent_Encoded = file_get_contents("/conf/config.json");
			$modulePermissions_Encoded = file_get_contents("/conf/module_permissions.json");
			$symlinks_Encoded = file_get_contents("/conf/symlinks.json");
            $decodedConfig = json_decode($configContent, true, 3);
			$modulePermissions = json_decode($modulePermissions_Encoded, true, 3);
			$symlinksList = json_decode($symlinks_Encoded, true, 3);
            
            include("Framework/framework.php");
            //include("functions/repetitiveFunctions.php");
            
            /* Connection Setup */
            
            $ftpServer = $decodedConfig["connection"]["ftp_server"];
            $ftpEnableSSL = $decodedConfig["connection"]["ftp_enable_ssl"];
            $ftpUsername = $decodedConfig["connection"]["ftp_username"];
            $ftpPassword = $decodedConfig["connection"]["ftp_password"];
            
			if (($ftpUsername !== "example_username") || ($ftpServer !== "")){
            	$ftpAccesser = atlasui_ftp_login($ftpServer, $ftpEnableSSL, $ftpUsername, $ftpPassword);
			}
            
            /* End of Connection Setup */
            
            $date = date("Y-m-d");
            $time = date("G:i");

            $scadaUser = $_COOKIE["openweb-scada"];

            if (isset($scadaUser)){
                
                $userData_Encoded = file_get_contents("/users/$scadaUser.json");
				$userData = json_decode($userData_Encoded, true, 3);

				/* Set User Variables */

				$scadaUserAvatar = $userData["general"]["avatar"];
				$scadaUserName = $userData["general"]["name"];
				$scadaUserPermission_GroupID = $userData["permissions"]["group_id"];

				/* End of Setting User Variables */

				/* Construct Header, Module Detection, Notification System */

				print "<div class=\"scadaHeader\">";
					print "<a href=\"home\" id=\"scadaHeaderHome\">OpenWeb SCADA</a>";
					
					/* Module Detection */

						$numberOfModules_OnNavigation = 0;
						$extraModules_NavigationArray = array();
						$installedModules = scandir("/modules");
						
						foreach ($installedModules as $key => $installedModule_FolderName){
							if (substr_count($installedModule_FolderName, ".") < 1){
								$moduleJson_Encoded = file_get_contents("/modules/$installedModule_FolderName/module.json");
								$moduleJson = json_decode($moduleJson, true, 4);
								$moduleName = $moduleJson["module_info"]["name"];
								$moduleAccessibility = $modulePermissions[$moduleName]["permissions"]["minimum_id"];
								
								foreach ($moduleJson["files"]["file"] as $key => $individualFile_Details){
									if ($moduleAccessibility <= $scadaUserPermission_GroupID){
										if ($individualFile_Details["displayOnNav"] == "true"){
											$numberOfModules_OnNavigation = $numberOfModules_OnNavigation + 1;
	
											if ($numberOfModules_OnNavigation <= 5){
												print "<label onclick=\"navigateToModule('/modules/$installedModule_FolderName/" . $individualFile_Details["location"] . "')\">";
													print $individualFile_Details["name"];
												print "</label>";
											}
											else{
												$extraModules_NavigationArray[] = $individualFile_Details["name"] . "||/modules/$installedModule_FolderName/" . $individualFile_Details["location"] . "'\">";
											}
										}
									}
								}
							}
						}

						if ($numberOfModules_OnNavigation > 5){
							print "<button onclick=\"showMore()\">";
							print "<div class=\"showMoreNavigation\">";
								foreach ($extraModules_NavigationArray as $key => $navigationLinkData){
									$navigationData = explode("||", $navigationLinkData);
									print "<a href=\"" . $navigationData["1"] . "\">" . $navigationData["0"] . "</a>";
								}
							print "</div>";
						}

					/* End of Module Detection */
            }
            else{
                header("Location: login");
            }

        ?>
    </body>
</html>
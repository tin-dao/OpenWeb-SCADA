<!DOCTYPE html>
<html>
    <head>
    	<script type="text/javascript" src="js/main.js"></script>
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/jqueryui.js"></script>
        <link rel="stylesheet" type="text/css" href="css/main.css" />
    </head>
    <body>
        <?php

            $configContent_Encoded = file_get_contents("conf/config.json");
			$modulePermissions_Encoded = file_get_contents("conf/module_permissions.json");
			$symlinks_Encoded = file_get_contents("conf/symlinks.json");
            $decodedConfig = json_decode($configContent_Encoded, true);
			$modulePermissions = json_decode($modulePermissions_Encoded, true);
			$symlinksList = json_decode($symlinks_Encoded, true);
            
            include("Framework/framework.php");
            //include("functions/repetitiveFunctions.php");
            
            /* Connection Setup */
            
            $ftpServer = $decodedConfig["connection"]["ftp_server"];
            $ftpEnableSSL = $decodedConfig["connection"]["ftp_enable_ssl"];
            $ftpUsername = $decodedConfig["connection"]["ftp_username"];
            $ftpPassword = $decodedConfig["connection"]["ftp_password"];

			if ($ftpUsername !== "example_username"){
            	$ftpAccesser = atlasui_ftp_login($ftpServer, $ftpEnableSSL, $ftpUsername, $ftpPassword);
			}
            
            /* End of Connection Setup */
            
            $date = date("Y-m-d");
            $time = date("G:i");

            $scadaUser = $_COOKIE["openweb-scada"];

            if (isset($scadaUser)){
                $userData_FileName = substr($scadaUser, 0, 16);
                $userData_Encoded = file_get_contents("users/$userData_FileName.json");
				$userData = json_decode($userData_Encoded, true);

				/* Set User Variables */

				$scadaUserAvatar = $userData["general"]["avatar"];
				$scadaUserName = $userData["general"]["name"];
				$scadaUserPermission_GroupID = $userData["permissions"]["group_id"];

				/* End of Setting User Variables */

				/* Construct Header from Symlinks and Create User Header */

				print "<div class=\"scadaHeader\">";
					print "<a href=\"index\" id=\"scadaHeaderHome\">OpenWeb SCADA</a>";
					
					/* Symlink Analyzing For displayOnNav=true */

						$numberOfModules_OnNavigation = 0;
						$extraModules_NavigationArray = array();
						
						foreach ($symlinksList as $key => $symlinkList_Item){

							$symlinkName = $symlinkList_Item["name"];
							$symlinkDisplayBoolean = $symlinkList_Item["displayOnNav"];
							$symlinkLocation = $symlinkList_Item["location"];

							if ($modulePermissions[$symlinkName]["permissions"]["group_id"] <= $scadaUserPermission_GroupID){
								if ($symlinkDisplayBoolean == "true"){
	
									if ($numberOfModules_OnNavigation <= 4){
										print "<a onclick=\"areaLoader('$symlinkName')\" id=\"scadaNavItem\">";
											print $symlinkName;
										print "</a>";
										$numberOfModules_OnNavigation = $numberOfModules_OnNavigation + 1;
									}
									else{
										$extraModules_NavigationArray[] = $symlinkName;
									}
	
								}
							}

						}

						if ($numberOfModules_OnNavigation > 5){
							print "<div class=\"showMoreNavigation\">";
								foreach ($extraModules_NavigationArray as $key => $navigationLink){
									print "<a onclick=\"areaLoader('$navigationLink')\">$navigationLink</a>";
								}
							print "</div>";
						}

					/* End of symlink Analyzing */

					/* User Dropdown */

					/* End of User Dropdown */

				print "</div>";
            }
            else{
                atlasui_redirect("login", 0.5);
            }

        ?>
    </body>
</html>
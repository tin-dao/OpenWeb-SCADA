<?php

	if (isset($_COOKIE["openweb-scada"])){
		atlasui_redirect("index", 0.5);
	}

	function loginForm(){
		print "<!DOCTYPE html>";
		print "<html>";
			print "<head>";
				print "<title>OpenWeb SCADA - Login</title>";
				print "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/main.css\" />";
				print "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/login.css\" />";
				print "<meta http-equiv=\"X-UA-Compatible\" content=\"chrome=1\">";
			print "<head>";
				print "<body>";
					print "<form class=\"loginForm\" method=\"POST\" action=\"login\">";
						print "<label>Login</label>";
						print "<input type=\"text\" name=\"username\" placeholder=\"Username\" maxlength=\"40\" autocomplete=\"off\" required=\"required\" />";
						print "<input type=\"password\" name=\"password\" autocomplete=\"off\" required=\"required\" />";
						print "<button type=\"submit\">Submit</button>";
					print "</form>";
				print "</body>";
		print "</html>";
	}

	if (strlen($_POST["username"]) > 4){

		include("Framework/framework.php");

		$configJSON_Encoded = file_get_contents("conf/config.json");
		$configJSON_Decoded = json_decode($configJSON_Encoded, true);
		$passwordHash = $configJSON_Decoded["preferences"]["password_hash"];

		$uncleanUsername = $_POST["username"];
		$uncleanPassword = $_POST["password"];
		$uncleanBotProtection = $_POST["botProtection"];
		$botProtectionActual = $_POST["botProtectionActual"];

		$unhashedUsername = atlasui_string_clean($uncleanUsername, 1, true);
		$unhashedPassword = atlasui_string_clean($uncleanPassword, 1, true);
		$inputBotProtection = atlasui_string_clean($uncleanBotProtection, 1, true);

		if ($inputBotProtection == $botProtectionActual){
			$userFile_Hash = substr(atlasui_encrypt($unhashedUsername, "strong", "100000", $passwordHash), 0, 16);
			$hashedUsername = atlasui_encrypt($unhashedUsername, "strong", "100000", $passwordHash);
			$hashedPassword = atlasui_encrypt($unhashedPassword, "strong", "100000", $passwordHash);
			
			if (file_exists("users/$userFile_Hash.json")){
				$userInfo_Encoded = file_get_contents("users/$userFile_Hash.json");
				$userInfo_Decoded = json_decode($userInfo_Encoded, true);

				if (($userInfo_Decoded["general"]["username"] == $hashedUsername) && ($userInfo_Decoded["general"]["password"] == $hashedPassword)){
					$setCookie_Address = $_SERVER['SERVER_NAME'];
					setcookie("openweb-scada", $hashedUsername, time()+3600*24*14, __DIR__, $setCookie_Address, false, true);
					atlasui_redirect("index", 0.5);
				}
				else{
					loginForm();
				}
			}
			else{
				loginForm();
			}
		}
		else{
			loginForm();
		}
	}
	else{
		loginForm();
	}
?>
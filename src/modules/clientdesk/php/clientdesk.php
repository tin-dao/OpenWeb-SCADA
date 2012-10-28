<?php

	/* Include Main Dependencies */

	print "<link rel=\"stylesheet\" type=\"text/css\" href=\"modules/clientdesk/ui/clientdesk.css\" />";
	print "<script type=\"text/javascript\" src=\"modules/clientdesk/js/clientdesk.js\" ></script>";
	
	/* End of Including Main Dependencies */

	/* Main ClientDesk Page */

	print "<div class=\"clientdesk\">";

		/* Client List */
		print "<div id=\"clientHome\">";
			print "<div id=\"clientList\">";
				print "<div id=\"generalModule_Label\">
					<label>Clients</label>
					<button type=\"button\" onclick=\"newClient()\">New Client</button>";
				print "</div>";
				print "<div class=\"clientList_RowInfo\">";
					print "<label id=\"clientList_ClientName\">Client / Entity Name</label>";
					print "<label id=\"clientList_ClientEmail\">Email Address</label>";
					print "<label id=\"clientList_ClientLastTime\">Last Time Contacted</label>";
				print "</div>";
				
				$clientList_Encoded = file_get_contents("data/clientdesk/clients/clientlist.json");
				$clientList = json_decode($clientList_Encoded, true);
	
				foreach ($clientList as $key => $individualClient){
					$clientName = $individualClient["name"];
					$clientEmail = $individualClient["email"];
					$clientLastContacted = $individualClient["last_time_contacted"];
	
					$clientJsonFile = $individualClient["unique_id"];
	
					print "<div id=\"clientList_Row\">";
						print "<a onclick=\"fetchClientData('$clientJsonFile')\" id=\"clientList_ClientName\">";
							print $clientName;
						print "</a>";
						print "<a href=\"mailto:$clientEmail\" id=\"clientList_ClientEmail\">$clientEmail</a>";
						print "<label id=\"clientList_ClientLastTime\">$clientLastContacted</label>";
					print "</div>";
				}

			print "</div>";
	
			/* End of Client List */
	
			/* Latest Purchases */
	
			print "<div class=\"clientDesk_Home_SmallModule\">";
				print "<div id=\"generalModule_Label\">
					<label>Latest Purchases</label>
					<button type=\"button\" onclick=\"loadPurchases()\">View More</button>";
				print "</div>";
				print "<div class=\"clientDesk_Home_SmallModule_RowInfo\">";
					print "<label id=\"clientDesk_Home_SmallModule_RowData_First\">Name</label>";
					print "<label id=\"clientDesk_Home_SmallModule_RowData_Second\">Item Description</label>";
					print "<label id=\"clientDesk_Home_SmallModule_RowData_Third\">Date / Time</label>";
				print "</div>";
				
				$latestPurchasesList_Encoded = file_get_contents("data/clientdesk/purchases/latest_purchases.json");
				$latestPurchasesList = json_decode($latestPurchasesList_Encoded, true);
	
				foreach ($latestPurchasesList as $key => $individualPurchase){
					$purchase_ID = $individualPurchase["id"];
					$purchase_Name_Long = $individualPurchase["name"];
					$purchase_Description_Long = $individualPurchase["description"];
					$purchase_TransactionDate = $individualPurchase["transaction_date"];
	
					if (strlen($purchase_Name_Long) > 12){
						$purchase_Name = substr($purchase_Name_Long, 0, 9) . "...";
					}
					else{
						$purchase_Name = $purchase_Name_Long;
					}
	
					if (strlen($purchase_Description_Long) > 50){
						$purchase_Description = substr($purchase_Description_Long, 0, 47) . "...";
					}
					else{
						$purchase_Description = $purchase_Description_Long;
					}
					
					print "<div class=\"clientDesk_Home_SmallModule_Row\">";
						print "<a onclick=\"loadPurchase('from_clientdesk', '$purchase_ID')\" id=\"clientDesk_Home_SmallModule_RowData_First\">$purchase_Name</a>";
						print "<label id=\"clientDesk_Home_SmallModule_RowData_Second\">$purchase_Description</label>";
						print "<label id=\"clientDesk_Home_SmallModule_RowData_Third\">$purchase_TransactionDate</label>";
					print "</div>";
				}

			print "</div>";
	
			/* End of Latest Purchases */
	
			/* Latest Tickets */
	
			print "<div class=\"clientDesk_Home_SmallModule\">";
				print "<div id=\"generalModule_Label\">
					<label>Latest Tickets</label>
					<button type=\"button\" onclick=\"loadTickets()\">View More</button>";
				print "</div>";
				print "<div class=\"clientDesk_Home_SmallModule_RowInfo\">";
					print "<label id=\"clientDesk_Home_SmallModule_RowData_First\">Name</label>";
					print "<label id=\"clientDesk_Home_SmallModule_RowData_Second\">Ticket Title</label>";
					print "<label id=\"clientDesk_Home_SmallModule_RowData_Third\">Date / Time</label>";
				print "</div>";
				
				$latestTicketList_Encoded = file_get_contents("data/clientdesk/tickets/latest_tickets.json");
				$latestTicketList = json_decode($latestTicketList_Encoded, true);
	
				foreach ($latestTicketList["purchase"] as $key => $ticketInfo){
					$ticket_ID = $ticketInfo["id"];
					$ticket_Name_Long = $ticketInfo["name"];
					$ticket_Title_Long = $ticketInfo["description"];
					$ticket_SubmissionDate = $ticketInfo["submission_date"];
	
					if (strlen($ticket_Name_Long) > 12){
						$ticket_Name = substr($ticket_Name_Long, 0, 9) . "...";
					}
					else{
						$ticket_Name = $ticket_Name_Long;
					}
	
					if (strlen($ticket_Title_Long) > 50){
						$ticket_Title = substr($ticket_Title_Long, 0, 47) . "...";
					}
					else{
						$ticket_Title = $ticket_Title_Long;
					}
					
					print "<div class=\"clientDesk_Home_SmallModule_Row\">";
						print "<label id=\"clientDesk_Home_SmallModule_RowData_First\">$ticket_Name</label>";
						print "<a onclick=\"loadTicket('$ticket_ID')\" id=\"clientDesk_Home_SmallModule_RowData_Second\">$ticket_Title</label>";
						print "<label id=\"clientDesk_Home_SmallModule_RowData_Third\">$title_SubmissionDate</label>";
					print "</div>";
				}

			print "</div>";

			/* End of Latest Tickets */

		print "</div>";
		
	print "</div>";
	//print "<script>";
		//print "setInterval(function(){asyncClientData()}, 5000);";
	//print "</script>";

?>
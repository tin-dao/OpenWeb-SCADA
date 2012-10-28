function asyncClientData(){
	
	asyncajaxrequest = new XMLHttpRequest();
	
	function fetchasyncClientData_Handler() {
		if (asyncajaxrequest.readyState==4 && asyncajaxrequest.status==200){
			$("#clientList").append(asyncajaxrequest.responseText);
		}
	}
	
	lastClientID = $("#clientList_Row input").last().val();

	asyncajaxrequest.onreadystatechange = fetchasyncClientData_Handler;
	asyncajaxrequest.open("GET", "fetchLatestClientList.php?id=" + lastClientID);
	asyncajaxrequest.send();
}

// Fetch Client Information

function fetchClientData(clientID){

	function fetchClientData_Handler() {
		if (ajaxrequest.readyState==4 && ajaxrequest.status==200){
			$("#clientList").hide("slide", {direction: "left"}, 500);
			$(".clientDesk").append('<div id=\"clientInfo\">' + ajaxrequest.responseText + '</div>');
			$("#clientInfo").show("slide",{direction: "left"}, 500);
		}
	}

	ajaxrequest = new XMLHttpRequest();
	ajaxrequest.onreadystatechange = fetchClientData_Handler;
	ajaxrequest.open("GET", "ajax/ajax_loadClientDeskData.php?id=" + clientID);
	ajaxrequest.send();
}

// Edit Client Information

function editClientInfo(clientID){

	$("#clientInfo input").attr("contenteditable", "true");
	$("#editClientInfo_Button").hide();
	$("#saveClientInfo_Button").show();
}

// Go To New Client

function newClient(){
	$("#clientList").hide("slide", {direction: "left"}, 500);
	$("#newClient").show("slide", {direction: "left"}, 500);
}

// Submit New Client Info

function submitNewClient(){
	var clientName = $(".clientTitle label").html();
	var clientCompany = $('input[name="companyOrOrganization"]').val();
	var emailAddress = $('input[name="emailAddress"]').val();
	var phoneNumber = $('input[name="phoneNumber"]').val();
	var skypeUsername = $('input[name="skypeUsername"]').val();
	var timeToContact = $('input[name="timeToContact"]').val();
	var lastTimeContacted = $('input[name="lastTimeContacted"').val();
	
	var formData = "formData=" + clientName + "||" + clientCompany + "||" + emailAddress + "||" + phoneNumber;
	formData = formData + "||" + skypeUsername + "||" + timeToContact + "||" + lastTimeContacted;
	
	sendNewClient = new XMLHttpRequest;
	
	function sendNewClient_Handler(){
		if (sendNewClient.readyState == 4 && sendNewClient.status == 200){
			if (sendNewClient.responseText !== "user_not_authorized"){
				if (sendNewClient.responseText !== "null"){
					$("#newClient").hide("slide", {direction: "left"}, 500);
					$("#clientList").show("slide", {direction: "left"}, 500);
				}
			}
			else{
				currentURL = document.URL;
				rootURL = currentURL.replace("submitNewClient", "login");
				window.location = rootURL;
			}
		}
	}
	
	sendNewClient.onreadystatechange = sendNewClient_Handler;
	sendNewClient.open("POST", "submitNewClient.php", false);
	sendNewClient.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	sendNewClient.setRequestHeader("Content-length", formData.length);
	sendNewClient.send(formData);
}

// Go Back To List

function goBack_ToList(){
	$("#clientInfo").hide("slide", {direction: "left"}, 500);
	$("#editClientInfo").hide("slide", {direction: "left"}, 500);
	$("#clientList").show("slide", {direction: "left"}, 500);
	document.getElementByID('clientInfo').innerHTML = "";
}
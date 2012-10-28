function areaLoader(area){
	areaLoaderXHR = new XMLHttpRequest;
	
	function areaLoaderXHR_Hander(){
		if (areaLoaderXHR.readyState == 4 && areaLoaderXHR.status == 200){
			$("title").empty();
			$("#areaCanvas").empty().html(areaLoaderXHR.responseText);
			window.document.title = "OpenWeb SCADA: " + $("title").html();
		}
	}
	
	areaLoaderXHR.onreadystatechange = areaLoaderXHR_Hander;
	areaLoaderXHR.open("GET", "areas.php?a=" + area);
	areaLoaderXHR.send();
}
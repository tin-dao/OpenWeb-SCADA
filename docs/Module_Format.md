### OpenWeb-SCADA Module.JSON Format (v0.1.1) 


This is version **0.1.1** of OpenWeb-SCADA's Module.json file. This file **should** be used as an **example** module.json file.

This module.json file should get packaged along with your module's files in a folder, packaged as a **.zip**.

```javascript
var module = {

	"module_info" : [
		{
			"name" : "module name goes here",
			"description" : "description of the module",
			"public_api_key" : "your public API key",
			"type" : "frontend / backend / both",
			"url" : "URL to location in which one can see details on the module",
			"version" : "version number goes here"
		}
	],
	
	"files" : [
		{
			"file" : [
				{
					"name" : "name of the file",
					"description" : "description of the file, useful when saying what file is if file_display is true",
					"location" : "literal path of the file (ex. /foo). Do NOT include file name here.",
					"display" : "true or false - displays module to OpenWeb-SCADA administrator in the Modules area. Typical use is for the administrator to set where module will load on a page.",
					"displayOnNav" : "true or false - display link (literal path of file) on navigation with text (name of file)",
					"type" : "type of file, strictly one of the following: .css, .html, .jpg, .js, .php, .png, .webm, .xml"
				}
			]
		}
	]

}
```
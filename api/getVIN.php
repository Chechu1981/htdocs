<?php

$curl = curl_init();

curl_setopt_array($curl, [
	//CURLOPT_URL => "https://multibrand.servicebox-parts.com/bo/vehicle/v1/api/vehicles/license-plate?licensePlate=0050bzr&licenseCountry=ES",
	CURLOPT_URL => "https://multibrand.servicebox-parts.com/bo/vehicle/v1/api/vehicles/license-plate?licensePlate=0050BZR&licenseCountry=ES",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER =>[
		"authorization: Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJTRDMyMzkxIiwiUk9MRVMiOiJsZXZlbDQsZXMiLCJleHAiOjE3MzIwMTQ2NDAsInVzZXJJbmZvIjp7Imxhbmd1YWdlIjoiRVMiLCJjb3VudHJ5IjoiRVMiLCJzdG9yZUNvZGUiOiIwMjcwMTVMIiwicG9ydGFsIjoiQVAiLCJ0aW1lU3RhbXAiOiIyMDI0MTExOTA3NTc0OCIsImRvcHJJZCI6IjAyNzAxNUwiLCJpYW0iOnRydWUsInVzZXJUeXBvIjoiRE9QUiIsInVzZXJUeXBvUHJvZmlsZSI6IkRPUFIiLCJ1c2VySUQiOiJTRDMyMzkxIiwiYmFza2V0VXJsIjoiaHR0cDovL3NlcnZpY2Vib3guaW5ldHBzYS5jb20vcGFuaWVyL3ZlcnNlckl0ZW1zRXh0ZXJuQ01NLmRvIiwic2VlUFJXYXJlaG91c2UiOiJERVRBSUxTIiwiYWNjZXNzV2FyZWhvdXNlIjp0cnVlfSwiZGVmYXVsdExhbmd1YWdlIjoiRlIiLCJicnIiOnsiY29tcGFueU5hbWUiOiJQTEFDQVMgREUgUElFWkFTIFkgQ09NUE9ORU5URVMiLCJjaXR5IjoiTUFEUklEIiwidGF1eE1PIjpbeyJ0eXBlVGF1eCI6IjEiLCJsaWJlbGxlVGF1eCI6bnVsbCwidmFsZXVyUHJlY2VkZW50IjpudWxsLCJkYXRlTWlzZUFKb3VyIjpudWxsLCJ2YWxldXJUYXV4SFRBY3R1ZWwiOjIwLjAsImFueSI6W119LHsidHlwZVRhdXgiOiIyIiwibGliZWxsZVRhdXgiOm51bGwsInZhbGV1clByZWNlZGVudCI6bnVsbCwiZGF0ZU1pc2VBSm91ciI6bnVsbCwidmFsZXVyVGF1eEhUQWN0dWVsIjozMC4wLCJhbnkiOltdfSx7InR5cGVUYXV4IjoiMyIsImxpYmVsbGVUYXV4IjpudWxsLCJ2YWxldXJQcmVjZWRlbnQiOm51bGwsImRhdGVNaXNlQUpvdXIiOm51bGwsInZhbGV1clRhdXhIVEFjdHVlbCI6NjAuMCwiYW55IjpbXX1dLCJjdXJyZW5jeUNvZGUiOiJFVVIiLCJ0YXV4VHZhIjoiMjEiLCJzdWJzY3JpcHRpb25MZXZlbCI6IjQiLCJleHBpcmF0aW9uRGF0ZSI6IjIwOTktMTItMzEiLCJhdXRoTG9naW5OYnIiOiI1IiwicGh5c2ljYWxTaXRlIjoiIiwiZG9wcmRwcjJBQnJhbmQiOiJBQyIsImRvcHJDb2RlIjoiMCIsInJlYXR0YWNoZW1lbnRCcmFuZCI6IkFDIiwidGFyaWZmWm9uZSI6IkVTIiwicG5yb2lkb3ByY29udHJvbCI6IiIsImVycm9yIjoiIiwiZG9wcmRwcjJBIjoiMDI3MDE1TCIsImNhcmFjdGVyaXN0aXF1ZSI6W3siaWRlbnRpZmlhbnQiOiIiLCJ2YWxldXIiOiIiLCJsaWJlbGxlIjpudWxsLCJhbnkiOltdfSx7ImlkZW50aWZpYW50IjoiIiwidmFsZXVyIjoiIiwibGliZWxsZSI6bnVsbCwiYW55IjpbXX1dfSwib3BlcmF0b3JUeXBlIjoib2kiLCJsYW5ndWFnZU1hcCI6eyJ0cnVlIjpbeyJuYW1lIjoiRXNwYcOxb2wiLCJsYW5nQ29kZSI6IkVTIn0seyJuYW1lIjoiRW5nbGlzaCIsImxhbmdDb2RlIjoiRU4ifSx7Im5hbWUiOiJGcmFuw6dhaXMiLCJsYW5nQ29kZSI6IkZSIn1dLCJmYWxzZSI6W3sibmFtZSI6IkRldXRzY2giLCJsYW5nQ29kZSI6IkRFIn0seyJuYW1lIjoiRXNwYcOxb2wiLCJsYW5nQ29kZSI6IkVTIn0seyJuYW1lIjoibWFneWFyIiwibGFuZ0NvZGUiOiJIVSJ9LHsibmFtZSI6Ik5lZGVybGFuZHMiLCJsYW5nQ29kZSI6Ik5MIn0seyJuYW1lIjoiVMO8cmvDp2UiLCJsYW5nQ29kZSI6IlRSIn0seyJuYW1lIjoiaHJ2YXRza2lqZXppayIsImxhbmdDb2RlIjoiSFIifSx7Im5hbWUiOiJpdGFsaWFubyIsImxhbmdDb2RlIjoiSVQifSx7Im5hbWUiOiJwb3J0dWd1w6pzIiwibGFuZ0NvZGUiOiJQVCJ9LHsibmFtZSI6InJvbcOibsSDIiwibGFuZ0NvZGUiOiJSTyJ9LHsibmFtZSI6InN1b21hbGFpbmVuIiwibGFuZ0NvZGUiOiJGSSJ9LHsibmFtZSI6IkVuZ2xpc2giLCJsYW5nQ29kZSI6IkVOIn0seyJuYW1lIjoiRnJhbsOnYWlzIiwibGFuZ0NvZGUiOiJGUiJ9LHsibmFtZSI6IlBvcnR1Z3Vlc2UoQnJhemlsKSIsImxhbmdDb2RlIjoiUUMifSx7Im5hbWUiOiJQb2xzemN6eXpuYSIsImxhbmdDb2RlIjoiUEwifSx7Im5hbWUiOiLOtc67zrvOt869zrnOus6sIiwibGFuZ0NvZGUiOiJFTCJ9LHsibmFtZSI6ItCx0YrQu9Cz0LDRgNGB0LrQuNC10LfQuNC6IiwibGFuZ0NvZGUiOiJCRyJ9LHsibmFtZSI6ItGA0YPRgdGB0LrQuNC50Y_Qt9GL0LoiLCJsYW5nQ29kZSI6IlJVIn0seyJuYW1lIjoiTm9yc2siLCJsYW5nQ29kZSI6Ik5PIn0seyJuYW1lIjoi5pel5pys6KqeKOOBq-OBu-OCk-OBlCkiLCJsYW5nQ29kZSI6IkpBIn0seyJuYW1lIjoiU2xvdmVuxaHEjWluYSIsImxhbmdDb2RlIjoiU0wifSx7Im5hbWUiOiJTdmVuc2thIiwibGFuZ0NvZGUiOiJTViJ9LHsibmFtZSI6ImRhbnNrIiwibGFuZ0NvZGUiOiJEQSJ9LHsibmFtZSI6IsSNZcWhdGluYSzEjWVza8O9amF6eWsiLCJsYW5nQ29kZSI6IkNTIn0seyJuYW1lIjoi0YHRgNC_0YHQutC4IiwibGFuZ0NvZGUiOiJTUiJ9XX19.FsXfRSYhshF33bZKPXpXjzfuol9tc-IumcRWydMCEGPXf78ub-WXI9Has0meZo6cJV6RSyQnjF3HcEb8jeOifw",
		"cookie: langPsa=es; urlXlf=https://preview-v2-s3-903gly43im81-s3bucketcontent-1rfzmrrd7n9d6.s3-eu-west-1.amazonaws.com/XLF/PROD/messages.es-ES.xlf; automaticSelection=true; unicodeLocalIdentifier=; locale=es_ES; deviceId=66ed435b4b776159016a8fdd; portal=http://servicebox.inetpsa.com; _ga=GA1.1.16260749.1730821157; rxVisitor=1731999468602MN38K16TEM6J5CP56A4P27N19886BCCJ; dtCookie=v_4_srv_4_sn_E5FA9240E2B1A4859E5FE375A50E9287_perc_100000_ol_0_mul_1_app-3A05b143fe1fc53fac_1_app-3Ad6f76c0bb52eaa46_1_rcs-3Acss_0; dtSa=-; _ga_6YMMK2D4XS=GS1.1.1731999470.49.1.1732003775.0.0.0; rxvt=1732005779825|1731999468606; dtPC=4$403745561_912h27vSUOSUWHPKHUWDHTKAASDBVTNARHSCFNT-0e0"
	],
	/*CURLOPT_HTTPHEADER => [
		"x-rapidapi-host: api-matriculas-espana.p.rapidapi.com",
		"x-rapidapi-key: c398ef1804msh848a4a9c2e496d3p1d736ajsnb4a23cbe5442"
	],*/
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	echo $response;
}
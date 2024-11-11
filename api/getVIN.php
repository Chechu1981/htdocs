<?php

$curl = curl_init();

curl_setopt_array($curl, [
	CURLOPT_URL => "https://multibrand.servicebox-parts.com/bo/vehicle/v1/api/vehicles/license-plate?licensePlate=0050bzr&licenseCountry=ES",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"x-rapidapi-host: api-matriculas-espana.p.rapidapi.com",
		"x-rapidapi-key: c398ef1804msh848a4a9c2e496d3p1d736ajsnb4a23cbe5442"
	],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	echo $response;
}
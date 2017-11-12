<?php
if (!isset($_GET['token'])) {
        die();
}

$fb_access_token = $_GET['token'];
$URL = 'https://apibaas-trial.apigee.net/ax88008/mycity/auth/facebook?';
$client_id = 'client_id=YXA61bQCVMXCEeaGGwrYgfQDvw';
$client_secret = 'client_secret=YXA6FWYOnNohGGPiMe42suF0gmSs0ew';

$curlcmd = $URL . $client_id . '&' . $client_secret . '&fb_access_token=' . $fb_access_token;

$curl1 = curl_init();

        curl_setopt_array($curl1, array(
          CURLOPT_URL => $curlcmd,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
          ),
        ));

$response = curl_exec($curl1);
$err = curl_error($curl1);
curl_close($curl1);
echo $response;
?>
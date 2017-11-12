<?php
if (!isset($_GET['rest'])) {
        echo("No Data");
}

$keyword = $_GET['rest'];

$curl1 = curl_init();

        curl_setopt_array($curl1, array(
          CURLOPT_URL => "https://ax88008-test.apigee.net/mycity/rest?placeid=" . $keyword,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
          ),
        ));

        $response = curl_exec($curl1);
	curl_close($curl1);
	$json = json_decode($response, true);
        $name = $json['result']['name'];
        $url = $json['result']['url'];
        $website = $json['result']['website'];
        $latestreview = $json['result']['reviews'][0]['text'];
        $phone = $json['result']['international_phone_number'];
    echo '<p>' . $name . '<br>';
    echo $phone . '<br>';
    echo '<a href="' . $url . '" target="_blank">Google Maps</a><br>';
    echo '<a href="' . $website . '" target="_blank">Website</a><br><br>';
    echo '<b>Latest Review:</b><br>';
    echo $latestreview . '</p>';
?>


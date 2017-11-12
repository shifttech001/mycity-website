<?php
if (!isset($_GET['term'])) {
        die();
}

$keyword = $_GET['term'];

$curl1 = curl_init();

        curl_setopt_array($curl1, array(
          CURLOPT_URL => "http://ax88008-test.apigee.net/mycity/lookup?search=" . $keyword,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
          ),
        ));

        $response1 = curl_exec($curl1);
        $response1 = json_decode($response1, true);
        $d = array();
        foreach($response1['_embedded']['city:search-results'] as $p){
                
                $geoid = explode(':', $p['_links']['city:item']['href']);
                 $d[]=array(
                    'value'=> rtrim($geoid[2],"/"),
                    'label'=> $p['matching_full_name']

                        );
        }
echo json_encode($d);
?>

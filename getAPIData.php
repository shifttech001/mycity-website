<?php 	$city = $_REQUEST["city"];;
        $URL = 'https://ax88008-test.apigee.net/mycity?id=' . $city;
        $curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => $URL,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => array(
		"cache-control: no-cache"
	  ),
	));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	$json = json_decode($response, true);
	$sunrise = strtotime($json['Sunrise']);
	$sunset = strtotime($json['Sunset']);
        $temperature = $json['Temperature'];
        $cityname = $json['City'];
        $imageURL = $json['ImageURL'];
        $uberData = json_decode($json['Uber'], true);
        $restData = json_decode($json['Restaurants'], true);
        
	echo '<H1>Welcome to ' . ucwords($cityname) . '</H1>';
	echo '<img src=' . $imageURL . ' class="img-responsive"><br><br>';
	echo '<b>The Temperature is: </b>'. round($temperature) . ' degrees<br><br>';
	echo '<b>It will be light at: </b>'. gmdate('G:i',$sunrise) . '<br><br>';
	echo '<b>It will get dark by: </b>'. gmdate('G:i',$sunset) . '<br><br>';
        echo '<ul class="nav nav-tabs">';
        echo '<li class="active"><a data-toggle="tab" href="#Uber">Uber Services</a></li>';
        echo '<li><a data-toggle="tab" href="#Rest">Restaurant Services</a></li>';
        echo '</ul>';

        echo '<div class="tab-content">';
        echo '<div id="Uber" class="tab-pane fade in active">';
        echo '<b>Available Uber Services:</b><br><br>';
        echo '<div class="table-responsive">';
        echo '<table class="table table-striped">';
        echo '<thead>';
        echo '<tr>';
        echo '<td> </td><td class="text-center">Service</td><td>Capacity</td><td>Per Minute</td><td>Distance Charge</td><td>Base Charge</td><td>Currency</td></tr></thead><tbody>';
        foreach ($uberData as $key => $value) {
        echo '<tr><td class="text-center"><img src=' . $value["image"] . ' style="max-height:50px"></img></td>';
        echo '<td class="text-center">' . $value["display_name"] . '</td>';
        echo '<td class="text-center"><span class="badge">' . $value["capacity"] . '</span></td>';
        echo '<td class="text-center"><span class="badge">' . $value["price_details"]["cost_per_minute"] . '</span></td>';
        echo '<td class="text-center">' . $value["price_details"]["cost_per_distance"] . ' per  ' . $value["price_details"]["distance_unit"] . '</td>';
        echo '<td class="text-center"><span class="badge">' . $value["price_details"]["base"] . '</span></td>';
        echo '<td class="text-center">' . $value["price_details"]["currency_code"] . '</td></tr>';
        }
        echo '</tbody></table></div>';
        echo '</div>';
        echo '<div id="Rest" class="tab-pane fade">';
        echo '<br><b>Local Restaurants:</b><br><br>';
        echo '<div class="table-responsive">';
        echo '<table class="table table-striped">';
        echo '<thead>';
        echo '<tr>';
        echo '<td class="text-center">Name</td><td class="text-center">Location</td><td class="text-center">Google Rating</td></thead><tbody>';
        foreach ($restData as $key => $value) {
        echo '<tr><td class="text-center"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" id="' . $value["place_id"] . '" data-target="#edit-modal">' . $value["name"] . '</button></td>';
        echo '<td class="text-center">' . $value["vicintiy"] . '</td>';
        echo '<td class="text-center"><span class="badge">' . $value["google_rating"] . '</span></td></tr>';
        }
        echo '</tbody></table></div>';
        echo '</div></div>';
?>
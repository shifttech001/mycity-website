<html>
   <head>
        <script type="text/javascript"
        src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script type="text/javascript"
        src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
        <link rel="stylesheet" type="text/css"
        href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" />
 
        <script type="text/javascript">
                $(document).ready(function(){
                    $("#name").autocomplete({
                        source:'autocomplete.php',
                        minLength:1
                    });
                });
        </script>
   </head>
 
   <body>
 
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
             Name : <input type="text" id="name" name="txtName" />
             <input type="submit" name="btnSendForm" value="Search" />
      </form>
 
   </body>
<html>


<?php if(isset($_POST["txtName"])) {
	$city = $_POST["txtName"];
	//$city = $_GET['city'];
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => "http://ax88008-test.apigee.net/mycity?id=" . 
$city,
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
	$response = json_decode($response, true);
	$sunrise = strtotime($response['Sunrise']);
	$sunset = strtotime($response['Sunset']);
	echo '<H1>A beautiful view of: '. ucfirst($response['City']) . 
'</H1>';
	echo '<img src=' . $response['ImageURL'] . '><br><br>';
	echo '<b>The Temperature is: </b>'. 
round($response['Temperature']) . ' degrees<br><br>';
	echo '<b>It is light at: </b>'. gmdate('G:i',$sunrise) . 
'<br><br>';
	echo '<b>It will get dark at: </b>'. gmdate('G:i',$sunset) . 
'<br>';
} 
?>
  </body>
</html>

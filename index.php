<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <title>MyCity Search Page</title>
    <link href="img/Favicon.png" rel="icon" />
    <style>
        .table td {
            text-align: center;   
        }
    </style>
</head>
<body>
    <br>
     <div class="container">
         <div class="panel panel-default">
         <div class="panel-heading">MyCity - Information about your Destination</div>
            <div class="panel-body">
            <div class="form-group">
                <div class="col-sm-8">
                    <label class="desc" id="lbCityCode" for="CityCode">Search for your City : </label>
                    <br>
                    <input type="text" id="CityCode" name="txtName"/>
                    <button type="button" id="btnSearch" class="btn btn-default" onclick="callMyCity();">Search</button>
                </div>
                <div class="col-sm-2">
                    <br>
                </div>
                <div class="col-sm-2">
                        <label class="desc" id="lbFindMe">Find your Location : </label>
                        <br>
                        <button type="button" class="btn btn-default" onclick="callMyLocation();">Find Me</button>
                </div>
            </div>
            </div>
        </div>
        <div class="col-sm-12"
            <p id="CityData"></p>
        </div>
    </div>
    <div id="edit-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Restaurant Details</h4>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#CityCode").autocomplete({
            source:'autocomplete.php',
            minLength:3
        });
        
        $('#edit-modal').on('show.bs.modal', function(e) {
            $('#edit-modal .modal-body').html("Getting Contents......");
            var esseyId = e.relatedTarget.id;
            var url = 'getRestData.php?rest=' + esseyId;
             $.ajax({
                url : url,
                type : 'GET',
                dataType : 'html',
                success : function (result) {
                   $('#edit-modal .modal-body').html(result);
                },
                error : function () {
                   alert("error");
                }
            })
        });
        
    });

    function callMyCity(){
        var myCity = document.getElementById("CityCode").value;
        GetChoice(myCity);
    }
    
    function callMyLocation(){
        getLocation();
    };

    function GetChoice(myCity) {

    var returned = "";
    $.ajax({
            async: false,
            cache: false,
            type: "POST",
            url: "getAPIData.php",
            data: { city: myCity}
            }).done(function( msg ) {                        
                    returned = msg;
            });

    var element = document.getElementById("CityData");
    element.innerHTML = returned;
    }

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            alert("Browser Does Not Support Locations or Locations are not enabled");
        }
    }

    function showPosition(position) {
        var MyURL = "https://ax88008-test.apigee.net/mycity/locations/" + position.coords.latitude + "," + position.coords.longitude;

        $.ajax({
            url: MyURL,
            async: false,
            dataType: 'json',
            success: function(data) {
                    address = data._embedded["location:nearest-cities"][0]._links["location:nearest-city"].href;
            }
        });
        var address = address.split(":");
        var address = address[2].slice(0,-1);
        GetChoice(address);
    };
    
</script>
</body>
</html>
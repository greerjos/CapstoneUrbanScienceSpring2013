<?php
$serverName = "(local)";
$connectionInfo = array("UID"=>"TUS",
  					"PWD"=>"TUS",
						"Database"=>"DEALERKPI");

$conn = sqlsrv_connect( $serverName, $connectionInfo);
if ($conn === false)
{
print_r( sqlsrv_errors());
}
echo "I AM HERE";
echo "<br>\n";   

$query = "SELECT *
		  FROM [DEALERKPI].[dbo].[Dealer]
		  WHERE Dealer_Number = '111115'";

if ($query === false)
{
print_r( sqlsrv_errors());
}		  
		  
		  
echo "I AM HERE 2";		
echo "<br>\n";   

$allow = sqlsrv_query($conn, $query);

//echo $allow;

if ($allow === false)
{
print_r( sqlsrv_errors());
}	

echo "I AM HERE 3";		
echo "<br>\n";   

//$row = mssql_fetch_array($allow);  

$row = sqlsrv_fetch_array($allow, SQLSRV_FETCH_ASSOC);
		  
if ($row === false)
{
print_r( sqlsrv_errors());
}		  
		  
echo count($row);
echo "<br>\n";  

$address = $row['Dealer_Address'].', '.$row['Dealer_City'].','. $row['Dealer_State'];

echo "<br>\n";   

//$city = $row['Dealer_City'];

echo $address;
	$json = json_encode($address);

?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
  <title>Load map with navigation bar module</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <script type="text/javascript" src="http://ecn.dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=7.0"></script>
  <script type="text/javascript">
  var map = null;
  var searchManager = null;
  function getMap()
  {
    map = new Microsoft.Maps.Map(document.getElementById('myMap'), {credentials: 'Ah4pKJ-KTSwl1ESP9WbsnlEOME035NVDw-fNBM8DLzBG4g9UXKe9mQodTyAFBXB9	'});
      Microsoft.Maps.loadModule('Microsoft.Maps.Search', { callback: geocodeRequest })
  }
  function createSearchManager() 
  {
      map.addComponent('searchManager', new Microsoft.Maps.Search.SearchManager(map)); 
      searchManager = map.getComponent('searchManager'); 
  }
  function LoadSearchModule()
  {
    Microsoft.Maps.loadModule('Microsoft.Maps.Search', { callback: geocodeRequest })
  }
  function geocodeRequest() 
  { 
    createSearchManager(); 
	<?php echo $json; ?>; 
    var where = <?php echo $json; ?>; 
    var userData = { name: 'Maps Test User', id: 'XYZ' }; 
    var request = 
    { 
        where: where, 
        count: 5, 
        bounds: map.getBounds(), 
        callback: onGeocodeSuccess, 
        errorCallback: onGeocodeFailed, 
        userData: userData 
    }; 
    searchManager.geocode(request); 
  } 
  function onGeocodeSuccess(result, userData) 
  { 
    if (result) { 
        map.entities.clear(); 
        var topResult = result.results && result.results[0]; 
        if (topResult) { 
            var pushpin = new Microsoft.Maps.Pushpin(topResult.location, null); 
            map.setView({ center: topResult.location, zoom: 10 }); 
            map.entities.push(pushpin); 
        } 
    } 
  } 
  function onGeocodeFailed(result, userData) { 
    alert('Geocode failed'); 
  } 
  </script>
  </head>
  <body onload="getMap();">
    <div id='myMap' style="position:relative; width:400px; height:400px;"></div>
    </div>
  </body>
</html>

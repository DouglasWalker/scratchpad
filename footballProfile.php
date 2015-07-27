<html>
<head>

<link rel="stylesheet" type="text/css" href="theme.css">
<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="http://code.highcharts.com/highcharts.js"></script>


</head>


<body>
<p id="title1">Current Squad List</p>

<p><div id='container' style='width:550px; height:300px;'></div></p>


<?php
$servername = "localhost";
$username = "root";
$password = "irene";
$dbname = "footballdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT fp.playerId,s.shirtNumber,c.countryName,c.countryCode,fp.firstName,fp.lastName,CONCAT(fp.firstName,' ',fp.lastName) AS 'fullName',fp.playerImage,ROUND(AVG(mr.playerRating),2) 'rating1',
GROUP_CONCAT(mr.playerRating,' ') 'recentRatings'
FROM footballplayers fp
LEFT JOIN matchRatings mr ON mr.playerId=fp.playerId
LEFT JOIN shirtNumbers s ON s.playerId=fp.playerId
LEFT JOIN countries c ON c.countryId=fp.countryId
GROUP BY fp.playerId
ORDER BY rating1 DESC" ;
$result1 = $conn->query($sql);

$ratingPull=array();
$namesArray=array();

if ($result1->num_rows > 0) {
    // output data of each row
    while($row = $result1->fetch_assoc()) {

      $ratingPull[]=$row["rating1"];
      $namesArray[]=$row["fullName"];

        echo "<p id=\"rcorners\"><table border='1' style='width:100%'>
  <tr>
    <td>Squad Number: "
     . $row["shirtNumber"]. "<br>Player Name: "
     . $row["fullName"].
     "<br>Country: " . $row['countryName']. " <img src='../img/flags/" . $row['countryCode']. ".png'>
     <br>Average Rating: "
     . $row["rating1"]. "<br>Recent Ratings:<br>"
       . $row["recentRatings"]. "</td>
    <td><img id='img_blue' src='../img/players/" . $row["playerImage"]. "'><br>
      </td>
  </tr>
</table>
";
   }
} else {
    echo "0 results";
}
$conn->close();


?>
</p>
<script>
$( document ).ready(function() {
  $('#container').highcharts({
      chart: {
          type: 'bar'
      },
      title: {
          text: 'Ratings'
      },
      xAxis: [{
          categories: ['<?php echo implode("','", $namesArray);?>']
      }],
      yAxis: {
          title: {
              text: ["Average Rating"]
          }
      },
      series: [{
          name: 'Player Rating',
          data: [<?php echo implode(",", $ratingPull);?>]
      } ]
  });
});
</script>

</body>
</html>

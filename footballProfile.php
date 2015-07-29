<html>
<head>

<link rel="stylesheet" type="text/css" href="theme.css">
<link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="jquery.bxslider.min.js"></script>
<link href="jquery.bxslider.css" rel="stylesheet">
<script src="slider.js"></script>

<script>
 $(function() {
   $( "#dialog" ).dialog({
     autoOpen: false,
     width:800,
     height:610,
     show: {
       effect: "blind",
       duration: 600
     },
     hide: {
       effect: "blind",
       duration: 600
     }
   });

   $( "#opener" ).click(function() {
     $( "#dialog" ).dialog( "open" );
   });
 });
 </script>

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
?>

</head>


<body>

<p id="title1">Current Squad Performance Index</p>

<div id='dialog' title='Highlights Video'>
  <p id=\"rcorners\">
  <iframe width="750" height="500" src="https://www.youtube.com/embed/29Y3CVuLrsM" frameborder="0" allowfullscreen></iframe>
  </p>
  </div>
  <p id=\"rcorners\"><button id='opener'>Highlights Video</button></p>

<table>
  <tr>
    <td>


<?php
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
  $idArray=array();
  $recentRatingsArray=array();



  if ($result1->num_rows > 0) {
      // output data of each row
      while($row = $result1->fetch_assoc()) {

        $ratingPull[]=$row["rating1"];
        $namesArray[]=$row["fullName"];
        $idArray[]=$row["playerId"];
        $recentRatingsArray[]=$row["recentRatings"];

          echo "<p id=\"rcorners\"><table border='1' style='width:100%'>

        <tr>
      <td width='300'><huge>"
      . $row["fullName"].
      "</huge><br><br>Squad Number: "
       . $row["shirtNumber"]. "<br>Country: " . $row['countryName']. " <img src='../img/flags/" . $row['countryCode']. ".png'>
       <br>Average Rating: "
       . $row["rating1"]. "

 </td>
      <td>


         <img id='img_blue' src='../img/players/" . $row["playerImage"]. "'>



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

</td>
<td>

  <p id='container' style='width:850px; height:700px;'><br><br>
    </p>
    <ul class="bxslider">
      <li><img src="../img/stadiums/mem1.jpg" title="From the Home End"></li>
      <li><img src="../img/stadiums/mem2.jpg" title="From the Away End"></li>
    </ul>



</td>
</tr>
</table>



<script>
$( document ).ready(function() {
  $('#container').highcharts({
      chart: {
          type: 'column'
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

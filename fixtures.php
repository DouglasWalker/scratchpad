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
<meta charset="utf-8">

<?php

/* Connects to MySQL */

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

</head>

<body>
<TABLE class="defaultTable" width="1200" height="50">
<div class="matchTitleTextLarge">
<a href="http://www.gasratings.co.uk">Gas Ratings</a>
</div>
<div class="matchTitleText">
  Your Club. Your Ratings.</div>
</table>
<br>
<table class="defaultTable" width="1230">
  <tr><td class="defaultTableBlueMidAlign" height="25">
    <div class="matchLineupTxt">

      <?php
        $sql = "SELECT f.fixtureId FROM fixtures f
          WHERE f.kickoffTime < CURRENT_DATE()
          OR (      f.kickoffTime = CURRENT_DATE()
          AND f.kickoffTime <= CURRENT_TIME()
              )
          ORDER BY f.kickoffTime DESC LIMIT 1
          " ;
          $result = $conn->query($sql);



          if ($result->num_rows > 0) {
              // output data of each row
              while($row = $result->fetch_assoc()) {

                $fixtureId[]=$row["fixtureId"];

                    echo "<a href='../index.php'>Home</a>&nbsp;&#8226;&nbsp;

      <a href='../latest.php?id=" .$row['fixtureId']. "'>Latest Result</a> &nbsp;&#8226;&nbsp; Results &nbsp;&#8226;&nbsp; <a href='../fixtures.php'>Fixtures</a>


      					 ";
      				 		 }
      				 	} else {
      				 			echo "0 results";
      				 	}


      				 	?>

       &nbsp;&#8226;&nbsp; Overall Statistics &nbsp;&#8226;&nbsp; Blog &nbsp;&#8226;&nbsp; About</div></td></tr>
</tr></table>

<br>

<TABLE class="defaultTable" width="1200" height="1000">


  <TD class="defaultTable" >

    <table><tr>
    <TD class="defaultTableBlue" width="450" height="30">
    <div class="matchTitleText">Next Fixture</div></td>
    <TD class="defaultTableBlue" width="750" height="30">
    <div class="matchTitleText">Fixture Information</div>
  </tr>
  </table>


  <?php
  $sql = "SELECT

  DATE_FORMAT(f.kickoffTime,'%W %b %d %Y, %l:%i %p') 'kickoffDate',
  c.competitionName 'compName',
  IF(s.stadiumName='The Memorial Stadium','Home','Away') 'venue',
  fch.clubName 'homeTeamName',
  fca.clubName 'awayTeamName',
  s.stadiumName,
  fch.clubImg 'homeImg',
  fca.clubImg 'awayImg',
  f.matchPreview,
  f.ticketNews,
  s.stadiumImg

  FROM fixtures f


  LEFT JOIN footballClubs fch ON fch.clubId=f.homeTeamId
  LEFT JOIN footballClubs fca ON fca.clubId=f.awayTeamId
  LEFT JOIN stadiums s ON s.stadiumId=f.stadiumId
  LEFT JOIN competitions c ON c.competitionId=f.competitionId
  WHERE f.kickoffTime > CURRENT_DATE()
     OR (      f.kickoffTime = CURRENT_DATE()
          AND f.kickoffTime >= CURRENT_TIME()
         )
  ORDER BY f.kickoffTime
  LIMIT 1
  " ;
  $result = $conn->query($sql);



  if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {


        $kickoffDate[]=$row["kickoffDate"];
        $compName[]=$row["compName"];
        $venue[]=$row["venue"];
        $homeTeamName[]=$row["homeTeamName"];
        $awayTeamName[]=$row["awayTeamName"];
        $stadiumName[]=$row["stadiumName"];
        $homeImg[]=$row["homeImg"];
        $awayImg[]=$row["awayImg"];
        $matchPreview[]=$row["matchPreview"];
        $ticketNews[]=$row["ticketNews"];
        $stadiumImg[]=$row["stadiumImg"];


          echo "

  <table width='1200'>
   <tr>


     <td ><table class='matchDay' width='450' height='175' background='../img/stadiums/" .$row['stadiumImg']. "'>
                  <td width='150'><center><img src='../img/clubLogos/" .$row['homeImg']. "'></center></td>
                  <td width='150'><div class='matchTitleTextImg'>VS</div></td>
                  <td width='150'><center><img src='../img/clubLogos/" .$row['awayImg']. "'></center></td>

                </table></td>
      <td width='375'><table width='375'><div class='defaultTextLarge'>" .$row['homeTeamName']. "<br>vs<br>
      " .$row['awayTeamName']. "</div><br><div class='defaultTextMed'>" .$row['compName']. "<br>" .$row['stadiumName']. "<br>" .$row['kickoffDate']. "</div>
    </table></td>
     <td width='375'><table width='375'><div class='defaultTextCen'><strong>Ticket News</strong><br>" .$row['ticketNews']. "
       <br><br><strong>Preview</strong><br>" .$row['matchPreview']. "
</div>     </table></td>
  </tr>
</table>

";
   }
} else {
    echo "0 results";
}


?>
<table>
  <td height='8'></td>
</table>

<table>

<TD class='defaultTableBlue' width='1200' height='30'>
<div class='matchTitleText'>Upcoming Fixtures</div></td>
</tr>
</table>

<table><tr>




  <?php
  $sql = " SELECT

  DATE_FORMAT(f.kickoffTime,'%W %b %d %Y, %l:%i %p') 'kickoffDate',
  c.competitionName 'compName',
  IF(s.stadiumName='The Memorial Stadium','Home','Away') 'venue',
  fch.clubName 'homeTeamName',
  fca.clubName 'awayTeamName',
  s.stadiumName,
  fch.clubImg 'homeImg',
  fca.clubImg 'awayImg',
  IF(fch.clubId=1,fca.clubImg,fch.clubImg) 'buttonImg'

  FROM fixtures f


  LEFT JOIN footballClubs fch ON fch.clubId=f.homeTeamId
  LEFT JOIN footballClubs fca ON fca.clubId=f.awayTeamId
  LEFT JOIN stadiums s ON s.stadiumId=f.stadiumId
  LEFT JOIN competitions c ON c.competitionId=f.competitionId
  WHERE f.kickoffTime > CURRENT_DATE()
     OR (      f.kickoffTime = CURRENT_DATE()
          AND f.kickoffTime >= CURRENT_TIME()
         )
  ORDER BY f.kickoffTime
  LIMIT 1,5
  " ;
  $result = $conn->query($sql);



  if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {


        $kickoffDate[]=$row["kickoffDate"];
        $compName[]=$row["compName"];
        $venue[]=$row["venue"];
        $homeTeamName[]=$row["homeTeamName"];
        $awayTeamName[]=$row["awayTeamName"];
        $stadiumName[]=$row["stadiumName"];
        $homeImg[]=$row["homeImg"];
        $awayImg[]=$row["awayImg"];
        $buttonImg[]=$row["buttonImg"];


          echo "

          <td class= 'imgAlign' width='240' height='175'>
            <center><img src='../img/clubLogos/" .$row['buttonImg']. "'></center>
          </td>


          ";
             }
          } else {
              echo "0 results";
          }


          ?>

  </tr>
  <tr>

    <?php
    $sql = " SELECT

    DATE_FORMAT(f.kickoffTime,'%W %b %d %Y, %l:%i %p') 'kickoffDate',
    c.competitionName 'compName',
    IF(s.stadiumName='The Memorial Stadium','Home','Away') 'venue',
    fch.clubName 'homeTeamName',
    fca.clubName 'awayTeamName',
    s.stadiumName,
    fch.clubImg 'homeImg',
    fca.clubImg 'awayImg',
    IF(fch.clubId=1,fca.clubImg,fch.clubImg) 'buttonImg',
    IF(fch.clubId=1,fca.clubName,fch.clubName) 'buttonTeam'

    FROM fixtures f


    LEFT JOIN footballClubs fch ON fch.clubId=f.homeTeamId
    LEFT JOIN footballClubs fca ON fca.clubId=f.awayTeamId
    LEFT JOIN stadiums s ON s.stadiumId=f.stadiumId
    LEFT JOIN competitions c ON c.competitionId=f.competitionId
    WHERE f.kickoffTime > CURRENT_DATE()
       OR (      f.kickoffTime = CURRENT_DATE()
            AND f.kickoffTime >= CURRENT_TIME()
           )
    ORDER BY f.kickoffTime
    LIMIT 1,5
    " ;
    $result = $conn->query($sql);



    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {


          $kickoffDate[]=$row["kickoffDate"];
          $compName[]=$row["compName"];
          $venue[]=$row["venue"];
          $homeTeamName[]=$row["homeTeamName"];
          $awayTeamName[]=$row["awayTeamName"];
          $stadiumName[]=$row["stadiumName"];
          $homeImg[]=$row["homeImg"];
          $awayImg[]=$row["awayImg"];
          $buttonImg[]=$row["buttonImg"];
          $buttonTeam[]=$row["buttonTeam"];


            echo "

    <td width='240' height='75'>
      <div class='defaultTextLarge'>
      " .$row['buttonTeam']. " <br>
      </div>
      <div class='defaultTextCen'>
      " .$row['venue']. " <br>
      " .$row['stadiumName']. " <br>
      " .$row['compName']. " <br>
      " .$row['kickoffDate']. "

      </div>
    </td>

    ";
       }
    } else {
        echo "0 results";
    }


    ?>

</table>
<table>
  <td height='8'></td>
</table>
<table>

<TD class='defaultTableBlue' width='1200' height='30'>
<div class='matchTitleText'>Further Fixtures</div></td>
</tr>
</table>

<table width='1200'>

<tr width='1200'>



<td width='150' class='defaultTableLiteBlueCen'>Date</td>
<td width='205' class='defaultTableLiteBlueCen'>Competition</td>
<td width='75' class='defaultTableLiteBlueCen'>H/A</td>
<td width='250' class='defaultTableLiteBlueCen'>Venue</td>
<td width='200' class='defaultTableLiteBlueCen'>Home Team</td>
<td width='200' class='defaultTableLiteBlueCen'>Away Team</td>


</tr>

<?php
$sql = "SELECT

DATE_FORMAT(f.kickoffTime,'%W %b %d %Y, %l:%i %p') 'kickoffDate',
c.competitionName 'compName',
IF(s.stadiumName='The Memorial Stadium','Home','Away') 'venue',
fch.clubName 'homeTeamName',
fca.clubName 'awayTeamName',
s.stadiumName,
fch.clubImg 'homeImg',
fca.clubImg 'awayImg'

FROM fixtures f


LEFT JOIN footballClubs fch ON fch.clubId=f.homeTeamId
LEFT JOIN footballClubs fca ON fca.clubId=f.awayTeamId
LEFT JOIN stadiums s ON s.stadiumId=f.stadiumId
LEFT JOIN competitions c ON c.competitionId=f.competitionId
WHERE f.kickoffTime > CURRENT_DATE()
   OR (      f.kickoffTime = CURRENT_DATE()
        AND f.kickoffTime >= CURRENT_TIME()
       )
ORDER BY f.kickoffTime
LIMIT 6,100
" ;
$result = $conn->query($sql);



if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {


      $kickoffDate[]=$row["kickoffDate"];
      $compName[]=$row["compName"];
      $venue[]=$row["venue"];
      $homeTeamName[]=$row["homeTeamName"];
      $awayTeamName[]=$row["awayTeamName"];
      $stadiumName[]=$row["stadiumName"];
      $homeImg[]=$row["homeImg"];
      $awayImg[]=$row["awayImg"];


        echo "

        <td class='defaultTextCen'>" .$row['kickoffDate']. "</td>
        <td class='defaultTextCen'>" .$row['compName']. "</td>
        <td class='defaultTextCen'>" .$row['venue']. "</td>
        <td class='defaultTextCen'>" .$row['stadiumName']. "</td>
        <td class='defaultTextCen'>" .$row['homeTeamName']. "</td>
        <td class='defaultTextCen'>" .$row['awayTeamName']. "</td>

</tr>

";
   }
} else {
    echo "0 results";
}


?>


</table>


</table>
</body>

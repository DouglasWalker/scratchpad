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

<body>

<div class="matchTitleText">
Matchday Page
</div>
<br>

<TABLE class="defaultTable" width="1200" height="900">


<TD class="defaultTable" >

  <table><tr>
  <TD class="defaultTableBlue" width="750" height="30">
  <div class="matchTitleText">Matchday Ratings</div>
</tr>
</table>

<table width="750" height="500">
 <tr>
       <td>

             <table class="defaultText" width="750" height="300">
               <tr><td colspan="8" class="defaultTableBlueMidAlign"><div class="matchLineupTxt">Starting Lineup</div></td></tr>

               <tr>
                    <td>#</td>
                    <td>First Name</td>
                    <td>Surname</td>
                    <td>Position</td>
                    <td>Assists</td>
                    <td>Goals</td>
                    <td>Ratings</td><td>Season AVG</td>
                </tr>

                <?php
                  $sql = "SELECT sn.shirtNumber,fp.playerId 'playerId',fp.firstName,fp.lastName,fp.`position`,md.matchRating 'mRating',COUNT(gs.goalId) 'goalsScored',COUNT(`as`.assistId) 'assistsMade'
                  FROM matchData md
                  LEFT JOIN footballPlayers fp ON fp.playerId=md.playerId
                  LEFT JOIN goalsScored gs ON gs.fixtureId=md.fixtureId AND gs.playerId=md.playerId
                  LEFT JOIN assistsmade `as` ON `as`.fixtureId=md.fixtureId AND `as`.playerId=md.playerId
                  LEFT JOIN shirtNumbers sn ON sn.playerId=fp.playerId
                  WHERE md.startStatus='starter'
                  GROUP BY fp.playerId
                  ORDER BY
                     CASE fp.`position`
                        WHEN 'Goalkeeper' THEN 1
                        WHEN 'Defender' THEN 2
                        WHEN 'Midfielder' THEN 3
                        WHEN 'Forward' THEN 4
                        ELSE 5
                     END, playerId
                  " ;
                  $result = $conn->query($sql);


                  $shirtNumber=array();
                  $firstName=array();
                  $lastName=array();
                  $position=array();
                  $mRating=array();
                  $goalsScored=array();
                  $assistsMade=array();



                  if ($result->num_rows > 0) {
                      // output data of each row
                      while($row = $result->fetch_assoc()) {

                        $shirtNumber[]=$row["shirtNumber"];
                        $firstName[]=$row["firstName"];
                        $lastName[]=$row["lastName"];
                        $position[]=$row["position"];
                        $mRating[]=$row["mRating"];
                        $goalsScored[]=$row["goalsScored"];
                        $assistsMade[]=$row["assistsMade"];


                          echo "<tr>
                   <td>" . $row['shirtNumber']. "</td>
                   <td>" . $row['firstName']. "</td>
                   <td>" . $row['lastName']. "</td>
                   <td>" . $row['position']. "</td>
                   <td>" . $row['goalsScored']. "</td>
                   <td>" . $row['assistsMade']. "</td>
                   <td>" . $row['mRating']. "</td><td>Season AVG</td>
                </tr>

                  ";
                     }
                  } else {
                      echo "0 results";
                  }
                  $conn->close();

                  ?>

              </table>

              <table class="defaultText" width="750" height="200">

                <tr><td colspan="8" class="defaultTableBlueMidAlign"><div class="matchLineupTxt">Substitutes</div></td></tr>

                <tr>
                   <td>#</td>
                   <td>First Name</td>
                   <td>Surname</td>
                   <td>Position</td>
                   <td>Assists</td>
                   <td>Goals</td>
                   <td>Ratings</td><td>Season AVG</td>
                </tr>
                <tr>
                   <td>#</td>
                   <td>First Name</td>
                   <td>Surname</td>
                   <td>Position</td>
                   <td>Assists</td>
                   <td>Goals</td>
                   <td>Ratings</td><td>Season AVG</td>
                </tr>
                <tr>
                   <td>#</td>
                   <td>First Name</td>
                   <td>Surname</td>
                   <td>Position</td>
                   <td>Assists</td>
                   <td>Goals</td>
                   <td>Ratings</td><td>Season AVG</td>
                </tr>
                <tr>
                   <td>#</td>
                   <td>First Name</td>
                   <td>Surname</td>
                   <td>Position</td>
                   <td>Assists</td>
                   <td>Goals</td>
                   <td>Ratings</td><td>Season AVG</td>
                </tr>
                <tr>
                   <td>#</td>
                   <td>First Name</td>
                   <td>Surname</td>
                   <td>Position</td>
                   <td>Assists</td>
                   <td>Goals</td>
                   <td>Ratings</td><td>Season AVG</td>
                </tr>
                <tr>
                   <td>#</td>
                   <td>First Name</td>
                   <td>Surname</td>
                   <td>Position</td>
                   <td>Assists</td>
                   <td>Goals</td>
                   <td>Ratings</td><td>Season AVG</td>
                </tr>
                <tr>
                   <td>#</td>
                   <td>First Name</td>
                   <td>Surname</td>
                   <td>Position</td>
                   <td>Assists</td>
                   <td>Goals</td>
                   <td>Ratings</td><td>Season AVG</td>
                </tr>
              </table>






           </TD></TABLE>
           <TABLE>
           <TR>
           <TD width="750" height="370"><div class="defaultText">Default !</div></TD>
           </TR>
           </TABLE>
</TD>
<TD class="defaultTable" >
  <TABLE class="defaultTable"  width="450" height="175">
             <TD>
               <table class="matchDay" width="450" height="175">
               <td width="150"><img src="../img/clubLogos/brfc-1.png"></td>
               <td width="150"><div class="matchTitleTextImg">VS.</div></td>
               <td width="150"><img src="../img/clubLogos/arsenal-1.png"></td>
               </table>
             </TD></TABLE>
             <TABLE class="defaultTable">
             <TR>
               <TD class="defaultTableBlueMidAlign" width="100" height="110"><div class="matchTitleTextImg">0</div></TD>
             <TD class="defaultTableBlue" width="250" height="110">

             <div class="matchTitleText">Bristol Rovers</div>
             <div class="matchTitleTextSmall">VS.</div>
             <div class="matchTitleText">Arsenal XI</div>

             </TD>
             <TD class="defaultTableBlueMidAlign" width="100" height="110"><div class="matchTitleTextImg">1</div></TD>
             </TR>
             </TABLE>

             <TABLE class="defaultTable">
             <TR>
             <TD width="340" height="100">
              <div class="defaultText">
              <strong>Game Date: </strong> 18th July 2015, 3pm Kick Off.<br>
              <strong>Weather Conditions: </strong>22&#176; Overcast.<br>
              <strong>Referee: </strong>Douglas Walker<br>
              <strong>Attendance: </strong>6720 <strong>(</strong>721 Away<strong>)</strong></div>


             </TD>
             <TD width="110" height="100"><img id="weatherIcon" src="../img/weather/MostlyCloudy.png"></TD>
             </TR>
             </TABLE>

             <TABLE class="defaultTable">
             <TR>
             <TD width="450" height="235">
             <div class="defaultText">
              Gunner Stephy Mavididi proved the difference in this early pre-season friendly cleverly capitalising on an early defensive mixup between Tom Parkes & goalkeeper Steve Mildenhall.
              Rovers grew into the game in the second half with James Clarke shone in defence. Despite this, Rovers were unable to break the deadlock and never mounted any serious spells of sustained pressure on the young Arsenal XI's sides goal.
               Rovers fans will have been left encouraged by the return to action of Jermaine Easter who looked sharp after being brought on as a substitute on 60 minutes.



             </TD>
             </TR>
             </TABLE>
             <table>
               <tr>
             <td width="450" height="255">
               <iframe width="450" height="253" src="https://www.youtube.com/embed/lW_5pZi9avA" frameborder="0" allowfullscreen></iframe>
             </td>
           </tr>
           </table>
           <table>
             <tr>
           <td width="450" height="30">
             <div class="defaultTextCen">
             <strong>Match Highlights. Click bottom right to view full screen.</strong></td>
         </tr>
         </table>
           </TD>

</TABLE>

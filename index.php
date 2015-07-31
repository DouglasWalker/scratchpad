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
<TABLE class="defaultTable" width="1200" height="50">
<div class="matchTitleTextLarge">
Bristol Rovers Form Tracker
</div>
<div class="matchTitleText">
  Game Centre</div>
</table>

<br>

<TABLE class="defaultTable" width="1200" height="1000">


<TD class="defaultTable" >

  <table><tr>
  <TD class="defaultTableBlue" width="750" height="30">
  <div class="matchTitleText">Matchday Ratings</div>
</tr>
</table>

<table width="750">
 <tr>
       <td>

             <table class="defaultText" width="750">
               <tr><td colspan="7" class="defaultTableBlueMidAlign" height="25"><div class="matchLineupTxt">Starting Lineup</div></td></tr>

               <tr>
                    <td width='50' class="defaultTextCen">#</td>
                    <td width='150'>First Name</td>
                    <td width='150'>Surname</td>
                    <td width='130'>Position</td>
                    <td width='90' class="defaultTextCen">Assists</td>
                    <td width='90' class="defaultTextCen">Goals</td>
                    <td width='90' class="defaultTextCen">Ratings</td>
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
                   <td class='defaultTextCen'>" .$row['shirtNumber']. "</td>
                   <td>" .$row['firstName']. "</td>
                   <td>" .$row['lastName']. "</td>
                   <td>" .$row['position']. "</td>
                   <td class='defaultTextCen'>" .$row['goalsScored']. "</td>
                   <td class='defaultTextCen'>" .$row['assistsMade']. "</td>
                   <td class='defaultTextCen'>" .$row['mRating']. "</td>
                </tr>

                  ";
                     }
                  } else {
                      echo "0 results";
                  }


                  ?>

              </table>

              <table class="defaultText" width="750">

                <tr><td colspan="7" class="defaultTableBlueMidAlign"><div class="matchLineupTxt">Substitutes</div></td></tr>
                <tr>
                     <td width='50' class='defaultTextCen'>#</td>
                     <td width='150'>First Name</td>
                     <td width='150'>Surname</td>
                     <td width='130'>Position</td>
                     <td width='90' class='defaultTextCen'>Assists</td>
                     <td width='90' class='defaultTextCen'>Goals</td>
                     <td width='90' class='defaultTextCen'>Ratings</td>
                 </tr>
                <tr>
                <?php
                  $sql = "SELECT sn.shirtNumber,fp.playerId 'playerId',fp.firstName,fp.lastName,fp.`position`,md.matchRating 'mRating',COUNT(gs.goalId) 'goalsScored',COUNT(`as`.assistId) 'assistsMade'
                  FROM matchData md
                  LEFT JOIN footballPlayers fp ON fp.playerId=md.playerId
                  LEFT JOIN goalsScored gs ON gs.fixtureId=md.fixtureId AND gs.playerId=md.playerId
                  LEFT JOIN assistsmade `as` ON `as`.fixtureId=md.fixtureId AND `as`.playerId=md.playerId
                  LEFT JOIN shirtNumbers sn ON sn.playerId=fp.playerId
                  WHERE md.startStatus='substitute'
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
                  $result2 = $conn->query($sql);


                  $shirtNumber=array();
                  $firstName=array();
                  $lastName=array();
                  $position=array();
                  $mRating=array();
                  $goalsScored=array();
                  $assistsMade=array();



                  if ($result2->num_rows > 0) {
                      // output data of each row
                      while($row = $result2->fetch_assoc()) {

                        $shirtNumber[]=$row["shirtNumber"];
                        $firstName[]=$row["firstName"];
                        $lastName[]=$row["lastName"];
                        $position[]=$row["position"];
                        $mRating[]=$row["mRating"];
                        $goalsScored[]=$row["goalsScored"];
                        $assistsMade[]=$row["assistsMade"];


                          echo "

                   <td class='defaultTextCen'>" .$row['shirtNumber']. "</td>
                   <td>" .$row['firstName']. "</td>
                   <td>" .$row['lastName']. "</td>
                   <td>" .$row['position']. "</td>
                   <td class='defaultTextCen'>" .$row['goalsScored']. "</td>
                   <td class='defaultTextCen'>" .$row['assistsMade']. "</td>
                   <td class='defaultTextCen'>" .$row['mRating']. "</td>
                </tr>

                  ";
                     }
                  } else {
                      echo "0 results";
                  }


                  ?>


              </table>






           </TD></TABLE>
           <TABLE>
           <TR>
           <TD width="750" height="550"><div class="defaultText">Default !</div></TD>
           </TR>
           </TABLE>
</TD>


<?php
  $sql = "SELECT
fCH.clubName 'homeClubName',fCA.clubName 'awayClubName',fCH.clubImg 'homeImg',fCA.clubImg 'awayImg',f.homeGoals,f.awayGoals, f.kickoffTime,f.temperature,w.weatherName,w.weatherImg,CONCAT(r.firstName,' ',r.lastName) 'refName',att.totalAttendance,att.awayAttendance,f.matchReport
FROM fixtures f
LEFT JOIN footballClubs fCH ON fCH.clubId=f.homeTeamId
LEFT JOIN footballClubs fCA ON fCA.clubId=f.awayTeamId
LEFT JOIN referees r ON R.refereeId=f.refereeId
LEFT JOIN stadiums s ON f.stadiumId=s.stadiumId
LEFT JOIN weather w  ON w.weatherId=f.weatherId
LEFT JOIN attendances att ON att.fixtureId=f.fixtureId
WHERE f.fixtureId=1
  " ;
  $result3 = $conn->query($sql);


  $homeClubName=array();
  $awayClubName=array();
  $homeImg=array();
  $awayImg=array();
  $homeGoals=array();
  $awayGoals=array();
  $kickoffTime=array();
  $temperature=array();
  $weatherName=array();
  $weatherImg=array();
  $refName=array();
  $totalAttendance=array();
  $awayAttendance=array();
  $matchReport=array();


  if ($result3->num_rows > 0) {
      // output data of each row
      while($row = $result3->fetch_assoc()) {

        $homeClubName[]=$row["homeClubName"];
        $awayClubName[]=$row["awayClubName"];
        $homeImg[]=$row["homeImg"];
        $awayImg[]=$row["awayImg"];
        $homeGoals[]=$row["homeGoals"];
        $awayGoals[]=$row["awayGoals"];
        $kickoffTime[]=$row["kickoffTime"];
        $temperature[]=$row["temperature"];
        $weatherName[]=$row["weatherName"];
        $weatherImg[]=$row["weatherImg"];
        $refName[]=$row["refName"];
        $totalAttendance[]=$row["totalAttendance"];
        $awayAttendance[]=$row["awayAttendance"];
        $matchReport[]=$row["matchReport"];

          echo "

          <TD class='defaultTable'>
            <TABLE class='defaultTable'  width='450' height='175'>
                       <TD>
                         <table class='matchDay' width='450' height='175'>
                         <td width='150'><img src='../img/clubLogos/"
                          .$row['homeImg'].
                         "'></td>
                         <td width='150'><div class='matchTitleTextImg'>VS.</div></td>
                         <td width='150'><img src='../img/clubLogos/"
                          .$row['awayImg'].
                         "'></td>
                         </table>
                       </TD></TABLE>
                       <TABLE class='defaultTable'>
                       <TR>
                         <TD class='defaultTableBlueMidAlign' width='100' height='110'><div class='matchTitleTextImg'>"
                          .$row['homeGoals'].
                         "</div></TD>
                       <TD class='defaultTableBlue' width='250' height='110'>

                       <div class='matchTitleText'>"
                        .$row['homeClubName'].
                       "</div>
                       <div class='matchTitleTextSmall'>VS.</div>
                       <div class='matchTitleText'>"
                        .$row['awayClubName'].
                       "</div>

                       </TD>
                       <TD class='defaultTableBlueMidAlign' width='100' height='110'><div class='matchTitleTextImg'>"
                        .$row['awayGoals'].
                       "</div></TD>
                       </TR>
                       </TABLE>

                       <TABLE class='defaultTable'>
                       <TR>
                       <TD width='340' height='100'>
                        <div class='defaultText'>
                        <strong>Game Date: </strong> "
                         .$row['kickoffTime'].
                        "<br>
                        <strong>Weather Conditions: </strong>"
                         .$row['temperature'].
                        "&#176; "
                         .$row['weatherName'].
                        "<br>
                        <strong>Referee: </strong>"
                         .$row['refName'].
                        "<br>
                        <strong>Attendance: </strong>"
                         .$row['totalAttendance'].
                        "<strong>(</strong>"
                         .$row['awayAttendance'].
                        " Away<strong>)</strong></div>


                       </TD>
                       <TD width='110' height='100'><img id='weatherIcon' src='../img/weather/"
                        .$row['weatherImg'].
                       "'></TD>
                       </TR>
                       </TABLE>

                       <TABLE class='defaultTable'>
                       <TR>
                       <TD class='defaultTableBlue' width='450' height='40'>
                       <div class='defaultText'>
                      <div class='matchTitleText'>Match Report</div>


                       </TD>
                       </TR>
                       </TABLE>

                       <TABLE class='defaultTable'>
                       <TR>
                       <TD width='450' height='15'>

                       </TD>
                       </TR>
                       </TABLE>

                       <TABLE class='defaultTable'>
                       <TR>
                       <TD width='450' height='250'>
                       <div class='defaultText'>
                         "
                          .$row['matchReport'].
                         "
                       </TD>
                       </TR>
                       </TABLE>
                       <TABLE class='defaultTable'>
                       <TR>
                       <TD width='450' height='25'>
                      </TD>
                       </TR>
                       </TABLE>
                       <table>
                         <tr>
                       <td width='450' height='255'>
                         <iframe width='450' height='253' src='https://www.youtube.com/embed/lW_5pZi9avA' frameborder='0' allowfullscreen></iframe>
                       </td>
                     </tr>
                     </table>
                     <table>
                       <tr>
                     <td width='450' height='30'>
                       <div class='defaultTextCen'>
                       <strong>Match Highlights. Click bottom right to view full screen.</strong></td>
                   </tr>
                   </table>
                     </TD>

          </TABLE>
          ";
             }
          } else {
              echo "0 results";
          }


          ?>

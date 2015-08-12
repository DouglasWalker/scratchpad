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

<script>

		$(document).ready(function() {
				$('table td:nth-child(8)').each(function() {
					var Ratings = $(this).text();

					if ((Ratings > 0) && (Ratings < 4)) {
						$(this).css('backgroundColor', '#FF3300').css('color', '#FFFFFF');
					}
					else if((Ratings >= 4) && (Ratings < 6)) {
						$(this).css('backgroundColor', '#FF3300').css('color', '#000000');
					}
					else if((Ratings >= 6) && (Ratings < 8)) {
						$(this).css('backgroundColor', '#FF9933');
					}
          else if((Ratings >= 8) && (Ratings < 9)) {
            $(this).css('backgroundColor', '#2EB82E');
          }
          else if((Ratings >= 9) && (Ratings < 11)) {
            $(this).css('backgroundColor', '#2EB82E').css('color', '#FFFFFF');
          }
          else {
            $(this).css('backgroundColor', '#FFFFFFF');
          }
        				});
				return false;
			});


</script>



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
  <TD class="defaultTableBlue" width="750" height="30">
  <div class="matchTitleText">Matchday Ratings</div>
</tr>
</table>

<table width="750">
 <tr>
       <td>

             <table class="defaultText" width="750">
               <tr><td colspan="8" class="defaultTableBlueMidAlign" height="25"><div class="matchLineupTxt">Starting Lineup</div></td></tr>

               <tr>
                 <th width='50' class='defaultTableLiteBlueCen'>#</td>
                 <th width='150' class='defaultTableLiteBlueCen'>First Name</td>
                 <th width='150' class='defaultTableLiteBlueCen'>Surname</td>
                 <th width='65' class='defaultTableLiteBlueCen'>On</td>
								 <th width='65' class='defaultTableLiteBlueCen'>Off</td>
                 <th width='90' class='defaultTableLiteBlueCen'>Goals</td>
                 <th width='90' class='defaultTableLiteBlueCen'>Assists</td>
                 <th width='90' class='defaultTableLiteBlueCen'>Ratings</td>
                </tr>


								<?php

								$id = (int)$_GET['id'];

                  $sql = "SELECT sn.shirtNumber,fp.playerId 'playerId',fp.firstName,fp.lastName,sd.subbedOn,sd.subbedOff,ROUND(AVG(md.matchRating),2) 'mRating',
									IF(COUNT(gs.goalId)=0,NULL,COUNT(DISTINCT(gs.goalId))) 'goalsScored',
									IF(COUNT(`as`.assistId)=0,NULL,COUNT(DISTINCT(`as`.assistId))) 'assistsMade'
                  FROM matchData md
                  LEFT JOIN footballPlayers fp ON fp.playerId=md.playerId
                  LEFT JOIN goalsScored gs ON gs.fixtureId=md.fixtureId AND gs.playerId=md.playerId
                  LEFT JOIN assistsMade `as` ON `as`.fixtureId=md.fixtureId AND `as`.playerId=md.playerId
                  LEFT JOIN shirtNumbers sn ON sn.playerId=fp.playerId
                  LEFT JOIN subData sd ON sd.fixtureId=md.fixtureId AND sd.playerId=fp.playerId
									LEFT JOIN fixtures f ON f.fixtureId=md.fixtureId

									WHERE md.startStatus='starter' AND  md.fixtureId={$id} AND

			 							 md.matchRating IS NOT NULL
			                 GROUP BY md.playerId,md.fixtureId
			                 ORDER BY md.startStatus,
			                    CASE fp.`position`
			                       WHEN 'Goalkeeper' THEN 1
			                       WHEN 'Defender' THEN 2
			                       WHEN 'Midfielder' THEN 3
			                       WHEN 'Forward' THEN 4
			                       ELSE 5
			                    END, md.playerId
                  " ;
                  $result = $conn->query($sql);


                  $shirtNumber=array();
                  $firstName=array();
                  $lastName=array();
                  $subbedOn=array();
									$subbedOff=array();
                  $mRating=array();
                  $goalsScored=array();
                  $assistsMade=array();



                  if ($result->num_rows > 0) {
                      // output data of each row
                      while($row = $result->fetch_assoc()) {

                        $shirtNumber[]=$row["shirtNumber"];
                        $firstName[]=$row["firstName"];
                        $lastName[]=$row["lastName"];
                        $subbedOn[]=$row["subbedOn"];
												$subbedOff[]=$row["subbedOff"];
                        $mRating[]=$row["mRating"];
                        $goalsScored[]=$row["goalsScored"];
                        $assistsMade[]=$row["assistsMade"];


                          echo "<tr>
                   <td class='defaultTextCen'>" .$row['shirtNumber']. "</td>
                   <td class='defaultTextCen'>" .$row['firstName']. "</td>
                   <td class='defaultTextCen'>" .$row['lastName']. "</td>
                   <td class='defaultTextCen'>" .$row['subbedOn']. "</td>
									 <td class='defaultTextRedCen'>" .$row['subbedOff']. "</td>
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
								<tr>
									<td colspan="8" class="defaultTableBlueMidAlign" height="25"><div class="matchLineupTxt">Starting Lineup</div></td></tr>

								<tr>
									<th width='50' class='defaultTableLiteBlueCen'>#</td>
									<th width='150' class='defaultTableLiteBlueCen'>First Name</td>
									<th width='150' class='defaultTableLiteBlueCen'>Surname</td>
									<th width='65' class='defaultTableLiteBlueCen'>On</td>
									<th width='65' class='defaultTableLiteBlueCen'>Off</td>
									<th width='90' class='defaultTableLiteBlueCen'>Goals</td>
									<th width='90' class='defaultTableLiteBlueCen'>Assists</td>
									<th width='90' class='defaultTableLiteBlueCen'>Ratings</td>
								 </tr>
                <?php

								$id = (int)$_GET['id'];

                  $sql = "SELECT sn.shirtNumber,fp.playerId 'playerId',fp.firstName,fp.lastName,sd.subbedOn,sd.subbedOff,ROUND(AVG(md.matchRating),2) 'mRating',
									IF(COUNT(gs.goalId)=0,NULL,COUNT(gs.goalId)) 'goalsScored',
									IF(COUNT(`as`.assistId)=0,NULL,COUNT(`as`.assistId)) 'assistsMade'
                  FROM matchData md
                  LEFT JOIN footballPlayers fp ON fp.playerId=md.playerId
                  LEFT JOIN goalsScored gs ON gs.fixtureId=md.fixtureId AND gs.playerId=md.playerId
                  LEFT JOIN assistsMade `as` ON `as`.fixtureId=md.fixtureId AND `as`.playerId=md.playerId
                  LEFT JOIN shirtNumbers sn ON sn.playerId=fp.playerId
                  LEFT JOIN subData sd ON sd.fixtureId=md.fixtureId AND sd.playerId=fp.playerId
									LEFT JOIN fixtures f ON f.fixtureId=md.fixtureId

									WHERE md.startStatus='substitute' AND  md.fixtureId={$id} AND

			 							 md.matchRating IS NOT NULL
			                 GROUP BY md.playerId,md.fixtureId
			                 ORDER BY md.startStatus,
			                    CASE fp.`position`
			                       WHEN 'Goalkeeper' THEN 1
			                       WHEN 'Defender' THEN 2
			                       WHEN 'Midfielder' THEN 3
			                       WHEN 'Forward' THEN 4
			                       ELSE 5
			                    END, md.playerId

                  " ;
                  $result2 = $conn->query($sql);


                  if ($result2->num_rows > 0) {
                      // output data of each row
                      while($row = $result2->fetch_assoc()) {

												$shirtNumber[]=$row["shirtNumber"];
												$firstName[]=$row["firstName"];
												$lastName[]=$row["lastName"];
												$subbedOn[]=$row["subbedOn"];
												$subbedOff[]=$row["subbedOff"];
												$mRating[]=$row["mRating"];
												$goalsScored[]=$row["goalsScored"];
												$assistsMade[]=$row["assistsMade"];


                          echo "

													<td class='defaultTextCen'>" .$row['shirtNumber']. "</td>
			                    <td class='defaultTextCen'>" .$row['firstName']. "</td>
			                    <td class='defaultTextCen'>" .$row['lastName']. "</td>
			                    <td class='defaultTextGreenCen'>" .$row['subbedOn']. "</td>
			 									 <td class='defaultTextCen'>" .$row['subbedOff']. "</td>
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
           <TD width="750" height="550"><div class="defaultText">


             <?php
               $sql = "SELECT md.fixtureId,md.playerId,ROUND(AVG(md.matchRating),2) 'matchRating',md.startStatus,fp.`position`,CONCAT(fp.firstName,' ',fp.lastName) 'fullName2',ROUND(AVG(md2.matchRating),2) 'avgRating' FROM matchData md
                LEFT JOIN footballPlayers fp ON fp.playerId=md.playerId
                LEFT JOIN matchData md2 ON md2.playerId=md.playerId
                LEFT JOIN fixtures f ON f.fixtureId=md.fixtureId

					 	WHERE md.fixtureId={$id} AND

							 md.matchRating IS NOT NULL
                GROUP BY md.playerId,md.fixtureId
                ORDER BY md.startStatus,
                   CASE fp.`position`
                      WHEN 'Goalkeeper' THEN 1
                      WHEN 'Defender' THEN 2
                      WHEN 'Midfielder' THEN 3
                      WHEN 'Forward' THEN 4
                      ELSE 5
                   END, md.playerId


               " ;
               $result4 = $conn->query($sql);



               if ($result4->num_rows > 0) {
                   // output data of each row
                   while($row = $result4->fetch_assoc()) {

                     $matchRating[]=$row["matchRating"];
                     $startStatus[]=$row["startStatus"];
                     $fullNameArray[]=$row["fullName2"];
                     $position[]=$row["position"];
                     $avgRating[]=$row["avgRating"];

                     ;
                    }
                   } else {
                     }
                     ?>
                     <script>
                     $( document ).ready(function() {
                       $('#container').highcharts({

												 credits: {
            enabled: false
        },


                           chart: {
                               type: 'column'
                           },
                           title: {
                               text: 'Matchday Ratings'
                           },
                           xAxis: [{
                               categories: ['<?php echo implode("','", $fullNameArray);?>']
                           }],
                           yAxis: {
                               max: 10,

                               title: {
                                   text: ["Rating"],
                                                         }
                           },
                           series: [{
                               name: 'Player Rating',
                               data: [<?php echo implode(",", $matchRating);?>]
                           },
                           {
                               name: 'AVG Rating',
                               data: [<?php echo implode(",", $avgRating);?>]
                           }

                          ]

                          },function(chart){


                              $.each(chart.series[0].data,function(i,data){
                                      data.graphic.attr({
                                          fill:'#0066FF',

                                      });

                              });

                          });
                      });
</script>


<div id='container' style='width:750px; height:595px;'>

           </div></TD>
           </TR>

           </TABLE>
</TD>


<?php

$id = (int)$_GET['id'];

  $sql = "SELECT
fCH.clubName 'homeClubName',fCA.clubName 'awayClubName',fCH.clubImg 'homeImg',fCA.clubImg 'awayImg',f.homeGoals,f.awayGoals, DATE_FORMAT(f.kickoffTime,'%W %b %d %Y, %l:%i %p') 'kickoffTime',f.temperature,w.weatherName,w.weatherImg,CONCAT(r.firstName,' ',r.lastName) 'refName',s.stadiumImg,att.totalAttendance,att.awayAttendance,f.matchReport,f.highlightsURL,c.competitionName
FROM fixtures f
LEFT JOIN footballClubs fCH ON fCH.clubId=f.homeTeamId
LEFT JOIN footballClubs fCA ON fCA.clubId=f.awayTeamId
LEFT JOIN referees r ON r.refereeId=f.refereeId
LEFT JOIN stadiums s ON f.stadiumId=s.stadiumId
LEFT JOIN weather w  ON w.weatherId=f.weatherId
LEFT JOIN attendances att ON att.fixtureId=f.fixtureId
LEFT JOIN competitions c ON c.competitionId=f.competitionId
WHERE f.fixtureId={$id}
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
  $highlightsURL=array();
	$stadiumImg=array();
	$competitionName=array();


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
				$highlightsURL[]=$row["highlightsURL"];
				$stadiumImg[]=$row["stadiumImg"];
				$competitionName[]=$row["competitionName"];

          echo "

          <TD class='defaultTable'>
            <TABLE class='defaultTable'  width='450' height='175'>
                       <TD>
                         <table class='matchDay' width='450' height='175' background='../img/stadiums/" .$row['stadiumImg']. "'>
                         <td width='150'><center><img src='../img/clubLogos/"
                          .$row['homeImg'].
                         "'></center></td>
                         <td width='150'><div class='matchTitleTextImg'>VS</div></td>
                         <td width='150'><center><img src='../img/clubLogos/"
                          .$row['awayImg'].
                         "'></center></td>
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
                       <div class='matchTitleTextSmall'>VS</div>
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
                          <strong>Competition: </strong>
													"
													 .$row['competitionName'].
													"<br>
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
                        "<strong>&nbsp;(</strong>"
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
                       <TD width='450' height='10'>

                       </TD>
                       </TR>
                       </TABLE>

                       <TABLE class='defaultTable'>
                       <TR>
                       <TD width='450' height='175'>
                       <div class='defaultText'>
                         "
                          .$row['matchReport'].
                         "
                       </TD>
                       </TR>
                       </TABLE>
                       <TABLE class='defaultTable'>
                       <TR>
                       <TD width='450' height='10'>
                      </TD>
                       </TR>
                       </TABLE>
                       <table>
                         <tr>
                           <TD class='defaultTableBlue' width='450' height='40'>
                           <div class='defaultText'>
                          <div class='matchTitleText'>Match Highlights</div>
                           </TD>
                           <TD width='450' height='10'>
                          </TD>
                        </tr><tr>
                       <td width='450' height='255'>
                         <iframe width='450' height='253' src='

												 "
													.$row['highlightsURL'].
												 "

												 ' frameborder='0' allowfullscreen></iframe>
                       </td>
                     </tr>
                     </table>
                     <table>
                       <tr>



                     <td width='450' height='30'>
                       <div class='defaultTextCen'>
                       Click bottom right to view full screen.</td>
                   </tr>
                   </table>
                     </TD>
                   </tr>

          </TABLE>
          ";
             }
          } else {
              echo "0 results";
          }


          ?>

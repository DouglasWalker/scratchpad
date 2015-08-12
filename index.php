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

  <?php
    $sql = "SELECT
DATE_FORMAT(fn.dateAdded,'%W %b %d %Y, %l:%i %p') 'newsDate',
fn.newsTitle,
fn.newsContent FROM frontNews fn
WHERE fn.newsId=1
    " ;
    $result = $conn->query($sql);

    $newsTitle=array();
    $newsDate=array();
    $newsContent=array();

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {

          $newsTitle[]=$row["newsTitle"];
          $newsDate[]=$row["newsDate"];
          $newsContent[]=$row["newsContent"];

            echo "


  <table><tr>
  <TD class='defaultTableBlue' width='750' height='30'>
  <div class='matchTitleText'>Latest News</div>
</tr>
<tr height='10'></tr>
<td class='defaultTableLiteBlueCen'>" .$row['newsTitle']. " - " .$row['newsDate']. "</td>
<tr><td class='defaultTable' height='25'><div class='defaultText'>

" .$row['newsContent']. "


</div>

";
}
} else {
echo "0 results";
}

?>

</tr></td>
</table>




<table width="750">
 <tr>
       <td>


							<table class="defaultText" width="750">
							<tr><td class="defaultTableBlueMidAlign" height="25"><div class="matchTitleText">Secondary Header</div></td></tr>
							<tr height='10'></tr>
							<tr><td class="defaultTable" height="25"><div class="defaultText">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum
														</div>
							</tr></td>
              </table>






           </TD></TABLE>
           <TABLE>
           <TR>
           <TD width="750" height="550"><div class="defaultText">


             <?php
               $sql = "SELECT 'matchRating',CONCAT(fp.firstName,' ',fp.lastName) 'fullName',ROUND(AVG(md2.matchRating),2) 'avgRating' FROM matchData md
                LEFT JOIN footballPlayers fp ON fp.playerId=md.playerId
                LEFT JOIN matchData md2 ON md2.playerId=md.playerId
                WHERE md.matchRating IS NOT NULL
                GROUP BY md.playerId
                ORDER BY AVG(md2.matchRating) DESC
                LIMIT 5

               " ;
               $result = $conn->query($sql);



               if ($result->num_rows > 0) {
                   // output data of each row
                   while($row = $result->fetch_assoc()) {

                     $matchRating[]=$row["matchRating"];
                     $fullNameArray[]=$row["fullName"];
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
                               type: 'bar'
                           },
                           title: {
                               text: 'Top 5 Season Average Ratings'
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


<div id='container' style='width:750px; height:450px;'>

           </div></TD>
           </TR>

           </TABLE>
</TD>


<?php
$sql = "SELECT

DATE_FORMAT(f.kickoffTime,'%W %b %d %Y, %l:%i %p') 'kickoffDate',
c.competitionName 'compName',
IF(s.stadiumName='The Memorial Stadium','Home','Away') 'venue',
fch.clubName 'homeTeamName',
fca.clubName 'awayTeamName',
s.stadiumName,s.stadiumImg,
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
      $stadiumImg[]=$row["stadiumImg"];
      $homeImg[]=$row["homeImg"];
      $awayImg[]=$row["awayImg"];


        echo "

				<TD class='defaultTable'>
					<table class='defaultTable' width='450'>
						<tr>
							<td class='defaultTableBlueMidAlign' height='25'><div class='matchTitleText'><a href='../fixtures.php'>Upcoming Fixture</a></div></td></tr>
					</table>

					<table class='defaultTable'  width='450' height='175'>
						 <td>
							 <table class='matchDay' width='450' height='175' background='../img/stadiums/" .$row['stadiumImg']. "'>

									<td width='150'>
										<a href='../fixtures.php'><img src='../img/clubLogos/"
												.$row['homeImg'].
											 "'></a>
									</td>

									<td width='150'>
										<div class='matchTitleTextImg'><a href='../fixtures.php'>VS</a>
										</div>
									</td>

									<td width='150'><a href='../fixtures.php'><center>
										<img src='../img/clubLogos/"
												.$row['awayImg'].
											 "'></center></a>
									</td>

							</table>
						</td>
					</table>

					<table class='defaultTable'>
						<TR>
							<td class='defaultTableBlue' width='450' height='85'>
										 <div class='matchTitleText'><a href='../fixtures.php'><center>"
											.$row['homeTeamName'].
										 "<center></a></div>
										 <div class='matchTitleTextSmall'>VS</div>
										 <div class='matchTitleText'><a href='../fixtures.php'>"
											.$row['awayTeamName'].
										 "</a></div>
							</td>

						</tr>
					</table>
					<table class='defaultTable' width='450'>
										<tr><td class='defaultTableLiteBlueCen' height='35'><a href='../fixtures.php'>"
										 .$row['compName'].
										"</a>, "
										 .$row['kickoffDate']. "
									<br>"
                   .$row['stadiumName']. "
                </td>
										</tr>
				 </table>
<table><tr height='10'></tr></table>
					 ";
				 		 }
				 	} else {
				 			echo "0 results";
				 	}


				 	?>

					 <?php



					   $sql = "SELECT
					 fCH.clubName 'homeClubName',fCA.clubName 'awayClubName',
           fCH.clubImg 'homeImg',fCA.clubImg 'awayImg',f.homeGoals,
           f.awayGoals,
           DATE_FORMAT(f.kickoffTime,'%W %b %d %Y, %l:%i %p') 'kickoffDate',
           f.temperature,w.weatherName,
           w.weatherImg,CONCAT(r.firstName,' ',r.lastName) 'refName',
           c.competitionName,att.totalAttendance,att.awayAttendance,
           f.matchReport,f.highlightsURL,s.stadiumImg,s.stadiumName
					 FROM fixtures f
					 LEFT JOIN footballClubs fCH ON fCH.clubId=f.homeTeamId
					 LEFT JOIN footballClubs fCA ON fCA.clubId=f.awayTeamId
					 LEFT JOIN referees r ON r.refereeId=f.refereeId
					 LEFT JOIN stadiums s ON f.stadiumId=s.stadiumId
					 LEFT JOIN weather w  ON w.weatherId=f.weatherId
					 LEFT JOIN attendances att ON att.fixtureId=f.fixtureId
					 LEFT JOIN competitions c ON c.competitionId=f.competitionId
           WHERE f.kickoffTime < CURRENT_DATE()
           OR (      f.kickoffTime = CURRENT_DATE()
           AND f.kickoffTime <= CURRENT_TIME()
               )
           ORDER BY f.kickoffTime DESC LIMIT 1
					   " ;
					   $result3 = $conn->query($sql);




					   $homeClubName=array();
					   $awayClubName=array();
					   $homeImg=array();
					   $awayImg=array();
					   $homeGoals=array();
					   $awayGoals=array();
					   $kickoffDate=array();
					   $temperature=array();
					   $weatherName=array();
					   $weatherImg=array();
					   $refName=array();
					   $totalAttendance=array();
					   $awayAttendance=array();
             $stadiumImg=array();
					   $matchReport=array();
					   $highlightsURL=array();
					 	$competitionName=array();
            $stadiumName=array();



					   if ($result3->num_rows > 0) {
					       // output data of each row
					       while($row = $result3->fetch_assoc()) {

					         $homeClubName[]=$row["homeClubName"];
					         $awayClubName[]=$row["awayClubName"];
					         $homeImg[]=$row["homeImg"];
					         $awayImg[]=$row["awayImg"];
					         $homeGoals[]=$row["homeGoals"];
					         $awayGoals[]=$row["awayGoals"];
					         $kickoffDate[]=$row["kickoffDate"];
					         $temperature[]=$row["temperature"];
					         $weatherName[]=$row["weatherName"];
					         $weatherImg[]=$row["weatherImg"];
					         $refName[]=$row["refName"];
					         $totalAttendance[]=$row["totalAttendance"];
					         $awayAttendance[]=$row["awayAttendance"];
					         $matchReport[]=$row["matchReport"];
					 				$highlightsURL[]=$row["highlightsURL"];
					 				$competitionName[]=$row["competitionName"];
                  $stadiumImg[]=$row["stadiumImg"];
                  $stadiumImg[]=$row["stadiumName"];

					           echo "

					 	<table class='defaultTable' width='450'>
					 		<tr>
					 			<td class='defaultTableBlueMidAlign' height='25'><div class='matchTitleText'>Latest Result</div></td></tr>
					 	</table>

					 	<table class='defaultTable'  width='450' height='175'>
					 		 <td>
					 			 <table class='matchDay' width='450' height='175' background='../img/stadiums/" .$row['stadiumImg']. "'>

					 					<td width='150'>
					 						<img src='../img/clubLogos/"
					 								.$row['homeImg'].
					 							 "'>
					 					</td>

					 					<td width='150'>
					 						<div class='matchTitleTextImg'>VS
					 						</div>
					 					</td>

					 					<td width='150'>
					 						<img src='../img/clubLogos/"
					 								.$row['awayImg'].
					 							 "'>
					 					</td>

					 			</table>
					 		</td>
					 	</table>

					 	<table class='defaultTable'>
					 		<TR>
					 			<td class='defaultTableBlueMidAlign' width='100' height='110'><div class='matchTitleTextImg'>"
					 							.$row['homeGoals'].
					 							 "</div>
					 			</td>

					 			<td class='defaultTableBlue' width='250' height='110'>
					 						 <div class='matchTitleText'>"
					 							.$row['homeClubName'].
					 						 "</div>
					 						 <div class='matchTitleTextSmall'>VS</div>
					 						 <div class='matchTitleText'>"
					 							.$row['awayClubName'].
					 						 "</div>
					 			</td>

					 			<td class='defaultTableBlueMidAlign' width='100' height='110'><div class='matchTitleTextImg'>"
					 							.$row['awayGoals'].
					 						 "</div>
					 			</td>

					 		</tr>
					 	</table>

            <table class='defaultTable' width='450'>
  										<tr><td class='defaultTableLiteBlueCen' height='35'>"
  										 .$row['competitionName'].
  										", "
  										 .$row['kickoffDate']. "
  									<br>"
                     .$row['stadiumName']. "
                  </td>
  										</tr>
  				 </table>



				 </td>
        </TABLE>
          ";
             }
          } else {
              echo "0 results";
          }


          ?>

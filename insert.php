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

<?php

$nameInsert = $_POST['stadium'];
$buildDateInsert = $_POST['buildDate'];
$seatedCapacityInsert = $_POST['seatedCapacity'];
$overallCapacityInsert = $_POST['overallCapacity'];

?>

<?php



  $stadium = "INSERT INTO stadiums (stadiumName, buildDate, seatedCapacity, overallCapacity)
  VALUES ('$_POST[stadium]','$_POST[buildDate]','$_POST[seatedCapacity]','$_POST[overallCapacity]')";

  if ($conn->query($stadium) === TRUE) {
      echo "New record created successfully.<br><br>
      <a href='http://localhost/form.php'>Return to form.</a>" ;
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

  ?>

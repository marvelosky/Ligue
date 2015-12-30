<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "calendar";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$Day = "Monday";
$Player1 = "Random0";
$Player2 = "Random1";
$TimePeriod = "0800-0830";
$j = 0;


$Matches[$j] = array($Player1, $Player2, $Day, $TimePeriod);
$F1 = False;
$F2 = False;


for($i = 0; $i < 2; $i++){

	$sqlUpdate = "UPDATE ".$Day." SET IsMatched=IsMatched+1 WHERE Name='".$Matches[$j][$i]."'";
	
	if ($conn->query($sqlUpdate) === TRUE) {
		echo "<br>Data updated succesfully<br>";
	} else {
		echo "<br>Error: " . $sqlUpdate . "<br>" . $conn->error;
	}
}

$j++;

?>
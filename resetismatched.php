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

$Week = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");

for($DayRotation = 0; $DayRotation < 7; $DayRotation++) {
	
	$Day = $Week[$DayRotation];
	
		
	$sqlUpdate = "UPDATE ".$Day." SET IsMatched='0'";
	
	if ($conn->query($sqlUpdate) === TRUE) {
		echo "<br>Data updated succesfully on the table : ".$Day."<br>";
	} else {
		echo "<br>Error: " . $sqlUpdate . "<br>" . $conn->error;
	}
}



?>
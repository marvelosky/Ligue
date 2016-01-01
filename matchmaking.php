<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "calendar";

$j = 0;
$Matches = array();
$Player1 = "";
$Player2 = "";
$Week = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Run through the 7 days (tables) of the database
for($DayRotation = 0; $DayRotation < 7; $DayRotation++) {
	
	$Day = $Week[$DayRotation];
	$val1 = 0;
	$val2 = 30;

	// Run through the 48 time periods of the table
	for($DailyRun = 0; $DailyRun < 48; $DailyRun++) {
		
		$Players = array();
		
		// Formatting the time period to match the array's
		$val1 = str_pad($val1, 4, 0, STR_PAD_LEFT);
		$val2 = str_pad($val2, 4, 0, STR_PAD_LEFT);
		$TimePeriod = $val1."-".$val2;

		$sqlSelect = "SELECT Name, `".$TimePeriod."`, IsMatched FROM ".$Day."";

		$result = $conn->query($sqlSelect);
		
		// Dump the query into an array
		while($rowFetch = $result->fetch_assoc()) {
			$Players[] = $rowFetch;
		}	

		// Setting the data for the for loop
		$length = count($Players);
		$Skip = False;
		$F1 = False;
		
		// Running through the players array to find Player1, then Player2 and match them
		for ($row = 0; $row < $length; $row++) {
			$Name = $Players[$row]['Name'];
			$Time = $Players[$row][$TimePeriod];
			$IsM = $Players[$row]['IsMatched'];
			
			// Player1 and Player2 found, updating the array and the database
			if ($F1 && $Time && $IsM < 3) {
				$Player2 = $Name;
				$Matches[$j] = array($Player1, $Player2, $Day, $TimePeriod);
				$F1 = False;
				// $F2 = False;
				echo "<br>".$Player1." vs ".$Player2." at ".$TimePeriod." on ".$Day."<br>";
				// Update IsMatched				
				for($i = 0; $i < 2; $i++){
					$sqlUpdate = "UPDATE ".$Day." SET IsMatched=IsMatched+1 WHERE Name='".$Matches[$j][$i]."'";
					
					if ($conn->query($sqlUpdate) === TRUE) {
						echo "Updated player ".$Matches[$j][$i]."<br>";
					} else {
						echo "<br>Error: " . $sqlUpdate . "<br>" . $conn->error;
					}
				}
				$j++;
				$Player1 = "";
				$Player2 = "";
				$Skip = True;
			}
			// Looking for Player1
			if (!$Skip && !$F1 && $Time && $IsM < 3) {
				$Player1 = $Name;
				$F1 = True;
			}
			$Skip = False;
		}
		
		// Incrementing the timestamp
		if(substr($val1, -2) == "00") {
			$val1 += 30;
			$val2 += 70;
		}
		elseif (substr($val1, -2) == "30") {
			$val1 += 70;
			$val2 += 30;
		}
		
		// Clearing the $Players array for the next check
		unset($Players);
	}
	
}

var_dump($Matches);

// RIP Connection
$conn->close();
// Testing Github changes
?>
<script>
	//Citation: https://stackoverflow.com/questions/7763327/how-to-calculate-date-difference-in-javascript(trisweb answer)
	//Checks if there is at least 1 week gap between two dates.
     function compareDates() {       
         var startDate = new Date(document.getElementById("MigraineStartTimestamp").value);
         var endDate = new Date(document.getElementById("MigraineEndTimestamp").value);

         var difference = endDate - startDate;
         var numberOfDays = Math.floor((difference)/(1000*60*60*24));

         if(numberOfDays>=7){
         	return true;

         }
         else{
         	alert("Please make sure the difference from Starting to Ending date is at least a week.")
         	return false;
         }       
}
   
</script>



<?php
	ini_set('display_errors', 'On');
	//Connects to the database
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu","ghiraldj-db","v1bptepGowZ4t1OE","ghiraldj-db");

	if($mysqli->connect_errno){
	  echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">  
  <title>Migraine Tracker</title>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	<!-- Personal CSS -->
	<link rel="stylesheet" type="text/css" href="styles.css"/>

</head>

	<body>
		<!--Navigation menu bar-->
		<!--Citation: https://getbootstrap.com/components/#navbar-->
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<ul class="nav navbar-nav">
					<li><a href="home.php">Home</a></li>
					<li><a href="main.php">Migraine Form</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Results<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li class="dropColor"><a href="mostCommonTriggers.php">Most Common Triggers</a></li>
							<li class="dropColor"><a href="averageMigraineAttack.php">Average Migraine Attack</a></li>
							<li class="dropColor"><a href="averageMigraineDuration.php">Average Migraine Duration</a></li>
							<li class="dropColor"><a href="averageMigraineIntensity.php">Average Migraine Intensity</a></li>
						</ul>
					</li>							
				</ul>

				<ul class="nav navbar-nav navbar-right">
           			<li><a href="landing.html">Logout</a></li>
       			</ul>
			</div>
		</nav>

		<div class="formStyle">
			<h2>Average Migraine Duration Form</h2>
				<form class="form-horizontal" role="form" name="migraineForm" method="post" onsubmit="return compareDates()">
						<label class="labelStyle" for="text">UserScreenName:</label>					
						<input type="text" name="UserScreenName" id="UserScreenName" ><br>	
						<br>
				
						Please enter dates in the following format YYYY-MM-DD HH::MM:SS. For example, 2017-07-02 14::35:10
						<br>


						<label class="labelStyle" for="text">Migraine Start Date and Time:</label>
						<input type="datetime" name="MigraineStartTimestamp" id="MigraineStartTimestamp"> 
						<br>

						<label class="labelStyle" for="text">Migraine End Date and Time:</label>
						 <input type="datetime" name="MigraineEndTimestamp" id="MigraineEndTimestamp">
						<br>
					<div class="buttonAlign">
						<input type="reset" class="buttonStyle" id="migraineDataCancel" value="Cancel">
						<button type="submit" class="buttonStyle" id="migraineDataSubmit" value="Add Migraine Data" onclick="window.location='averageMigraineDuration.php'">Submit</button>
					</div>
				</form>
		</div>

		<div class="container-fluid text-center" id="triggerDiv">
			<table class="table" id="triggersTable" align="center">
				<div class="container-fluid text-center">
					<h2 id="triggerName">Average Migraine Duration Result</h2>
				</div>

			<tr>
				<th class="thStyle">Trigger</th>
				<th class="thStyle">Number of Triggers</th>
				<th class="thStyle">Number of Migraines</th>
				<th class="thStyle">Percentage</th>
			</tr>
			
			<!-- MySqli statements for filling table -->
		
			<?php
				if( isset($_POST['UserScreenName']) ){
					
					$user = $_POST['UserScreenName'];	  
					$start = $_POST['MigraineStartTimestamp'];
					$end = $_POST['MigraineEndTimestamp'];			  
			  
					if(!($stmt = $mysqli->prepare(
						"
						

						" 
						))){
						echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
					}
				  
					if(!$stmt->execute()){
						echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
					
					if(!$stmt->bind_result($Triggers, $NumberofTriggers, $NumberOfMigraines, $Percentage
						)){
						echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
					}
				  
					while($stmt->fetch()){
						echo "<tr>\n<td>\n" . $Triggers . "\n</td>\n<td>\n" . $NumberofTriggers . "\n</td>\n<td>\n" . $NumberOfMigraines . "\n</td>\n<td>\n" . $Percentage . "\n</td>\n<tr>\n";
					}

					$stmt->close();
				}
			?>
			</table>
		</div>		
	</body>
</html>
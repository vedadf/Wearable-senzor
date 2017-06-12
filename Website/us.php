<?php

	function ConnectDb(){	    
	    $localhost = "ftp.cijena.ba";
	    $dbuser = "cijenaba_admin";
	    $dbpass = "admin2017";
	    $dbname = "cijenaba_USProjekat";	    
	    $conn = new mysqli($localhost, $dbuser, $dbpass, $dbname);	    
	    if($conn->connect_error) return false;	    
	    return $conn;	    
	}

	function GetDataFromURI(){    
	    if(isset($_GET['data'])){             
	        return $_GET['data'];         
		}
	    return false;    
	}

	function InsertDataToTableDB($data, $conn){
    	$sql = "INSERT INTO Temperatura VALUES (DEFAULT, NOW(), ".$data.")";
    	$result = $conn->query($sql);
    	if(!$result){
			return false;
		}
    	return true;
	}

	function SelectDataFromTableDB($conn){
	    $sql = "SELECT ID, DATE_FORMAT(Vrijeme, '%H:%i') as Vrijeme, Temperatura FROM Temperatura ORDER BY ID";
	    $result = $conn->query($sql);

	    return $result;
	} 

	function ShowTable($conn){

		$result = SelectDataFromTableDB($conn);

		echo '
		<div class="col-lg-4 col-md-4 col-xs-12 mx-auto">
			<br>  
			   	<table class = "table table-bordered table-hover table-sm">
			 	 <thead class="thead-default"> 
				   <tr>
				    <th>Vrijeme</th>
					<th>Temperatura</th>
				   </tr>
			     </thead>';
		
		while($row = $result->fetch_assoc()){
			echo '<tr>';
			echo '<td>'.$row['Vrijeme'].'</td>';
			echo '<td>'.$row['Temperatura']. '</td>';
			echo '</tr>';
		}
		echo '</table></div>';

	}

?>

<!DOCTYPE html>
<html lang="en">

   <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css" >
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" >       

    <title>Ugradbeni Sistemi</title>

    <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
		
	<!-- chart.js -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>

  </head>
  <body>
	<canvas id='myChart' ></canvas>
	<style type="text/css">
		#myChart {
			height: 400px;
			width: : 100%;	
		}
	</style>
			    <?php
			    	$conn = ConnectDb();
			    	echo "
						<script type='text/javascript'>
							var ctx = document.getElementById('myChart').getContext('2d');
							var myChart = new Chart(ctx, {
							  type: 'line',
							  data: {
		  			";
			    	echo "labels: [";
					$result = SelectDataFromTableDB($conn);
					while($row = $result->fetch_assoc()){
						echo "'" .$row['Vrijeme']. "',";
					}
					echo "'X'],";
				   	echo "
					    datasets: [{
					      label: 'Temperatura',
						    ";
			    	echo "data: [";
			    	$result = SelectDataFromTableDB($conn);
					while($row = $result->fetch_assoc()){
						echo $row['Temperatura']. ",";
					}
					echo "0],";
			    ?>	      
		      backgroundColor: "rgba(255,153,0,0.4)"
		    }]
		  }
		});

	</script>
	<script type="text/javascript">
		window.setTimeout(reload, 2500);
		function reload() {
			// body...
			location.reload();
		}
	</script>
	<?php

		$conn = ConnectDb();
		ShowTable($conn);

		$value = GetDataFromURI();
		if(InsertDataToTableDB($value, $conn)){
			echo "<h1>DATA SENT: ".$value." </h1>";
		}

		$conn->close();


	?>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

	</body>
</html>
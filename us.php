
<?php



	if(isset($_GET['data'])){

	

		$localhost = "ftp.cijena.ba";

		$dbuser = "cijenaba_admin";

		$dbpass = "admin2017";

		$dbname = "cijenaba_USProjekat";



		$conn = new mysqli($localhost, $dbuser, $dbpass, $dbname);



		if($conn->connect_error){ echo "error";}

		else{		

			echo  $_GET["data"];

			$value = $_GET['data'];

			$sql = "INSERT INTO Temperatura VALUES (DEFAULT, NOW(), ".$value.")";

			$result = $conn->query($sql);

			if(!$result){

				echo "inavlid quer";

			}

			echo "<h1>DATA SENT</h1>";

			$conn->close();

		}

		

		

	}


	if(isset($_POST['data'])){

	

		$localhost = "ftp.cijena.ba";

		$dbuser = "cijenaba_admin";

		$dbpass = "admin2017";

		$dbname = "cijenaba_USProjekat";



		$conn = new mysqli($localhost, $dbuser, $dbpass, $dbname);



		if($conn->connect_error){ echo "error";}

		else{		

			echo  $_POST["data"];

			$value = $_POST['data'];

			$sql = "INSERT INTO Temperatura VALUES (DEFAULT, NOW(), ".$value.")";

			$result = $conn->query($sql);

			if(!$result){

				echo "inavlid quer";

			}

			echo "<h1>DATA SENT</h1>";

			$conn->close();

		}

		

		

	}
/*
	function InsertDataToTableDB($data, $conn){
			$sql = "INSERT INTO Temperatura VALUES (DEFAULT, 0, ".$data.")";
			return $conn->query($sql);
	}
	function SelectDataFromTable DB($conn){
			$sql = "SELECT * FROM Temperatura";
			$result = $conn->query($sql);
			return $result;
			//return $result->fetch_assoc();
	} 
	*/



	



?>
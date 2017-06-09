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
    	$sql = "INSERT INTO Temperatura VALUES (DEFAULT, 0, ".$data.")";
    	$result = $conn->query($sql);
    	if(!$result){
			return false;
		}
    	return true;
	}

	function SelectDataFromTableDB($conn){
	    $sql = "SELECT * FROM Temperatura";
	    $result = $conn->query($sql);

	    return $result;
	} 

	$conn = ConnectDb();
	$value = GetDataFromURI();
	if(InsertDataToTableDB($value, $conn)){
		echo "<h1>DATA SENT: ".$value." </h1>";
	}

	$conn->close();


?>
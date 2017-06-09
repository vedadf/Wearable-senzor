<?php


function ConnectDb(){
    
    $localhost = "ftp.cijena.ba";
    $dbuser = "cijenaba_admin";
    $dbpass = "admin2017";
    $dbname = "cijenaba_USProjekat";
    
    $conn = new mysqli($localhost, $dbuser, $dbpass, $dbname);
    
    if($conn->connect_error) return false;
    
    return true;
    
}


function GetDataFromURI(){
    
    if(isset($_GET['data'])){
        
        $data = $_GET['data'];
        
        return $data;
        
    }
    
    return false;
    
}



function InsertDataToTableDB($data, $conn){

        $sql = "INSERT INTO Temperatura VALUES (DEFAULT, 0, ".$data.")";

        return $conn->query($sql);

}

function SelectDataFromTable DB($conn){

    $sql = "SELECT * FROM Temperatura";
    $result = $conn->query($sql);

    return $result;


} 

?>
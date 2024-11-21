<?php 

// This file contains the database access information. 
// This file establishes a connection to MySQL and selects the database.

// Set the database access information as constants:
const DBCONNSTRING ='mysql:host=localhost;dbname=CSC355FA24Finance';
const DB_USER = 'odh1818';
const DB_PASSWORD = 'AFxFEhhxrnQ5Gi';


// Make the connection:
try{
	$dbc = new PDO(DBCONNSTRING, DB_USER, DB_PASSWORD);
} catch (PDOException $e){
	echo $e->getMessage();
}

?>
<?php
	ini_set('display_errors', 1);
//Name: 
/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
	if(isset($_POST['submit'])) { //Form was submitted
		
		$selected = 0
		try{
			
			require_once('../../../pdo_connect.php'); //adjust the relative path as necessary to find your connect file
			$stmt = $dbc->prepare("SELECT * FROM Debt WHERE DebtID = :DebtID");
			$stmt->bindParam(':DebtID', $_POST['DebtID'], PDO::PARAM_INT);
			$stmt->execute();
			$selectedRow = $stmt->fetch(PDO::FETCH_ASSOC);

			if ($selectedRow)
				$selected = 1
	
		} catch (PDOException $e){
			echo $e->getMessage();
		}	
		if ($selected == 0){
			echo "DebtID number invalid. Please try again";
			exit;
		}	
		else {
			$result = $stmt->fetchAll();
		}
	} //end isset
	else {
		echo "<h2>You have reached this page in error</h2>";
		exit;
	}
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Debt View result</title>
	<meta charset ="utf-8"> 
</head>
</html>
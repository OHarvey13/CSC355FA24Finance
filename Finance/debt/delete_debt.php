<?php
	ini_set('display_errors', 1);
//Name: 
/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
	if(isset($_POST['submit'])) { //Form was submitted


		try{
			require_once('../../../pdo_connect.php'); //adjust the relative path as necessary to find your connect file
			
			$stmt = $dbc->prepare("SELECT * FROM Debt WHERE DebtID = :DebtID");
			$stmt->bindParam(':DebtID', $_POST['DebtID'], PDO::PARAM_INT);
			$stmt->execute();
			$deletedRow = $stmt->fetch(PDO::FETCH_ASSOC);

			if ($deletedRow)
				$sql = 'DELETE FROM Debt WHERE DebtID = :DebtID';

				$stmt = $dbc->prepare($sql);
				$stmt->bindParam(':DebtID', $_POST['DebtID'], PDO::PARAM_INT);
				$stmt->execute();
				print_r($deletedRow);


			$stmt->execute();	
		} catch (PDOException $e){
			echo $e->getMessage();
		}	
		$affected = $stmt->RowCount();
		if ($affected == 0){
			echo "We could not delete from Debt.";
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
    <title>Debt delete result</title>
	<meta charset ="utf-8"> 
</head>
<body>
	<h2> Deleted Data: </h2>
	<table>
		<tr>
			<th>Deleted Debt ID</th>
	<?php foreach($result as $row) {
		echo "<tr>";
		echo "<td>".$_POST['DebtID']."</td>";
		echo "</tr>";
	}?> 
	</table>
</body>
</html>
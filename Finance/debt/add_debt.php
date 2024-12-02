<?php
	ini_set('display_errors', 1);
//Name: Ej Boakye
/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
	if(isset($_POST['submit'])) { //Form was submitted
		
		try{
			require_once('../../../pdo_connect.php'); //adjust the relative path as necessary to find your connect file
			$sql = 'INSERT INTO Debt (DebtID, UserID, DebtType, Amount, InterestRate, PaymentDueDate) 
			VALUES (:DebtID, :UserID, :DebtType, :Amount, :InterestRate, :PaymentDueDate)';
			
			$stmt = $dbc->prepare($sql);
			$stmt->bindParam(':DebtID', $_POST['DebtID'], PDO::PARAM_INT);
			$stmt->bindParam(':UserID', $_POST['UserID'], PDO::PARAM_INT);
			$stmt->bindParam(':DebtType', $_POST['DebtType'], PDO::PARAM_STR);
			$stmt->bindParam(':Amount', $_POST['Amount'], PDO::PARAM_STR);
			$stmt->bindParam(':InterestRate', $_POST['InterestRate'], PDO::PARAM_STR);
			$stmt->bindParam(':PaymentDueDate', $_POST['PaymentDueDate'], PDO::PARAM_STR);

			$stmt->execute();	
		} catch (PDOException $e){
			echo $e->getMessage();
		}	
		$affected = $stmt->RowCount();
		if ($affected == 0){
			echo "We could not insert into Debt.";
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
    <title>Debt Submit result</title>
	<meta charset ="utf-8"> 
</head>
<body>
	<h2> Inserted Data: </h2>
	<table>
		<tr> 
			<th>Debt ID</th>
			<th>User ID</th>
			<th>Debt Type</th>
			<th>Amount</th>
			<th>Interest Rate</th>
			<th>Payment Due-Date</th>
		</tr>
	<?php 
		echo "<tr>";
		echo "<td>".$_POST['DebtID']."</td>";
		echo "<td>".$_POST['UserID']."</td>";
		echo "<td>".$_POST['DebtType']."</td>";
		echo "<td>".$_POST['Amount']."</td>";
		echo "<td>".$_POST['InterestRate']."</td>";
		echo "<td>".$_POST['PaymentDueDate']."</td>";
		// echo "Affected rows: " . $affected;
		echo "</tr>";
	?> 
	</table>
</body>
</html>
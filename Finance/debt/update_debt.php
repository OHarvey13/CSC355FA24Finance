<?php
	ini_set('display_errors', 1);
//Name: Ej
/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
	if(isset($_POST['submit'])) { //Form was submitted

		try{
			require_once('../../../pdo_connect.php'); //adjust the relative path as necessary to find your connect file
			
			$sql = 'UPDATE Debt SET ';

			$updateFields = [];
			if (!empty($_POST['DebtType'])) {
				$updateFields[] = "DebtType = :DebtType";
			}
			if (!empty($_POST['Amount'])) {
				$updateFields[] = "Amount = :Amount";
			}
			if (!empty($_POST['InterestRate'])) {
				$updateFields[] = "InterestRate = :InterestRate";
			}
			if (!empty($_POST['PaymentDueDate'])) {
				$updateFields[] = "PaymentDueDate = :PaymentDueDate";
			}

			if (count($updateFields) > 0) {
				$sql .= implode(', ', $updateFields) . ' WHERE DebtID = :DebtID AND UserID = :UserID';
				$stmt = $dbc->prepare($sql);

				$stmt->bindParam(':DebtID', $_POST['DebtID'], PDO::PARAM_INT);
				$stmt->bindParam(':UserID', $_POST['UserID'], PDO::PARAM_INT);
				if (!empty($_POST['DebtType'])) {
					$stmt->bindParam(':DebtType', $_POST['DebtType'], PDO::PARAM_STR);
				}
				if (!empty($_POST['Amount'])) {
					$stmt->bindParam(':Amount', $_POST['Amount'], PDO::PARAM_STR);
				}
				if (!empty($_POST['InterestRate'])) {
					$stmt->bindParam(':InterestRate', $_POST['InterestRate'], PDO::PARAM_STR);
				}
				if (!empty($_POST['PaymentDueDate'])) {
					$stmt->bindParam(':PaymentDueDate', $_POST['PaymentDueDate'], PDO::PARAM_STR);
				}

				$stmt->execute();
			}
			
		} catch (PDOException $e){
			echo $e->getMessage();
		}	
		$affected = $stmt->RowCount();
		if ($affected == 0){
			echo "We could not update Debt.";
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
	<h2> Updated Data: </h2>
	<table>
		<tr>
			<th>Your data has been updated. Please go back to and opt to view this user ID to see the altered data</th>
	</table>
	<a href="../index.html" class="back-button">Home</a>
</body>
</html>

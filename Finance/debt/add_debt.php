<?php
	ini_set('display_errors', 1);
//Name: Ej Boakye
//Error handling added by Omari Harvey
/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
	if(isset($_POST['submit'])) { //Form was submitted
		
		try{
			require_once('../../../pdo_connect.php'); //adjust the relative path as necessary to find your connect file
			
			// added some error handling *Omari
			$DebtID = filter_input(INPUT_POST, 'DebtID', FILTER_VALIDATE_INT);
			$UserID = filter_input(INPUT_POST, 'UserID', FILTER_VALIDATE_INT);
			$Amount = filter_input(INPUT_POST, 'Amount', FILTER_VALIDATE_FLOAT);
			$InterestRate = filter_input(INPUT_POST, 'InterestRate', FILTER_VALIDATE_FLOAT);
			$PaymentDueDate = strip_tags($_POST['PaymentDueDate']);
			$DebtType = strip_tags($_POST['DebtType']);

			// Error handling for data types. Checks if the data is valid. *Omari
			if ($DebtID === false || $UserID === false || $Amount == false || $InterestRate == false || empty($PaymentDueDate) || empty($DebtType)) {
				echo "<h2>Invalid data. Please check your data and try again.</h2>";
				exit;
			}
			
			$sql = "INSERT INTO Debt (DebtID, UserID, DebtType, Amount, InterestRate, PaymentDueDate) 
			VALUES (:DebtID, :UserID, :DebtType, :Amount, :InterestRate, :PaymentDueDate)";
			
			$stmt = $dbc->prepare($sql);
			$stmt->bindParam(':DebtID', $DebtID, PDO::PARAM_INT);
			$stmt->bindParam(':UserID', $UserID, PDO::PARAM_INT);
			$stmt->bindParam(':Amount', $Amount, PDO::PARAM_STR);
			$stmt->bindParam(':InterestRate', $InterestRate, PDO::PARAM_STR);
			$stmt->bindParam(':PaymentDueDate', $PaymentDueDate, PDO::PARAM_STR);
			$stmt->bindParam(':DebtType', $DebtType, PDO::PARAM_STR);

			$stmt->execute();

			$selfJoinQuery = "SELECT 
								d1.DebtID AS DebtID1, 
								d1.Amount AS Amount1, 
								d2.DebtID AS DebtID2, 
								d2.Amount AS Amount2, 
								d1.DebtType 
							FROM Debt d1
							INNER JOIN Debt d2 
							ON d1.DebtType = d2.DebtType 
							AND d1.UserID = d2.UserID 
							AND d1.DebtID < d2.DebtID
							WHERE d1.UserID = :UserID";
			
			$selfJoinStmt = $dbc->prepare($selfJoinQuery);
			$selfJoinStmt->bindParam(':UserID', $UserID, PDO::PARAM_INT);
			$selfJoinStmt->execute();
			
			$selfJoinResults = $selfJoinStmt->fetchAll();
			if ($selfJoinResults) {
				echo "<h2>Similar Debts for User:</h2>";
				echo '<table border="1">';
				echo '<tr>
						<th>Debt Type</th>
						<th>DebtID 1</th>
						<th>Amount 1</th>
						<th>DebtID 2</th>
						<th>Amount 2</th>
					  </tr>';
				foreach ($selfJoinResults as $row) {
					echo '<tr>';
					echo '<td>' . htmlspecialchars($row['DebtType']) . '</td>';
					echo '<td>' . htmlspecialchars($row['DebtID1']) . '</td>';
					echo '<td>' . number_format($row['Amount1'], 2) . '</td>';
					echo '<td>' . htmlspecialchars($row['DebtID2']) . '</td>';
					echo '<td>' . number_format($row['Amount2'], 2) . '</td>';
					echo '</tr>';
				}
				echo '</table>';
			} else {
				echo "<h2>No similar debts found for this user.</h2>";
			}
		} catch (PDOException $e){
			echo $e->getMessage();
		}	
		$affected = $stmt->RowCount();
		if ($affected > 0){ // fixed this error as it was displaying unsuccesful on successful run * Omari
			echo "Data inserted successfully";
		}	
		else {
			echo "An error has occured. Please try again later.";
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
	<style>
        .back-button {
            display: inline-block;
            background-color: #1C3F3A;
            color: white;
            padding: 10px 20px;
            margin-top: 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .back-button:hover {
            background-color: #1C3F3A;
        }
    </style>
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
		echo "</tr>";
	?> 
	</table>
	<a href="../index.html" class="back-button">Home</a>
</body>
</html>
<?php
ini_set('display_errors', 1);
//Name: Caleb Yarborough
/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
if(isset($_POST['submit'])) { //Form was submitted

	try{
		require_once('../../../pdo_connect.php'); 
		$sql = 'UPDATE Savings SET CurrentAmount = :CurrentAmount, GoalAmount = :GoalAmount, GoalName = :GoalName, InterestRate = :InterestRate, TargetDate = :TargetDate WHERE SavingsID = :SavingsID AND UserID = :UserID';

		$stmt = $dbc->prepare($sql);
		$stmt->bindParam(':SavingsID', $_POST['SavingsID'], PDO::PARAM_INT);
		$stmt->bindParam(':UserID', $_POST['UserID'], PDO::PARAM_INT);
		$stmt->bindParam(':GoalName', $_POST['GoalName'], PDO::PARAM_STR);
		$stmt->bindParam(':CurrentAmount', $_POST['CurrentAmount'], PDO::PARAM_STR);
                $stmt->bindParam(':GoalAmount', $_POST['GoalAmount'], PDO::PARAM_STR);
		$stmt->bindParam(':InterestRate', $_POST['InterestRate'], PDO::PARAM_STR);
		$stmt->bindParam(':TargetDate', $_POST['TargetDate'], PDO::PARAM_STR);

		$stmt->execute();	
	} catch (PDOException $e){
		echo $e->getMessage();
	}	
	$affected = $stmt->RowCount();
	if ($affected == 0){
		echo "We could not update Savings.";
		exit;
	}	
	else {
		$result = $stmt->fetchAll();
	}
} 
else {
	echo "<h2>You have reached this page in error</h2>";
	exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Savings Submit result</title>
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
	<h2> Updated Data: </h2>
	<table>
		<tr>
            <th>Savings ID</th>
			<th>User ID</th>
			<th>Goal Name</th>
			<th>Current Amount</th>
            <th>Goal Amount</th>
			<th>Interest Rate</th>
			<th>Target Date</th>
        </tr> 
	<?php 
        echo "<tr>";
		echo "<td>".$_POST['SavingsID']."</td>";
		echo "<td>".$_POST['UserID']."</td>";
		echo "<td>".$_POST['GoalName']."</td>";
		echo "<td>".$_POST['CurrentAmount']."</td>";
        echo "<td>".$_POST['GoalAmount']."</td>";
		echo "<td>".$_POST['InterestRate']."</td>";
		echo "<td>".$_POST['TargetDate']."</td>";
		echo "</tr>";
	?>
    </table>
	<a href="../index.html" class="back-button">Home</a>
</body>
</html>

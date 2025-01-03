<?php
	ini_set('display_errors', 1);
//Name: Ej 
/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
	if(isset($_POST['submit'])) { //Form was submitted
		
		try {

			require_once('../../../pdo_connect.php'); //adjust the relative path as necessary to find your connect file

			$DebtID = filter_input(INPUT_POST, 'DebtID', FILTER_VALIDATE_INT);

			if ($DebtID === false) {
				echo "<h2>Invalid data. Please check your data and try again.</h2>";
				exit;
			}

			$stmt = $dbc->prepare("SELECT * FROM Debt WHERE DebtID = :DebtID ORDER BY DebtID");
			$stmt->bindParam(':DebtID', $_POST['DebtID'], PDO::PARAM_INT);
			$stmt->execute();

			$results = $stmt->fetchAll();
			if($results) {
				echo '<h1>Debt</h1>';
				echo '<table border="1">';
				echo '<tr><th>DebtID</th><th>UserID</th><th>DebtType</th><th>Amount</th><th>InterestRate</th><th>PaymentDueDate</th></tr>';
				foreach ($results as $row){
					echo '<tr>';
					echo '<td>' . $row['DebtID'] . '</td>';
					echo '<td>' . $row['UserID'] . '</td>';
					echo '<td>' . $row['DebtType'] . '</td>';
					echo '<td>' . $row['Amount'] . '</td>';
					echo '<td>' . $row['InterestRate'] . '</td>';
					echo '<td>' . $row['PaymentDueDate'] . '</td>';
					echo '</tr>';
				}
			}
		} catch (PDOException $e){
			echo $e->getMessage();
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
    <title>Update Income</title>
    <meta charset="utf-8">
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
    <a href="../index.html" class="back-button">Home</a>
</body>
</html>

<?php
ini_set("display_errors",1);
//Name: Omari Harvey
/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
if(isset($_POST['submit'])) { //Form was submitted
		
	try{
		require_once('../../../pdo_connect.php'); 

        $UserID = filter_input(INPUT_POST,'UserID', FILTER_VALIDATE_INT);

        if ($UserID === false) {
            echo "<h2>Invalid data. Please check your data and try again.</h2>";
            exit;
        }

        $s = "SELECT CalculateTotalSavings(:UserID) AS TotalSavings";

        $stmt = $dbc->prepare($s);
        $stmt->bindParam(':UserID', $UserID, PDO::PARAM_INT);
        
		$stmt->execute();	
            
	} catch (PDOException $e){
		echo $e->getMessage();
	}	
	$result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $totalSavings = $result['TotalSavings'];
    } else {
        echo "<h2>No data found for the specified UserID.</h2>";
        exit;
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
    <title>Savings Submit Result</title>
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
    <h2>Calculated Total Savings:</h2>
    <table>
        <tr>
            <th>UserID</th>
            <th>Total Savings</th>
        </tr>
        <tr>
            <td><?php echo htmlspecialchars($UserID); ?></td>
            <td><?php echo number_format($totalSavings, 2); ?></td>
        </tr>
    </table>
    <a href="../index.html" class="back-button">Home</a>
</body>
</html>

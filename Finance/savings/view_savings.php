<?php
ini_set('display_errors', 1);
//Name: Caleb Yarborough
/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
if (isset($_POST['submit'])) { // Form was submitted
    try {
        require_once('../../../pdo_connect.php'); // Adjust the relative path as necessary to find your connect file

        // SQL query to fetch records based on UserID
        $sql = "SELECT * FROM Savings WHERE UserID = :UserID ORDER BY SavingsID";

        $stmt = $dbc->prepare($sql);
        $stmt->bindParam(':UserID', $_POST['UserID'], PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Fetch all matching records
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if any records were found
        if (empty($result)) {
            echo "No savings records found for the provided UserID.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
} else {
    echo "<h2>You have reached this page in error</h2>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Savings</title>
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
    <h2>View Savings for UserID: <?php echo htmlspecialchars($_POST['UserID']); ?></h2>
    <table border="1">
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
        // Loop through the result and display each row
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['SavingsID']) . "</td>";
            echo "<td>" . htmlspecialchars($row['UserID']) . "</td>";
            echo "<td>" . htmlspecialchars($row['GoalName']) . "</td>";
            echo "<td>" . htmlspecialchars($row['CurrentAmount']) . "</td>";
            echo "<td>" . htmlspecialchars($row['GoalAmount']) . "</td>";
            echo "<td>" . htmlspecialchars($row['InterestRate']) . "</td>";
            echo "<td>" . htmlspecialchars($row['TargetDate']) . "</td>";
            echo "</tr>";
        }
    ?> 
    </table>
    <a href="../index.html" class="back-button">Home</a>
</body>
</html>

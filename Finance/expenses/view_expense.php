<?php
ini_set('display_errors', 1);

// Check if the form was submitted
if (isset($_POST['submit'])) {
    try {
        require_once('../../../pdo_connect.php'); // Adjust path to your database connection file

        // Prepare SQL query to fetch records based on UserID
        $sql = "SELECT * FROM Expenses WHERE UserID = :UserID ORDER BY ExpenseID";

        $stmt = $dbc->prepare($sql);
        $stmt->bindParam(':UserID', $_POST['UserID'], PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Fetch all matching records
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if any records were found
        if (empty($result)) {
            echo "No expense records found for the provided UserID.";
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
    <title>View Expenses</title>
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
    <h2>View Expenses for UserID: <?php echo htmlspecialchars($_POST['UserID']); ?></h2>
    <table border="1">
        <tr> 
            <th>Expense ID</th>
            <th>User ID</th>
            <th>Expense Type</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
    <?php 
        // Loop through the result and display each row
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['ExpenseID']) . "</td>";
            echo "<td>" . htmlspecialchars($row['UserID']) . "</td>";
            echo "<td>" . htmlspecialchars($row['ExpenseType']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Amount']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Date']) . "</td>";
            echo "</tr>";
        }
    ?> 
    </table>
    <a href="../index.html" class="back-button">Home</a>
</body>
</html>
